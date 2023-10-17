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
use App\Models\Api_running;
use App\Models\Inbox;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;


class WaController extends Controller
{
    public function random_api($tipe='',$no,$same_api='')
    {   
        if($this->jenis_umum == 'single'){
            return $this->random_api_single($tipe,$no,$same_api);
        }else{
            return $this->random_api_multiple($tipe,$no,$same_api);
        }
    }

    public function random_api_single($tipe='',$no,$same_api='')
    {   
        $data_running=[];
        if(empty($tipe)){
            $running=Api_running::select('api_runnings.*')
                ->join('api_was','api_was.id','=','api_runnings.api_id')
                ->whereIn('api_was.tipe_id',$this->tipeid_umum)
                ->where('api_was.jenis','single')
                ->get();
        }else{
            $running=Api_running::select('api_runnings.*')
                ->join('api_was','api_was.id','=','api_runnings.api_id')
                ->where('api_was.tipe_id',$tipe)
                ->where('api_was.jenis','single')
                ->get();
        }
        foreach ($running as $key ) {
            array_push($data_running,$key->api_id);
        }

        // kirim ke api sama yang terakhir di riwayat
        if(!empty($same_api) && $same_api == 'y'){
            $cek_history=wa::leftjoin('api_was','api_was.url','=','was.api')
                ->where('api_was.jenis','single')
                ->where('api_was.status',1);
            
                if(empty($tipe)){
                    $cek_history=$cek_history->whereIn('tipe_id',$this->tipeid_umum);
                }else{
                    $cek_history=$cek_history->where('tipe_id',$tipe);
                }

            $cek_history=$cek_history->where('was.telpon',$no)
                ->orderBy('was.created_at','desc')
                ->first();
            if($cek_history){
                return $cek_history->api;
            }else{
                return '';
            }
        }

        $output=array();
        if(empty($tipe)){
            $data_api=[];
            $data=api_was::where('status',1)
                ->whereIn('tipe_id',$this->tipeid_umum)
                ->where('api_was.jenis','single')
                ->get();
            if(count($data) < 1){
                return '';
            }
            foreach ($data as $key) {
                array_push($data_api,$key->id);
            }

            // cek api running
            $api_tersedia=array_values(array_diff($data_api, $data_running));

            // ketika running semua
            if(empty($api_tersedia) && !empty($data_running)){
                Api_running::whereIn('api_id',$data_running)->delete();
                $data=api_was::where('status',1)
                    ->whereIn('tipe_id',$this->tipeid_umum)
                    ->where('api_was.jenis','single')
                    ->first();
                Api_running::create(['api_id' => $data->id]);
                return $data->url;
            }
            
            if(!empty($api_tersedia)){
                $data=api_was::find($api_tersedia[0]);
                Api_running::create(['api_id' => $api_tersedia[0]]);
                return $data->url;
            }

        }else{
            $data_api=[];
            $data=api_was::where('status',1)
                ->where('tipe_id',$tipe)
                ->where('api_was.jenis','single')
                ->get();
            if(count($data) < 1){
                return '';
            }
            foreach ($data as $key) {
                array_push($data_api,$key->id);
            }

            // cek api running
            $api_tersedia=array_values(array_diff($data_api, $data_running));
            // ketika running semua
            if(empty($api_tersedia) && !empty($data_running)){
                Api_running::whereIn('api_id',$data_running)->delete();
                $data=api_was::where('status',1)
                    ->where('tipe_id',$tipe)
                    ->where('api_was.jenis','single')
                    ->first();
                Api_running::create(['api_id' => $data->id]);
                return $data->url;
            }
            
            if(!empty($api_tersedia)){
                $data=api_was::find($api_tersedia[0]);
                Api_running::create(['api_id' => $api_tersedia[0]]);
                return $data->url;
            }
        }
    }

