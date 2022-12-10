<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;
use File;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Profil::find(Auth::user()->id);

        $validator = JSvalidation::make([
            'nama'      => 'required',
            'email'     => 'required|email',
            'foto'      => 'image|max:1000'
        ]);

        return view('profil')->with([
            'title' => 'Edit Profil',
            'user'  => $user,
            'validator' => $validator
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Profil $profil)
    {   
        if($r->hasFile('foto')){
            $foto_lama=public_path('storage/foto/').Auth::user()->foto;
            File::delete($foto_lama);
            $r->validate([
                'nama'  => 'required',
                'email' => 'required|email',
                'foto'  => 'image|max:1000'
            ]);

            $name = Auth::user()->id.Auth::user()->username;
            $ext  = $r->foto->getClientOriginalExtension();
            $foto = base64_encode($name).'.'.$ext;

            // $data=$r->file('foto')->storeAs('public/foto', $foto);
            $r->file('foto')->move(public_path('/storage/foto'),$foto);

        // print_r($data);
        // die();

            $validator = [
                'nama'  => $r->nama,
                'email' => $r->email,
                'foto'  => $foto
            ];

        }else{
            $validator = $r->validate([
                'nama'  => 'required',
                'email' => 'required|email'
            ]);
        }

        Profil::where('id', $profil->id)->update($validator);

        return redirect('/profil')->with(['pesan' => '<div class="alert alert-success">Profil berhasil diperbarui</div>']);
    }

    public function password()
    {
        $user = Profil::find(Auth::user()->id);

        $validator = JSvalidation::make([
            'sandi'     => 'required',
            'password'  => 'required|confirmed|min:6',
        ]);

        return view('password')->with([
            'title' => 'Edit Sandi',
            'user'  => $user,
            'validator' => $validator
        ]);
    }

    public function ganti_password(Request $r, Profil $profil)
    {
        // print_r($profil->password);
        // die();
        if(Hash::check($r->sandi, $profil->password)){
            $validasi = $r->validate([
                'sandi'     => 'required',
                'password'  => 'required|confirmed|min:5',
            ]);

            Profil::where('id',$profil->id)->update([
                'password' => Hash::make($r->password),
            ]);

            return redirect('/profil/password')->with(['pesan' => '<div class="alert alert-success">Sandi berhasil dirubah</div>']);

        }else{
            return redirect('/profil/password')->with(['pesan' => '<div class="alert alert-danger">Sandi lama salah</div>']);
        }
    }

}
