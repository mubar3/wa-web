<?php

namespace App\Http\Controllers;

use App\Exports\NewUserNAExport;
use App\Models\BPMember;
use App\Models\wa;
use App\Models\contact;
use App\Models\sending;
use App\Models\MobileAgent;
use App\Models\Visit;
use App\Models\Inbox;
use App\Models\api_was;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Validator;
use Illuminate\Support\Facades\Auth;

class ApiWaController extends Controller
{
    public function save_api_wa(Request $data)
    {
        $eror=0;
        $route_1=$this->getFirstRouteFromURL($data->url);
        // if single
        if($route_1 == 'send-message'){
            $data['jenis']='single';
            try {
               $response = Http::post($data->url, [
               'number' => '082141300812',
               'message' => $this->generateUniqueCode()
           ]);
           } catch(\Illuminate\Http\Client\ConnectionException $e)
           {
               $eror=1;
           }
        }
        // if multiple
        else if($route_1 != ''){
            $data['jenis']='multiple';
            try {
                $response = Http::post($this->deleteRouteNames($data->url).'/send-message', [
                'sender' => $route_1,
                'number' => '082141300812',
                'message' => $this->generateUniqueCode()
            ]);
            } catch(\Illuminate\Http\Client\ConnectionException $e)
            {
                $eror=1;
            }
        }

        if($eror==1){
            $response=0;
        }else{
            $response = json_decode($response);
            $response=$response->status;
        }
        
        $user = api_was::create([
                'url' => $data->url,
                'jenis' => $data->jenis,
                'tipe_id' => $data->tipe,
                'cronjob' => $data->cron,
                'baru' => $data->baru,
                'training' => $data->training,
                'nomor' => $data->nomor,
                'status' => $response,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()
                ]);
        
        return $user;
    }

    public function data_api_wa($nama){        
        return api_was::select(
                'api_was.*',
                'tipe_send.nama',
                'tipe_send.id as id_tipe',
            )
            ->leftjoin('tipe_send','tipe_send.id','=','api_was.tipe_id')
            ->where('api_was.user_id',Auth::user()->id)
            ->where('api_was.url', 'like', '%' .$nama . '%')
            ->get();
    }

    public function data_api_wa_all(){        
        // return api_was::where('user_id',Auth::user()->id)->get();      
        return api_was::select(
                'api_was.*',
                'tipe_send.nama',
                'tipe_send.id as id_tipe',
            )
            ->leftjoin('tipe_send','tipe_send.id','=','api_was.tipe_id')
            ->where('api_was.user_id',Auth::user()->id)
            ->get();

    }
    public function data_api_wa_cek(){      
       
        if($this->jenis_umum == 'single'){
            return $this->data_api_wa_cek_single();
        }else{
            return $this->data_api_wa_cek_multiple();

        }
    }