    public function random_api_multiple($tipe='',$no,$same_api='')
    {   
        $data_running=[];
        if(empty($tipe)){
            $running=Api_running::select('api_runnings.*')
                ->join('api_was','api_was.id','=','api_runnings.api_id')
                ->whereIn('api_was.tipe_id',$this->tipeid_umum)
                ->where('api_was.jenis','multiple')
                ->get();
        }else{
            $running=Api_running::select('api_runnings.*')
                ->join('api_was','api_was.id','=','api_runnings.api_id')
                ->where('api_was.tipe_id',$tipe)
                ->where('api_was.jenis','multiple')
                ->get();
        }
        foreach ($running as $key ) {
            array_push($data_running,$key->api_id);
        }

        // kirim ke api sama yang terakhir di riwayat
        if(!empty($same_api) && $same_api == 'y'){
            $cek_history=wa::leftjoin('api_was','api_was.url','=','was.api')
                ->where('api_was.jenis','multiple')
                ->where('api_was.status',1);
            
                if(empty($tipe)){
                    $cek_history=$cek_history->whereIn('tipe_id',$this->tipeid_umum);
                }else{
                    $cek_history=$cek_history->where('tipe_id',$tipe);
                }

            $cek_history=$cek_history->where('was.telpon',$no)
                ->orderBy('was.created_at','desc')
                ->first();
            if($cek_history){
                return $cek_history->api;
            }else{
                return '';
            }
        }

        $output=array();
        if(empty($tipe)){
            $data_api=[];
            $data=api_was::where('status',1)
                ->whereIn('tipe_id',$this->tipeid_umum)
                ->where('api_was.jenis','multiple')
                ->get();
            if(count($data) < 1){
                return '';
            }
            foreach ($data as $key) {
                array_push($data_api,$key->id);
            }

            // cek api running
            $api_tersedia=array_values(array_diff($data_api, $data_running));

            // ketika running semua
            if(empty($api_tersedia) && !empty($data_running)){
                Api_running::whereIn('api_id',$data_running)->delete();
                $data=api_was::where('status',1)
                    ->whereIn('tipe_id',$this->tipeid_umum)
                    ->where('api_was.jenis','multiple')
                    ->first();
                Api_running::create(['api_id' => $data->id]);
                return $data->url;
            }
            
            if(!empty($api_tersedia)){
                $data=api_was::find($api_tersedia[0]);
                Api_running::create(['api_id' => $api_tersedia[0]]);
                return $data->url;
            }

        }else{
            $data_api=[];
            $data=api_was::where('status',1)
                ->where('tipe_id',$tipe)
                ->where('api_was.jenis','multiple')
                ->get();
            if(count($data) < 1){
                return '';
            }
            foreach ($data as $key) {
                array_push($data_api,$key->id);
            }

            // cek api running
            $api_tersedia=array_values(array_diff($data_api, $data_running));
            // ketika running semua
            if(empty($api_tersedia) && !empty($data_running)){
                Api_running::whereIn('api_id',$data_running)->delete();
                $data=api_was::where('status',1)
                    ->where('tipe_id',$tipe)
                    ->where('api_was.jenis','multiple')
                    ->first();
                Api_running::create(['api_id' => $data->id]);
                return $data->url;
            }
            
            if(!empty($api_tersedia)){
                $data=api_was::find($api_tersedia[0]);
                Api_running::create(['api_id' => $api_tersedia[0]]);
                return $data->url;
            }
        }
    }

    
    public function sent_wa(Request $data)
    {
        $validator = Validator::make($data->all(),[
            'no_hp' => 'required|numeric|min:11',
            'pesan' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'false','message'=>'parameter tidak sesuai']);
        }
        $url=$this->random_api(isset($data->tipe)?$data->tipe:'' , $data->no_hp , isset($data->same_api)?$data->same_api:'');
        if(empty($url)){
            return response()->json(['status'=>'false','message'=>'koneksi api wa tidak tersedia']);
        }
        $eror=0;
        $id_wa=null;
        try {
            if($this->jenis_umum == 'single'){
                $response = Http::post($url, [
                    'number' => $data->no_hp,
                    'message' => $data->pesan
                ]);
            }else{
                $response = Http::post($this->deleteRouteNames($url).'/send-message', [
                    'sender' => $this->getFirstRouteFromURL($url),
                    'number' => $data->no_hp,
                    'message' => $data->pesan
                ]);
            }
        } catch(\Illuminate\Http\Client\ConnectionException $e)
        {
            $eror=1;
        }
        if($eror==1){
            $response=0;
        }else{
            $response = json_decode($response);
            $id_wa=$response->response->id->id;
            $response=$response->status;
            if(!$response){
                $eror=1;
            }
        }
        $user = wa::create([
            'id_wa' => $id_wa,
            'telpon' => $data->no_hp,
            'pesan' => $data->pesan,
            'api' => $url,
            'status_kirim' => $response,
            'created_at' => Carbon::now()
         ]);
        // if($user){
        if($eror==0){
          return response()->json(['status'=>'true','message'=>'Sukses']);}
        else{
            return response()->json(['status'=>'false','message'=>'Gagal']);
          }
    }

    
    public function sent_file(Request $data)
    {
        $validator = Validator::make($data->all(),[
            'no_hp' => 'required|numeric|min:11',
            // 'pesan' => 'required',
            'file' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'false','message'=>'parameter tidak sesuai']);
        }
        
        // cek ekstensi apakah ada
        if(!$this->hasExtension($data->file)){
            return response()->json(['status'=>'false','message'=>'ekstensi file tidak valid']);
        }

        $url=$this->random_api(isset($data->tipe)?$data->tipe:'', $data->no_hp , isset($data->same_api)?$data->same_api:'');
        if(empty($url)){
            return response()->json(['status'=>'false','message'=>'koneksi api wa tidak tersedia']);
        }
        $eror=0;
        $id_wa=null;
        // return $this->deleteRouteNames($url).'/send-media';
        try {
            if($this->jenis_umum == 'single'){
                $response = Http::post($this->deleteRouteNames($url).'/send-media', [
                    'number' => $data->no_hp,
                    'caption' => $data->pesan,
                    'file' => $data->file
                ]);
            }else{
                $response = Http::post($this->deleteRouteNames($url).'/send-media', [
                    'sender' => $this->getFirstRouteFromURL($url),
                    'number' => $data->no_hp,
                    'caption' => $data->pesan,
                    'file' => $data->file
                ]);
            }
        } catch(\Illuminate\Http\Client\ConnectionException $e)
        {
            $eror=1;
        }
        if($eror==1){
            $response=0;
        }else{
            $response = json_decode($response);
            $id_wa=$response->response->id->id;
            $response=$response->status;
            if(!$response){
                $eror=1;
            }
        }
        $user = wa::create([
            'id_wa' => $id_wa,
            'telpon' => $data->no_hp,
            'pesan' => $data->pesan,
            'file' => $data->file,
            'api' => $url,
            'jenis' => 'file',
            'status_kirim' => $response,
            'created_at' => Carbon::now()
         ]);
        // if($user){
        if($eror==0){
          return response()->json(['status'=>'true','message'=>'Sukses']);}
        else{
            return response()->json(['status'=>'false','message'=>'Gagal']);
          }
    }

    public function cek_number(Request $data)
    {
        $validator = Validator::make($data->all(),[
            'no_hp' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'false','message'=>'parameter tidak sesuai']);
        }

        $url=$this->random_api(isset($data->tipe)?$data->tipe:'', $data->no_hp , '');
        if(empty($url)){
            return response()->json(['status'=>'false','message'=>'koneksi api wa tidak tersedia']);
        }
        $eror=0;
        try {
            if($this->jenis_umum == 'single'){
                $response = Http::post($this->deleteRouteNames($url).'/check-number', [
                    'number' => $data->no_hp,
                ]);
            }else{
                $response = Http::post($this->deleteRouteNames($url).'/check-number', [
                    'sender' => $this->getFirstRouteFromURL($url),
                    'number' => $data->no_hp,
                ]);
            }
        } catch(\Illuminate\Http\Client\ConnectionException $e)
        {
            $eror=1;
        }
        
        if($eror==0 && json_decode($response)->status){
          return response()->json(['status'=>'true','message'=>'Sukses']);}
        else{
            return response()->json(['status'=>'false','message'=>'Gagal']);
          }
    }

    public function sent_wa_excel(Request $datas)
    {
        $validator = Validator::make($datas->all(),[
            'excel' => 'required|mimes:csv,xls,xlsx'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'false','message'=>'parameter tidak sesuai']);
        }


        $path = $datas->file('excel');
        $data = Excel::toArray([],$path);
        
        $total_data=count($data[0])-1;
        ini_set('max_execution_time', 1000000);

        $userid='';
        if(!empty($datas->user)){
            $userid=$datas->user;
        }else{$userid=$this->generateUniqueCodeUser();}
        $tipe=isset($datas->tipe)?$datas->tipe:'';
        $same_api=isset($datas->same_api)?$datas->same_api:'';
          for($x=1;$x<count($data[0]);$x++){
                $url=$this->random_api($tipe, $data[0][$x][1] , $same_api);
                if(empty($url)){
                    return response()->json(['status'=>'false','message'=>'koneksi api wa tidak tersedia']);
                }
                $eror=0;
                $id_wa=null;
                try {
                    if($this->jenis_umum == 'single'){
                        $response = Http::post($url, [
                            'number' => $data[0][$x][1],
                            'message' => $data[0][$x][2]
                        ]);
                    }else{
                        $response = Http::post($this->deleteRouteNames($url).'/send-message', [
                            'sender' => $this->getFirstRouteFromURL($url),
                            'number' => $data[0][$x][1],
                            'message' => $data[0][$x][2]
                        ]);
                    }
                } catch(\Illuminate\Http\Client\ConnectionException $e)
                {
                    $eror=1;
                }
                if($eror==1){
                    $response=0;
                }else{
                    $response = json_decode($response);
                    $id_wa=$response->response->id->id;
                    $response=$response->status;
                }
                $user = sending::create([
                'id_user' => $userid,
                'telpon' => $data[0][$x][1],
                'jumlah' => $total_data,
                'created_at' => Carbon::now()
                ]);
                $user = wa::create([
                'id_wa' => $id_wa,
                'telpon' => $data[0][$x][1],
                'pesan' => $data[0][$x][2],
                'api' => $url,
                'status_kirim' => $response,
                'created_at' => Carbon::now()
                ]);
            sleep(rand($this->random_bulk_time,$this->random_bulk_time_to));
          }

          $user = sending::where('id_user',$userid)->delete();
         if($user){
          return response()->json(['status'=>'true','message'=>'Sukses']);}else{
            return response()->json(['status'=>'false','message'=>'Gagal']);
          }
    }

    public function sent_wa_json(Request $datas)
    {
        $validator = Validator::make($datas->all(),[
            'json' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'false','message'=>'parameter tidak sesuai']);
        }

        $json=json_decode($datas->json,true);
        ini_set('max_execution_time', 1000000);

        $tipe=isset($datas->tipe)?$datas->tipe:'';
        $same_api=isset($datas->same_api)?$datas->same_api:'';
        foreach ($json as $key){
            $url=$this->random_api($tipe , $key['number'] , $same_api);
            if(empty($url)){
                return response()->json(['status'=>'false','message'=>'koneksi api wa tidak tersedia']);
            }
            $eror=0;
            try {
                if($this->jenis_umum == 'single'){
                    $response = Http::post($url, [
                        'number' => $key['number'],
                        'message' => $key['message']
                    ]);
                }else{
                    $response = Http::post($this->deleteRouteNames($url).'/send-message', [
                        'sender' => $this->getFirstRouteFromURL($url),
                        'number' => $key['number'],
                        'message' => $key['message']
                    ]);
                }
            } catch(\Illuminate\Http\Client\ConnectionException $e)
            {
                return response()->json(['status'=>'false','message'=>'Gagal']);
            }

            $user = wa::create([
                'id_wa' => json_decode($response)->response->id->id,
                'telpon' => $key['number'],
                'pesan' => $key['message'],
                'api' => $url,
                'status_kirim' => 1,
                'created_at' => Carbon::now()
            ]);
            sleep(rand($this->random_bulk_time,$this->random_bulk_time_to));
        }

        return response()->json(['status'=>'true','message'=>'Sukses']);
    }

    public function sent_file_json(Request $datas)
    {
        $validator = Validator::make($datas->all(),[
            'json' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'false','message'=>'parameter tidak sesuai']);
        }

        $json=json_decode($datas->json,true);
        ini_set('max_execution_time', 1000000);

        $tipe=isset($datas->tipe)?$datas->tipe:'';
        $same_api=isset($datas->same_api)?$datas->same_api:'';

        // pengecekan 
        foreach ($json as $key){
            if(!$this->hasExtension($key['file'])){
                return response()->json(['status'=>'false','message'=>'ekstensi file ada yang tidak valid']);
            }
            if(empty($key['number'])){
                return response()->json(['status'=>'false','message'=>'terdapat nomor kosong']);
            }
        }

        foreach ($json as $key) {
            $url=$this->random_api($tipe , $key['number'] , $same_api);
            if(empty($url)){
                return response()->json(['status'=>'false','message'=>'koneksi api wa tidak tersedia']);
            }
            $eror=0;
            $id_wa=null;
            try {
                if($this->jenis_umum == 'single'){
                    $response = Http::post($this->deleteRouteNames($url).'/send-media', [
                        'number' => $key['number'],
                        'caption' => $key['message'],
                        'file' => $key['file']
                    ]);
                }else{
                    $response = Http::post($this->deleteRouteNames($url).'/send-media', [
                        'sender' => $this->getFirstRouteFromURL($url),
                        'number' => $key['number'],
                        'caption' => $key['message'],
                        'file' => $key['file']
                    ]);
                }
            } catch(\Illuminate\Http\Client\ConnectionException $e)
            {
                $eror=1;
            }
            if($eror==1){
                $response=0;
            }else{
                $response = json_decode($response);
                $id_wa=$response->response->id->id;
                $response=$response->status;
            }
            $user = wa::create([
                'id_wa' => $id_wa,
                'telpon' => $key['number'],
                'pesan' => $key['message'],
                'file' => $key['file'],
                'jenis' => 'file',
                'api' => $url,
                'status_kirim' => $response,
                'created_at' => Carbon::now()
            ]);

            sleep(rand($this->random_bulk_time,$this->random_bulk_time_to));
        }

        return response()->json(['status'=>'true','message'=>'Sukses']);
    }

    public function sent_wa_cek()
    {   
        if (Auth::check()) {
            $sending = DB::table('sending')->where('id_user',Auth::user()->id)->get();
            if($sending){
                if(count($sending)==0){echo 0;}else{
                $sending_count=$sending->count();
                $hasil=($sending_count/$sending[0]->jumlah)*100;
                echo $hasil;
                }
            }else{
                echo 0;
            }
        }else{echo 0;}
    }

    public function make_read(Request $data)  
    {
        $validator = Validator::make($data->all(),[
            'id_wa' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'false','message'=>'parameter tidak sesuai']);
        }
        $cek_id=wa::where('id_wa',$data->id_wa)->first();
        if(!$cek_id){
            return response()->json(['status'=>'false','message'=>'Id tidak tersedia']);
        }
        $cek_id->update(['read'=>'y','updated_at'=>Carbon::now()]);
        return response()->json(['status'=>'true','message'=>'Berhasil']);
        
    }

    public function inbox(Request $data) 
    {
        $validator = Validator::make($data->all(),[
            'from' => 'required',
            'to' => 'required',  //port
            'id_wa' => 'required',
            'type' => 'required',
            // 'message' => 'required',
            // 'name' => 'required',
            // 'media' => 'required',
            // 'coordinates' => 'required',
            'time_received' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'false','message'=>'parameter tidak sesuai']);
        }

        if(!$this->isNullOrEmpty($data->media)){
            $media=json_decode($data->media,true);
            $data->media=$this->base64Image_link($media['mimetype'],$media['data'],public_path('/storage/inbox'),$data->id_wa);
        }
        $api='';
        if($this->jenis_umum == 'single'){
            $api=$this->domain_api.$data->to.'/send-message';
        }else{
            $api=$this->domain_api_multiple.'/'.$data->to;
        }


        
        Inbox::create([
            'id_wa' => $data->id_wa,
            'api' => $api,
            'nama' => $data->name,
            'telpon' => $data->from,
            'pesan' => $data->message,
            'file' => $data->media,
            'koordinat' => $data->coordinates,
            'jenis' => $data->type,
            'created_at' => Carbon::createFromTimestamp($data->time_received),
        ]);

        return response()->json(['status'=>'true','message'=>'Sukses']);
        
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
