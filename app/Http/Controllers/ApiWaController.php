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

class ApiWaController extends Controller
{
    public function save_api_wa(Request $data)
    {
        $eror=0;
         try {
            $response = Http::post($data->url, [
            'number' => '082141300812',
            'message' => $this->generateUniqueCode()
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
        
        $user = api_was::create([
                'url' => $data->url,
                'status' => $response,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()
                ]);
        
        return $user;
    }

    public function data_api_wa($nama){        
        return api_was::where('user_id',Auth::user()->id)->where('url', 'like', '%' .$nama . '%')->get();
    }

    public function data_api_wa_all(){        
        return api_was::where('user_id',Auth::user()->id)->get();

    }
    public function data_api_wa_cek(){      
        $data='';  
        if (Auth::check()) {
            $data=api_was::where('user_id',Auth::user()->id)->get();
        }else{
            $data=api_was::get();    
        }
        // print_r($data);
        // die();

        foreach ($data as $data) {
        //     $response = Http::post($data->url, [
        //     'number' => '082141300812',
        //     'message' => '----cek status api----'
        // ]);
        $eror=0;
             try {
        $response= Http::timeout(5)->post($data->url, [
        // $response= Http::post($data->url, [
            'number' => '082141300812',
            'message' => $this->generateUniqueCode()
        ]);
        } catch(\Illuminate\Http\Client\ConnectionException $e)
        {
            $eror=1;
        }
            // if(!$response->successful()){echo 1;}
            // print_r($response);
            // die();
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
            return api_was::where('user_id',Auth::user()->id)->get();
        }else{
            return api_was::get();    
        }
    }


    public function edit_api_wa($id){
        $result = api_was::find($id);

        return $result;
    }

    public function update_api_wa(Request $request){
        // $data = $request->except('_method', '_token');
        api_was::where('id',$request->idedit)->update([
        'url' => $request->url
        ]);

        return 'sukses';
    }

    public function delete_api_wa($id){
        api_was::destroy($id);
        // contact::where('id',$id)->delete();
        return 'sukses';
    }

    public function generateUniqueCode()
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

    return $code;

    }
}