    public function data_api_wa_cek_single(){      
        $data='';  
        if (Auth::check()) {
            $data=api_was::where('user_id',Auth::user()->id)->where('jenis','single')->get();
        }else{
            $data=api_was::where('cronjob','y')->where('jenis','single')->get();    
        }
        
        foreach ($data as $data) {
            $eror=0;
                try {
            $response= Http::timeout(5)->post($this->deleteRouteNames($data->url).'/send-group-message', [
                'id' => '120363042746310803@g.us',
                'message' => $this->generateUniqueCode(),
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
                api_was::where('id',$data->id)->update([
                'status' => $response
                ]);   
        }

        if (Auth::check()) {
            return api_was::select(
                    'api_was.*',
                    'tipe_send.nama',
                    'tipe_send.id as id_tipe',
                )
                ->leftjoin('tipe_send','tipe_send.id','=','api_was.tipe_id')
                ->where('api_was.user_id',Auth::user()->id)
                ->get();
        }else{
            return api_was::select(
                    'api_was.*',
                    'tipe_send.nama',
                    'tipe_send.id as id_tipe',
                )
                ->leftjoin('tipe_send','tipe_send.id','=','api_was.tipe_id')
                ->get();    
        }
    }

    public function data_api_wa_cek_multiple(){      
        $data='';  
        if (Auth::check()) {
            $data=api_was::where('user_id',Auth::user()->id)->where('jenis','multiple')->get();
        }else{
            $data=api_was::where('cronjob','y')->where('jenis','multiple')->get();    
        }
        
        foreach ($data as $data) {
            $eror=0;
            try {
                $response= Http::timeout(5)->post($this->deleteRouteNames($data->url).'/send-group-message', [
                    'sender' => $this->getFirstRouteFromURL($data->url),
                    'id' => '120363042746310803@g.us',
                    'message' => $this->generateUniqueCode(),
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
            api_was::where('id',$data->id)->update([
                'status' => $response
            ]);   
        }

        if (Auth::check()) {
            return api_was::select(
                    'api_was.*',
                    'tipe_send.nama',
                    'tipe_send.id as id_tipe',
                )
                ->leftjoin('tipe_send','tipe_send.id','=','api_was.tipe_id')
                ->where('api_was.user_id',Auth::user()->id)
                ->get();
        }else{
            return api_was::select(
                    'api_was.*',
                    'tipe_send.nama',
                    'tipe_send.id as id_tipe',
                )
                ->leftjoin('tipe_send','tipe_send.id','=','api_was.tipe_id')
                ->get();    
        }
    }
    
    public function training_api() 
    {
        if($this->jenis_umum == 'single'){
            return $this->training_api_single();
        }else{
            return $this->training_api_multiple();
        }
    }

    public function training_api_single() 
    {
        ini_set('max_execution_time', 1000000);
        //lama
        $lama=api_was::where('status',1)
            ->where(function ($query) {
                $query->wherenotnull('nomor')
                    ->orWhere('nomor', '!=', '');
            })
            ->where('training','y')
            ->where('baru','n')
            ->where('jenis','single')
            ->inRandomOrder()
            ->first();
        
        //baru
        $baru=api_was::where('status',1)
            ->where('training','y')
            ->where('baru','y')
            ->where(function ($query) {
                $query->wherenotnull('nomor')
                    ->orWhere('nomor', '!=', '');
            })
            ->where('jenis','single')
            ->inRandomOrder()
            ->first();
        
        $tipe=['chat','file'];
        if($lama){
            if($baru){
                // baru ada
                $tipe=$tipe[array_rand($tipe)];
                if($tipe == 'chat'){
                    $response = Http::post($lama->url, [
                        'number' => $baru->nomor,
                        'message' => $this->generateUniqueCode(40).' '.$this->generateUniqueCode(70)
                    ]);
                    sleep(60);
                    $response = Http::post($baru->url, [
                        'number' => $lama->nomor,
                        'message' => $this->generateUniqueCode(40).' '.$this->generateUniqueCode(70)
                    ]);
                }else{

                    $response = Http::post($this->deleteRouteNames($lama->url).'/send-media', [
                        'number' => $baru->nomor,
                        'caption' => '',
                        'file' => 'https://picsum.photos/200',
                    ]);
                    sleep(60);
                    $response = Http::post($this->deleteRouteNames($baru->url).'/send-media', [
                        'number' => $lama->nomor,
                        'caption' => '',
                        'file' => 'https://picsum.photos/200',
                    ]);
                }
                
            }else{
                // baru tidak ada
                $lama2=api_was::where('status',1)
                    ->where('training','y')
                    ->where('id','!=',$lama->id)
                    ->where(function ($query) {
                        $query->wherenotnull('nomor')
                            ->orWhere('nomor', '!=', '');
                    })
                    ->where('baru','n')
                    ->where('jenis','single')
                    ->inRandomOrder()
                    ->first();
                if(!$lama2){
                    return false;
                }
                $tipe=$tipe[array_rand($tipe)];
                if($tipe == 'chat'){
                    $response = Http::post($lama->url, [
                        'number' => $lama2->nomor,
                        'message' => $this->generateUniqueCode(40).' '.$this->generateUniqueCode(70)
                    ]);
                    sleep(60);
                    $response = Http::post($lama2->url, [
                        'number' => $lama->nomor,
                        'message' => $this->generateUniqueCode(40).' '.$this->generateUniqueCode(70)
                    ]);
                }else{
                    $response = Http::post($this->deleteRouteNames($lama->url).'/send-media', [
                        'number' => $lama2->nomor,
                        'caption' => '',
                        'file' => 'https://picsum.photos/200',
                    ]);
                    sleep(60);
                    $response = Http::post($this->deleteRouteNames($lama2->url).'/send-media', [
                        'number' => $lama->nomor,
                        'caption' => '',
                        'file' => 'https://picsum.photos/200',
                    ]);
                }
            }
        }

        return true;
    }

    public function training_api_multiple() 
    {
        ini_set('max_execution_time', 1000000);
        //lama
        $lama=api_was::where('status',1)
            ->where('training','y')
            ->where(function ($query) {
                $query->wherenotnull('nomor')
                    ->orWhere('nomor', '!=', '');
            })
            ->where('baru','n')
            ->where('jenis','multiple')
            ->inRandomOrder()
            ->first();

        
        //baru
        $baru=api_was::where('status',1)
            ->where('training','y')
            ->where('baru','y')
            ->where(function ($query) {
                $query->wherenotnull('nomor')
                    ->orWhere('nomor', '!=', '');
            })
            ->where('jenis','multiple')
            ->inRandomOrder()
            ->first();
        
        // return response()->json(['status'=>'false','message'=>$lama]);
        $tipe=['chat','file'];
        if($lama){
            if($baru){
                // baru ada
                $tipe=$tipe[array_rand($tipe)];
                if($tipe == 'chat'){
                    $response = Http::post($this->deleteRouteNames($lama->url).'/send-message', [
                        'sender' => $this->getFirstRouteFromURL($lama->url),
                        'number' => $baru->nomor,
                        'message' => $this->generateUniqueCode(40).' '.$this->generateUniqueCode(70)
                    ]);
                    sleep(60);
                    $response = Http::post($this->deleteRouteNames($baru->url).'/send-message', [
                        'sender' => $this->getFirstRouteFromURL($baru->url),
                        'number' => $lama->nomor,
                        'message' => $this->generateUniqueCode(40).' '.$this->generateUniqueCode(70)
                    ]);
                }else{
                    $response = Http::post($this->deleteRouteNames($lama->url).'/send-media', [
                        'sender' => $this->getFirstRouteFromURL($lama->url),
                        'number' => $baru->nomor,
                        'caption' => '',
                        'file' => 'https://picsum.photos/200',
                    ]);
                    sleep(60);
                    $response = Http::post($this->deleteRouteNames($baru->url).'/send-media', [
                        'sender' => $this->getFirstRouteFromURL($baru->url),
                        'number' => $lama->nomor,
                        'caption' => '',
                        'file' => 'https://picsum.photos/200',
                    ]);
                }
                
            }else{
                // baru tidak ada
                $lama2=api_was::where('status',1)
                    ->where('training','y')
                    ->where('id','!=',$lama->id)
                    ->where(function ($query) {
                        $query->wherenotnull('nomor')
                            ->orWhere('nomor', '!=', '');
                    })
                    ->where('baru','n')
                    ->where('jenis','multiple')
                    ->inRandomOrder()
                    ->first();
                if(!$lama2){
                    return false;
                }
                $tipe=$tipe[array_rand($tipe)];
                if($tipe == 'chat'){
                    $response = Http::post($this->deleteRouteNames($lama->url).'/send-message', [
                        'sender' => $this->getFirstRouteFromURL($lama->url),
                        'number' => $lama2->nomor,
                        'message' => $this->generateUniqueCode(40).' '.$this->generateUniqueCode(70)
                    ]);
                    sleep(60);
                    $response = Http::post($this->deleteRouteNames($lama2->url).'/send-message', [
                        'sender' => $this->getFirstRouteFromURL($lama2->url),
                        'number' => $lama->nomor,
                        'message' => $this->generateUniqueCode(40).' '.$this->generateUniqueCode(70)
                    ]);
                }else{
                    $response = Http::post($this->deleteRouteNames($lama->url).'/send-media', [
                        'sender' => $this->getFirstRouteFromURL($lama->url),
                        'number' => $lama2->nomor,
                        'caption' => '',
                        'file' => 'https://picsum.photos/200',
                    ]);
                    sleep(60);
                    $response = Http::post($this->deleteRouteNames($lama2->url).'/send-media', [
                        'sender' => $this->getFirstRouteFromURL($lama2->url),
                        'number' => $lama->nomor,
                        'caption' => '',
                        'file' => 'https://picsum.photos/200',
                    ]);
                }
            }
        }

        return true;
    }


    public function edit_api_wa($id){
        $result = api_was::find($id);

        return $result;
    }

    public function update_api_wa(Request $request){
        api_was::where('id',$request->idedit)->update([
            'url' => $request->url,
            'tipe_id' => $request->tipe,
            'cronjob' => $request->cron,
            'baru' => $request->baru,
            'training' => $request->training,
            'nomor' => $request->nomor,
            'status' => $request->status,
            'jenis' => $request->jenis,
        ]);

        return 'sukses';
    }

    public function delete_api_wa($id){
        api_was::destroy($id);
        return 'sukses';
    }

    public function generateUniqueCode($lenght=6)
    {

    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ?=!';
    $charactersNumber = strlen($characters);

    $code = '';

    while (strlen($code) < $lenght) {
        $position = rand(0, $charactersNumber - 1);
        $character = $characters[$position];
        $code = $code.$character;
    }

    return $code;

    }
}
