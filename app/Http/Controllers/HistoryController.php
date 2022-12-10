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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Exports\WaExport;

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
                ->where('was.api', 'like', '%' .$search->api . '%');
        if(!empty($search->tanggal_awal)){
                $query->where('was.created_at','>=', $search->tanggal_awal ); }
        if(!empty($search->tanggal_akhir)){
                $query->where('was.created_at','<=', $tanggal_akhir ); }

        $result= $query->get();

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
}
