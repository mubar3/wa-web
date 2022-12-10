<?php

use App\Models\Area;
use App\Models\Cluster;
use App\Models\RolesItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\Jabatan;
use App\Models\MobileAgent;
use App\Models\Outlet;
use App\Models\Pkmodule;
use App\Models\Region;
use App\Models\Subarea;
use App\Models\Pksoal;

function hakAksesMenu($roleitem, $role)
{
    $roles_id = session('roles_id');
    $item_id = RolesItem::where('nama', $roleitem)->first();

    if ($item_id != null) {
        $item_id = $item_id->id;
        $permission = DB::table('roles_item_pivot')
            ->where('roles_id', $roles_id)
            ->where('roles_item_id', $item_id)
            ->first();

        if ($permission != null) {
            if ($permission->$role == '1') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function input_log()
{
    $insert = DB::table('log_user')->insert([
        'users_id'  => Auth::user()->userid,
        'url'       => URL::full(),
        'ip'        => request()->ip(),
        'created_at' => Carbon::now(),
    ]);
}

function xButton($link = '', $tipe = 'kembali')
{
    if ($tipe == 'kembali') {
        return '<a href="' . url('' . $link . '') . '" class="btn btn-link">Kembali</a>';
    } else if ($tipe == 'tambah_view') {
        return '<a href="' . url('' . $link . '') . '" class="btn btn-sm btn-primary float-right">Buat</a>';
    } else if ($tipe == 'tambah') {
        return '<button class="btn btn-primary btn-sm" type="submit">Ya! Simpan</button>';
    } else if ($tipe == 'print') {
        return '<button class="btn btn-outline-success btn-sm float-right" type="submit">Export</button>';
    } else if ($tipe == 'cari') {
        return '<button class="btn btn-warning btn-sm" type="submit">GO</button>';
    } else if ($tipe == 'edit') {
        return '<button class="btn btn-primary btn-sm" type="submit">Perbarui</button>';
    } else if ($tipe == 'tambahsoal') {
        // return '<button class="btn btn-sm btn-primary float-right" type="button" onclick="tambahsoal(\'index\',event)">Buat</button>';
        return '<button class="btn btn-sm btn-primary float-right" type="button" data-toggle="modal" data-target="#modalTambahSoal">Buat</button>';
    } else if ($tipe == 'importsoal') {
        return '<button class="btn btn-sm btn-outline-danger float-right mr-3" type="button" onclick="importModal()">Import</button>';
    }
}

function getCluster()
{
    $where  = ' 1=1 ';
    if (session('cluster_id') != null) {
        $where .= DB::raw(' AND cluster_id = ' . session('cluster_id') . ' ');
    }

    return Cluster::where('cluster_status', 'y')->whereRaw($where)->get();
}

function getUser()
{
    $where = '1=1';

    if (session('jabatan_id') != null || session('jabatan_id') != '') {
        $where .= DB::raw(' AND jabatan_id IN (' . session('jabatan_id') . ') ');
    }

    if (session('region_id') != null || session('region_id') != '') {
        $where .= DB::raw(' AND region_id IN (' . session('region_id') . ') ');
    }

    if (session('ma_id') != null || session('ma_id') != '') {
        $where .= DB::raw(' AND supervisor = ' . session('ma_id') . ' ');
    }

    $user = MobileAgent::with('jabatan')
        ->leftJoin('work_area as b', 'b.workarea_id', '=', 'mobile_agent.area_id')
        ->where([
            'status'    => 'y',
            'istester'  => 'n'
        ])->whereRaw($where)->select('userid', 'username', 'nama', 'supervisor', 'jabatan_id', 'area_id', 'b.region_id')
        ->get();

    return $user;
}

function getSql($builder)
{
    $addSlashes = str_replace('?', "'?'", $builder->toSql());
    return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
}

function getOutlet()
{
    if (session('region_id') == null || session('region_id') == '') {
        $where = '1=1';
    } else {
        $where = DB::raw('region_id IN (' . session('region_id') . ') ');
    }

    $outlet = Outlet::query()
        ->with('area')
        ->whereHas('area', function ($e) use ($where) {
            return $e->select('workarea_id', 'region_id', 'area')->whereRaw($where);
        })
        ->where([
            'outlet_status' => 'y',
            // 'isoutlet'      => 'y'
        ])
        ->select('outlet_id', 'outlet_kode_gg as outlet_kode', 'outlet_nama', 'outlet_area')
        ->orderBy('outlet_kode_gg', 'asc')
        ->get();

    return $outlet;
}


function getArea($region = '')
{
    $where  = ' 1=1 ';
    $area_id = session('area_id');

    if ($region != '') {
        $where .= DB::raw(' AND region_id = ' . $region . ' ');
    }

    // if ($area_id != null) {
    //     $where .= DB::raw(' AND workarea_id IN (' . $area_id . ') ');
    // }

    $area = Area::select('workarea_id as id', 'area')
        ->where('area_status', 'y')
        ->whereRaw($where)
        ->orderBy('area', 'asc')
        ->get();

    return $area;
}

function getRegion()
{
    $where  = ' 1=1 ';
    $region_id = session('region_id');

    if ($region_id != null) {
        $where .= DB::raw(' AND id IN (' . $region_id . ') ');
    }

    $data = Region::select('id', 'kode', 'region')
        ->where('status', 'y')
        ->whereRaw($where)
        ->orderBy('kode', 'asc')
        ->get();

    return $data;
}

function getSubarea($kategori_id = null)
{
    $where  = ' 1=1 ';

    if ($kategori_id != null) {
        $where .= DB::raw('AND area = ' . $kategori_id . ' ');
    }

    if (session('subarea_id') != null) {
        $where .= DB::raw(' AND area_id = ' . session('subarea_id') . ' ');
    }

    return Subarea::where('area_status', 'y')->whereRaw($where)->get();
}

function getJabatan()
{
    $where  = ' 1=1 ';
    $jabatan_id = session('jabatan_id');

    if ($jabatan_id != null) {
        $where .= 'AND jabatan_id IN (' . $jabatan_id . ') ';
    }

    $jabatan = Jabatan::select('jabatan_id', 'jabatan_kode', 'jabatan_nama')
        ->where('jabatan_status', 'y')
        ->whereRaw($where)
        ->orderBy('jabatan_id', 'asc')
        ->get();

    return $jabatan;
}

function getUsers()
{
    $maid = session('ma_id');
    if ($maid == null || $maid == '') {
        $getUsers = MobileAgent::select('userid')->get();
        foreach ($getUsers as $user) {
            $users[] = $user->userid;
        }

        return $users;
    } else {
        $sql = 'select userid from mobile_agent a where a.userid = ' . $maid . '
                    union
                select userid from mobile_agent a where a.supervisor = ' . $maid . ' ';
        $getUsers = DB::select($sql);
        foreach ($getUsers as $user) {
            $users[] = $user->userid;
        }

        return $users;
    }
}

function urlTes($param = '')
{
    $cluster = session('cluster_id');
    if ($cluster == '' || $cluster == null || $cluster == '1') {
        if ($param == 'video') {
            return 'https://wsabsensinn.geogiven.tech/ws-absensinn/uploads-video/';
        } else {
            return 'https://wsabsensinn.geogiven.tech/ws-absensinn/uploads/';
        }
    } else {
        if ($param == 'video') {
            return 'https://wsabsensinn.geogiven.tech/ws-absensinn/uploads-video/';
        } else if ($param == 'detailing') {
            return 'https://wsabsensinn.geogiven.tech/ws-absensinn/detailing/';
        } else {
            return 'https://wsabsensinn.geogiven.tech/ws-absensinn/uploads/';
        }
    }
}

function pkmodul($id)
{
    $where  = ' 1=1 ';

    $modul = Pkmodule::select('idpk_module', 'tahun', 'bulan')
        ->where('idpk_module', $id)
        ->whereRaw($where)
        ->orderBy('idpk_module', 'asc')
        ->get();

    return $modul;
}

function pksoal($id)
{
    $where  = ' 1=1 ';

    $soal = Pksoal::where('pkmodule_id', $id)
        ->whereRaw($where)
        ->orderBy('pkmodule_id', 'asc')
        ->get();

    return $soal;
}

function urlbantuan()
{
    // return 'http://localhost/ggvm/nn/public/storage/';
    return 'https://reportnn.geogiven.tech/storage/';
}

function getWarna($kode='')
{
    if($kode == ''){
        return '#00897B';
    }else{
        $warna_arr = ['#D32F2F','#512DA8','#0097A7','#FF8F00','#E64A19','#5D4037'];
        return $warna_arr[$kode];
    }

}

function pricingColor($string, $val = false, $excel = true){
    $cari = preg_match("/-y/i", $string);
    if($val == false){
        if($cari){
            echo 'style="background-color: #FF7043;"';
        }

    }else{
        if($cari){
            $pecah = explode('-', $string);
            if($excel == true){
                return $pecah[0];
            }else{
                return '<div style="background:#FF7043";>'.$pecah[0].'</div>';
            }


        }else{
            return $string;
        }
    }

}
