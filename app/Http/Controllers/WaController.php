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

class WaController extends Controller
{
    public function random_api()
    {   
        $output=array();

        $data=api_was::where('status',1)->get();
        foreach ($data as $data) {
            array_push($output,$data->url);
        }

        $total=count($output);
        $max=$total-1;
        
        return $output[rand(0,$max)];
    }

    
    public function sent_wa(Request $data)
    {
        // print($data->no_hp);
        // echo 1;
        // print($this->generateUniqueCode());
        // die();
        $validator = Validator::make($data->all(),[
            'no_hp' => 'required|numeric|min:11',
            'pesan' => 'required'
        ]);
        if($validator->fails()){
            // return redirect(route('home'))->with([
            //     'pesan' => '<div class="alert alert-danger">Harap masukkan NO WA yang sesuai</div>'
            // ]);      
            return response()->json(['status'=>'false']);
        }
        // $port=rand(1,3);
        // $port='800'.$port;
        // $url='http://srv.geogiven.co.id:'.$port.'/send-message';
        // echo $url;
        // die();
        $url=$this->random_api();
        $eror=0;
        try {
            $response = Http::post($url, [
                'number' => $data->no_hp,
                'message' => $data->pesan
            ]);
        } catch(\Illuminate\Http\Client\ConnectionException $e)
        {
            $eror=1;
        }
        if($eror==1){
            $response=0;
        }else{
            $response = json_decode($response);
            $response=$response->status;
        }
        // $response = json_decode($response);
        // $response=$response->status;
        $user = wa::create([
            'telpon' => $data->no_hp,
            'pesan' => $data->pesan,
            'api' => $url,
            'status_kirim' => $response,
            'created_at' => Carbon::now()
         ]);
        if($user){
          return response()->json(['status'=>'true']);}else{
            return response()->json(['status'=>'false']);
          }

        // if($user){
        // return redirect(route('sender'))->with([
        //         'pesan' => '<div class="alert alert-success">Pengiriman Berhasil</div>'
        //     ]);
        // }else{
        // return redirect(route('sender'))->with([
        //         'pesan' => '<div class="alert alert-danger">Pengiriman Gagal</div>'
        //     ]);

        // }
    }

     public function sent_wa_excel(Request $datas)
    {
        $validator = Validator::make($datas->all(),[
            'excel' => 'required|mimes:csv,xls,xlsx'
        ]);
        if($validator->fails()){
            // return redirect(route('home'))->with([
            //     'pesan_excel' => '<div class="alert alert-danger">Harap upload file Excel</div>'
            // ]);      
            return response()->json(['status'=>'false']);
        }

        // $path = $datas->file('excel')->getRealPath();
        $path = $datas->file('excel');
        // $ext  = $datas->file('excel')->getClientOriginalExtension();
        // $excel = $this->generateUniqueCodeUser().'.'.$ext;

        // $data1=$datas->file('excel')->move(public_path('/storage'),$excel);;
        // response()->download(public_path('/storage').'/'.$excel,'asa.pdf');
        // $data = Excel::toArray([],public_path('/storage').'/'.$excel);
        $data = Excel::toArray([],$path);
        
        $total_data=count($data[0])-1;
        ini_set('max_execution_time', 1000000);

        $userid='';
        if(!empty($datas->user)){
            $userid=$datas->user;
        }else{$userid=$this->generateUniqueCodeUser();}
        // echo $user;
        // die();
         
          for($x=1;$x<count($data[0]);$x++){
                // $port=rand(1,3);
                // $port='800'.$port;
                // $url='http://srv.geogiven.co.id:'.$port.'/send-message';
                $url=$this->random_api();
                $eror=0;
                // print_r($data[0][$x][1]);
                // die();
                try {
                    $response = Http::post($url, [
                        'number' => $data[0][$x][1],
                        'message' => $data[0][$x][2]
                    ]);
                } catch(\Illuminate\Http\Client\ConnectionException $e)
                {
                    $eror=1;
                }
                if($eror==1){
                    $response=0;
                }else{
                    $response = json_decode($response);
                    $response=$response->status;
                }
                // $response = json_decode($response);
                // $response=$response->status;
                $user = sending::create([
                'id_user' => $userid,
                'telpon' => $data[0][$x][1],
                'jumlah' => $total_data,
                'created_at' => Carbon::now()
                ]);
                $user = wa::create([
                'telpon' => $data[0][$x][1],
                'pesan' => $data[0][$x][2],
                'api' => $url,
                'status_kirim' => $response,
                'created_at' => Carbon::now()
                ]);
            sleep(rand(1,2));
          }

          $user = sending::where('id_user',$userid)->delete();
         if($user){
          return response()->json(['status'=>'true']);}else{
            return response()->json(['status'=>'false']);
          }

        //   if($user){
        // return redirect(route('bulk'))->with([
        //         'pesan_excel' => '<div class="alert alert-success">Pengiriman Berhasil</div>'
        //     ]);
        // }else{
        // return redirect(route('bulk'))->with([
        //         'pesan_excel' => '<div class="alert alert-danger">Pengiriman Gagal</div>'
        //     ]);

        // }
    }

    public function sent_wa_cek()
    {   
        if (Auth::check()) {
            $sending = DB::table('sending')->where('id_user',Auth::user()->id)->get();
            if($sending){
                // print_r(count($sending));
                if(count($sending)==0){echo 0;}else{
                $sending_count=$sending->count();
                // echo $sending[0]->jumlah;
                $hasil=($sending_count/$sending[0]->jumlah)*100;
                echo $hasil;
                }
            }else{
                echo 0;
            }
        }else{echo 0;}
    }

    public function generateUniqueCodeUser()
    {

    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersNumber = strlen($characters);
    $codeLength = 6;

    $code = '';

    while (strlen($code) < 6) {
        $position = rand(0, $charactersNumber - 1);
        $character = $characters[$position];
        $code = $code.$character;
    }

    if (sending::where('id_user', $code)->exists()) {
        $this->generateUniqueCode();
    }

    return $code;

    }
}
