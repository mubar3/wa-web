<?php

namespace App\Http\Controllers;

use App\Exports\NewUserNAExport;
use App\Models\BPMember;
use App\Models\wa;
use App\Models\contact;
use App\Models\sending;
use App\Models\MobileAgent;
use App\Models\Visit;
use App\Models\api_was;
use App\Models\Inbox;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Exports\WaExport;
use App\Exports\WaExportInbox;

class HistoryController extends Controller
{
    public function data_history_all(){    
        $tanggal=Carbon::now();
        $tanggal=$tanggal->toDateString();     
        return wa::select('*','was.telpon as telpon','was.created_at as dikirim')->leftjoin('contact', 'was.telpon', '=', 'contact.telpon')->where('was.created_at','>=', $tanggal )->orderBy('was.created_at','desc')->get();

        // $second = wa::select('*','contact.nama as nama','was.created_at as dikirim')->leftjoin('contact', 'was.telpon', '=', 'contact.telpon')->orderBy('was.created_at','desc');

        // return wa::select('*','contact.nama as nama','was.created_at as dikirim')->rightjoin('contact', 'was.telpon', '=', 'contact.telpon')->orderBy('was.created_at','desc')
        //     ->unionAll($second)->take(500)
        //     ->get();

    }

    public function data_history($nama){        
        return wa::select('*','was.telpon as telpon','was.created_at as dikirim')->leftjoin('contact', 'was.telpon', '=', 'contact.telpon')->where('contact.nama', 'like', '%' .$nama . '%')->orwhere('was.pesan', 'like', '%' .$nama . '%')->orderBy('was.created_at','desc')->get();
    }

    public function search_history(Request $search){ 
        if(!empty($search->tanggal_akhir)){
        $tanggal_akhir=Carbon::createFromFormat('Y-m-d', $search->tanggal_akhir);
        $tanggal_akhir=$tanggal_akhir->addDays(1);
        $tanggal_akhir=$tanggal_akhir->toDateString();  
        }       
        
        $query = wa::select('*','was.telpon as telpon','was.created_at as dikirim')
                ->leftjoin('contact', 'was.telpon', '=', 'contact.telpon')
                ->leftjoin('api_was', 'api_was.url', '=', 'was.api')
                ->where('api_was.tipe_id', 'like', '%' .$search->tipe . '%')
                ->where('was.api', 'like', '%' .$search->api . '%')
                ->where('was.jenis', 'like', '%' .$search->jenis . '%');
        if(!empty($search->tanggal_awal)){
                $query->where('was.created_at','>=', $search->tanggal_awal ); }
        if(!empty($search->tanggal_akhir)){
                $query->where('was.created_at','<=', $tanggal_akhir ); }

        $result= $query->orderBy('was.created_at','desc')->get();

        return $result;
        // return $tanggal_akhir;
    }

    public function download_excel(Request $data)
    {
        // $history=wa::all();
        // return $history;
        // return Excel::download(new WaExport($data->api,$data->tanggal_awal,$data->tanggal_akhir), 'users.xlsx');
        $dt = Carbon::now();
        return Excel::download(new WaExport($data), 'history_'.$dt.'.xlsx');
        // return Excel::download($history, 'users.xlsx');
        // return $data;
    }

    public function data_historyinbox_all(){    
        $tanggal=Carbon::now();
        $tanggal=$tanggal->toDateString();  
        $result=Inbox::select(
                '*',
                'inboxes.nama as nama_inbox',
                'inboxes.telpon as telpon',
                'inboxes.created_at as dikirim',
                DB::raw("CASE WHEN inboxes.file = '' THEN NULL ELSE CONCAT('".url('/storage/inbox')."','/',inboxes.file) END AS file"),
            )
            ->leftjoin('contact', 'inboxes.telpon', '=', 'contact.telpon')
            ->where('inboxes.created_at','>=', $tanggal )
            ->orderBy('inboxes.created_at','desc')
            ->get();
        

        foreach ($result as $key) {
            if(!$this->isNullOrEmpty($key->koordinat)){
                $koordinat=json_decode($key->koordinat,true);
                $key->koordinat='https://maps.google.com/?q='.$koordinat['lat'].','.$koordinat['long'];
            }
        }   
        return $result;
    }

