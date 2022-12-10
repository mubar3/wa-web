<?php

namespace App\Http\Controllers;

use App\Models\Umum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:umum,read')->only('index');
        $this->middleware('role:umum,update')->only('update');
    }

    public function index()
    {
        $title  = 'Pengaturan Umum';
        $item   = Umum::first();
        return view('umum.index')->with([
            'title' => $title,
            'item'  => $item,
        ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Umum  $umum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Umum $umum)
    {

        if($r->hasFile('logo')){
            $r->validate([
                'nama' => 'required',
                'logo' => 'file|image|max:2000',
            ]);

            $logo_nama  = 'logo';
            $logo_ext   = $r->logo->getClientOriginalExtension();
            $logo       = $logo_nama.'.'.$logo_ext;

            $upload = $r->logo->storeAs('public',$logo);

        }else{
            $logo = 'logo.png';
        }

        Umum::where('id', $umum->id)->update([
            'nama'  => $r->nama,
            'logo'  => $logo,
        ]);

        input_log();
        return redirect('/umum')->with(['pesan' => '<div class="alert alert-success">Pengaturan berhasil diperbarui</div>']);
    }


}
