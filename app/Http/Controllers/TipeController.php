<?php

namespace App\Http\Controllers;

use App\Exports\NewUserNAExport;
use App\Models\BPMember;
use App\Models\wa;
use App\Models\contact;
use App\Models\sending;
use App\Models\MobileAgent;
use App\Models\Visit;
use App\Models\Tipe_send;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Validator;
use Illuminate\Support\Facades\Auth;

class TipeController extends Controller
{
    public function data_tipe($nama){        
        return Tipe_send::where('user_id',Auth::user()->id)->where('nama', 'like', '%' .$nama . '%')->get();
    }

    public function data_tipe_all(){        
        return Tipe_send::where('user_id',Auth::user()->id)->get();
    }
    public function save_tipe(Request $data)
    {
        return Tipe_send::create([
                'nama' => $data->nama,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()
            ]);
    }

    public function edit_tipe($id){
        return Tipe_send::find($id);
    }

    public function update_tipe(Request $request){
        Tipe_send::where('id',$request->idedit)->update([
            'nama' => $request->nama,
        ]);

        return 'sukses';
    }

    public function delete_tipe($id){
        Tipe_send::destroy($id);
        return 'sukses';
    }
}