    public function search_historyinbox(Request $search){ 
        if(!empty($search->tanggal_akhir)){
            $tanggal_akhir=Carbon::createFromFormat('Y-m-d', $search->tanggal_akhir);
            $tanggal_akhir=$tanggal_akhir->addDays(1);
            $tanggal_akhir=$tanggal_akhir->toDateString();  
        }       
        
        $query = Inbox::select(
                    '*',
                    'inboxes.nama as nama_inbox',
                    'inboxes.telpon as telpon',
                    'inboxes.created_at as dikirim',
                    DB::raw("CASE WHEN inboxes.file = '' THEN NULL ELSE CONCAT('".url('/storage/inbox')."','/',inboxes.file) END AS file"),
                )
                ->leftjoin('contact', 'inboxes.telpon', '=', 'contact.telpon')
                ->leftjoin('api_was', 'api_was.url', '=', 'inboxes.api')
                ->where('api_was.tipe_id', 'like', '%' .$search->tipe . '%')
                ->where('inboxes.api', 'like', '%' .$search->api . '%')
                ->where('inboxes.jenis', 'like', '%' .$search->jenis . '%');
        if(!empty($search->tanggal_awal)){
                $query->where('inboxes.created_at','>=', $search->tanggal_awal ); }
        if(!empty($search->tanggal_akhir)){
                $query->where('inboxes.created_at','<=', $tanggal_akhir ); }

        $result= $query->orderBy('inboxes.created_at','desc')->get();

        foreach ($result as $key) {
            if(!$this->isNullOrEmpty($key->koordinat)){
                $koordinat=json_decode($key->koordinat,true);
                $key->koordinat='https://maps.google.com/?q='.$koordinat['lat'].','.$koordinat['long'];
            }
        }

        return $result;
    }

    public function get_chat(Request $data) 
    {
        $validator = Validator::make($data->all(),[
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',  
            'tipe' => 'required',  
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'false','message'=>'parameter tidak sesuai']);
        }
        $list_wa=wa::select(
                'contact.nama',
                'was.telpon',
            )
            ->leftjoin('contact','contact.telpon','=','was.telpon')
            ->leftjoin('api_was','api_was.url','=','was.api')
            ->where('api_was.tipe_id',$data->tipe)
            ->whereBetween('was.created_at',[$data->tanggal_awal,$data->tanggal_akhir.' 23:00'])
            ->groupBy('was.telpon')
            ->get();

        foreach ($list_wa as $key) {
            $outbox=wa::select(
                    DB::raw('"pengirim" as status'),
                    'pesan',
                    'jenis',
                    'file',
                    'status_kirim',
                    'read',
                    DB::raw('created_at as dikirim'),
                )
                ->where('telpon',$key->telpon)
                ->whereBetween('created_at',[$data->tanggal_awal,$data->tanggal_akhir.' 23:00']);
                // ->get();
            $inbox_outbox=Inbox::select(
                    DB::raw('"penerima" as status'),
                    'pesan',
                    'jenis',
                    DB::raw("CASE WHEN file = '' THEN null ELSE CONCAT('".url('/storage/inbox')."','/',file) END AS file"),
                    DB::raw('null as status_kirim'),
                    DB::raw('null as "read"'),
                    DB::raw('created_at as dikirim'),
                )
                ->where('telpon',$this->formatNumber($key->telpon))
                ->whereBetween('created_at',[$data->tanggal_awal,$data->tanggal_akhir.' 23:00'])
                ->union($outbox)
                ->orderBy('dikirim')
                ->get();
            $key['chat']=$inbox_outbox;
        }
        return response()->json(['status'=>'true','message'=>'Sukses','data'=>$list_wa]);
    }

    public function download_excelinbox(Request $data)
    {
        // $history=wa::all();
        // return $history;
        // return Excel::download(new WaExport($data->api,$data->tanggal_awal,$data->tanggal_akhir), 'users.xlsx');
        $dt = Carbon::now();
        return Excel::download(new WaExportInbox($data), 'history-inbox_'.$dt.'.xlsx');
        // return Excel::download($history, 'users.xlsx');
        // return $data;
    }
}
