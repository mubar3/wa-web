<?php

namespace App\Http\Controllers;

use App\Exports\NewUserNAExport;
use App\Models\BPMember;
use App\Models\wa;
use App\Models\contact;
use App\Models\sending;
use App\Models\MobileAgent;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Validator;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function save_contact(Request $data)
    {
        // echo 1;
        // die();
        $user = contact::create([
                'telpon' => $data->no_hp,
                'nama' => $data->nama,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()
                ]);
        
        return $user;

        // if($user){
        // return redirect(route('contact'))->with([
        //         'pesan' => '<div class="alert alert-success">Berhasil Disimpan</div>'
        //     ]);
        // }else{
        // return redirect(route('contact'))->with([
        //         'pesan' => '<div class="alert alert-danger">Gagal Disimpan</div>'
        //     ]);

        // }
    }

    public function data_contact($nama){        
        return contact::where('user_id',Auth::user()->id)->where('nama', 'like', '%' .$nama . '%')->orwhere('telpon', 'like', '%' .$nama . '%')->get();
    }

    public function data_contact_all(){        
        return contact::where('user_id',Auth::user()->id)->get();
    }


    public function edit_contact($id){
        $result = contact::find($id);

        return $result;
    }

    public function update_contact(Request $request){
        // $data = $request->except('_method', '_token');
        contact::where('id',$request->idedit)->update([
        'nama' => $request->nama,
        'telpon' => $request->no_hp
        ]);

        return 'sukses';
    }

    public function delete_contact($id){
        contact::destroy($id);
        // contact::where('id',$id)->delete();
        return 'sukses';
    }
}
