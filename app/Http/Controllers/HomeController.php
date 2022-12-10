<?php

namespace App\Http\Controllers;

use App\Exports\NewUserNAExport;
use App\Models\BPMember;
use App\Models\wa;
use App\Models\api_was;
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
// use Excel;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        return view('home')->with([
            'tMulai'    => date('Y-m-01'),
            'tAkhir'    => date('Y-m-d'),
            'tmulaiNewuser' => date('Y-m'),
        ]);
    }

    public function sender()
    {
        $data=contact::all();
        // print_r($data);
        // die();
        return view('menu.sender', compact('data'))->with([
            'tMulai'    => date('Y-m-01'),
            'tAkhir'    => date('Y-m-d'),
            'tmulaiNewuser' => date('Y-m'),
        ]);
    }

    public function bulk()
    {

        return view('menu.bulk')->with([
            'tMulai'    => date('Y-m-01'),
            'tAkhir'    => date('Y-m-d'),
            'tmulaiNewuser' => date('Y-m'),
        ]);
    }

    public function contact()
    {
        return view('menu.contact')->with([
            'tMulai'    => date('Y-m-01'),
            'tAkhir'    => date('Y-m-d'),
            'tmulaiNewuser' => date('Y-m'),
        ]);
    }

    public function api_wa()
    {
        return view('menu.api_wa')->with([
            'tMulai'    => date('Y-m-01'),
            'tAkhir'    => date('Y-m-d'),
            'tmulaiNewuser' => date('Y-m'),
        ]);
    }

    public function history()
    {
         $data=api_was::all();
        return view('menu.history', compact('data'))->with([
            'tMulai'    => date('Y-m-01'),
            'tAkhir'    => date('Y-m-d'),
            'tmulaiNewuser' => date('Y-m'),
        ]);
    }

    

    // public function generateUniqueCode()
    // {

    // $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // $charactersNumber = strlen($characters);
    // $codeLength = 6;

    // $code = '';

    // while (strlen($code) < 6) {
    //     $position = rand(0, $charactersNumber - 1);
    //     $character = $characters[$position];
    //     $code = $code.$character;
    // }

    // if (wa::where('code', $code)->exists()) {
    //     $this->generateUniqueCode();
    // }

    // return $code;

    // }

}
