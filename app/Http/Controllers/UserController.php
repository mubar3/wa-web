<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cluster;
use App\Models\MobileAgent;
use App\Models\Region;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserArea;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('role:users,read')->only('index');
        $this->middleware('role:users,create')->only(['create', 'store']);
        $this->middleware('role:users,update')->only(['edit', 'update']);
        $this->middleware('role:users,delete')->only('delete');
    }

    public function index()
    {
        $title = 'Pengaturan User';

        return view('user.index')->with([
            'title' => $title,
        ]);
    }

    public function ajax(Request $r)
    {
        $where = '';

        if($r->cari){
            $nama = $r->cari;
            $where .= DB::raw('AND LOWER(username) LIKE "%'.$nama.'%" OR LOWER(nama) LIKE "%'.$nama.'%" ');
        }

        if($r->status == '' || $r->status == 'on'){
            $where .= DB::raw('AND users.status = "y" ');
        }else{
            $where .= DB::raw('AND users.status = "n" ');
        }

        if($r->cluster){
            $where .= DB::raw('AND c.cluster_id = '.$r->cluster.' ');
        }
        // dd($where);

        $data = User::query()->with('roles')
                    ->leftJoin('users_area as b','b.users_id','=','userid')
                    ->leftJoin('produk_cluster as c','c.cluster_id','=','b.cluster_id')
                    ->leftJoin('work_area as d','d.workarea_id','=','b.area_id')
                    ->leftJoin('region as e','e.id','=','b.region_id')
                    ->whereRaw('1=1 '.$where)
                    ->groupBy('userid')
                    ->select(
                            DB::raw('ROW_NUMBER() OVER(ORDER BY userid) AS nomor'),
                            'userid',
                            'username',
                            'nama',
                            'users.status',
                            'c.cluster_nama',
                            DB::raw('GROUP_CONCAT(DISTINCT d.area SEPARATOR ", ") AS area'),
                            DB::raw('GROUP_CONCAT(DISTINCT e.kode SEPARATOR ", ") AS region'),
                            );

        // $data = $data->toArray();
        // dd($data);
        return DataTables::eloquent($data)
            ->addColumn('roles', function ($d) {
                $role = [];
                foreach ($d->roles as $roles) {
                    $role[]  = '<span class="badge badge-dark">' . $roles->nama . '</span>';
                }
                return implode(' ', $role);
            })
            ->addColumn('cluster', function($d){
                if($d->cluster_nama == null){
                    return 'Semua Cluster';
                }else{
                    return $d->cluster_nama;
                }
            })
            ->addColumn('region', function($d){
                if($d->region == null){
                    return 'Semua Region';
                }else{
                    return $d->region;
                }
            })
            ->addColumn('area', function($d){
                if($d->area == null){
                    return 'Semua Area';
                }else{
                    return $d->area;
                }
            })
            ->addColumn('aksi', function ($d) {
                $data = '';
                if (hakAksesMenu('users', 'update')) {
                    $data .= '<a href="user/' . $d->userid . '/edit" class="edit-btn"><i class="feather-edit"></i></a>';
                }

                if ($d->status == 'y') {
                    $ikon = '<i class="feather-x-circle"></i>';
                    $tipe = 'nonaktifkan';
                } else {
                    $ikon = '<i class="feather-repeat"></i>';
                    $tipe = 'aktifkan';
                }

                if (hakAksesMenu('users', 'delete')) {
                    $data .= '<a href="user/delete/' . $d->userid . '" data-nama="' . $d->nama . '" data-tipe="' . $tipe . '" class="hapus-btn hapus_data_list">' . $ikon . '</a>';
                }

                return $data;
            })
            ->rawColumns(['aksi', 'roles'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $validator = JSvalidation::make([
            'username' => 'required|unique:users,username',
            'nama' => 'required',
            'roles' => 'required'
        ]);

        $roles = Roles::where('id','<>',1)->get();

        $area = Area::where('area_status','y')
                    ->select('workarea_id','area')
                    ->get();

        return view('user.create')->with([
            'title' => 'Tambah user',
            'validator' => $validator,
            'roles'     => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $r->validate([
            'username' => 'required|unique:users,username',
            'nama' => 'required',
        ]);

        $create = [
            'username'  => $r->username,
            'nama'      => $r->nama,
            'email'     => $r->email,
            'sandi'     => Hash::make('asd'),
            'foto'      => 'foto.jpg',
            'ma_id'     => $r->ma_id,
            'ip'        => $r->ip(),
            'userinput' => Auth::user()->userid,
        ];
        // dd($create);
        DB::beginTransaction();

        $user = User::create($create);

        $roles = $r->input('roles');
        if (!empty($roles)) {
            foreach ($roles as $roles_id) {
                $record[] = [
                    'user_userid' => $user->userid,
                    'roles_id'    => $roles_id,
                    'created_at'  => Carbon::now(),
                ];
            }
        }

        try {
            // insert roles_user
            DB::table('roles_user')->insert($record);

            // input user_area
            if($r->region == null){
                    $user_area = [
                        'users_id'     => $user->userid,
                        'cluster_id'   => $r->cluster,
                        'region_id'    => $r->region,
                    ];

                    UserArea::create($user_area);
            }else{
                foreach($r->region as $region){
                    $user_area = [
                        'users_id'     => $user->userid,
                        'cluster_id'   => $r->cluster,
                        'region_id'    => $region,
                    ];

                    UserArea::create($user_area);
                }
            }

            DB::commit();

            input_log();
            return redirect('/user')->with(['pesan' => '<div class="alert alert-success">Data berhasil ditambahkan</div>']);
        } catch (QueryException $e) {

            DB::rollBack();
            return redirect('/user')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $validator = JSvalidation::make([
            'username'  => 'required|unique:users,username,' . $user->userid,
            'nama'      => 'required',
            'password'  => 'confirmed',
            'roles'     => 'required',
            'foto'      => 'image|max:1000'
        ]);

        $user_area = UserArea::where('users_id',$user->userid)->get();
        $user_area = collect($user_area)->first();

        $areas = UserArea::select('area_id')
                         ->where('users_id',$user->userid)
                         ->get();

        $areaids = [];
        foreach($areas as $areax){
            $areaids [] = $areax->area_id;
        }

        $regions = UserArea::select('region_id')
                         ->where('users_id',$user->userid)
                         ->get();

        $regionids = [];
        foreach($regions as $regionx){
            $regionids [] = $regionx->region_id;
        }

        $region= Region::where('status','y')
                        ->select('id','kode','region')
                        ->get();

        // master area
        $area = Area::where('area_status','y')
                    ->select('workarea_id','area')
                    ->get();

        $spv = MobileAgent::with(['jabatan','area'])
                        ->where([
                            'status'    => 'y',
                            'istester'  => 'n',
                        ])
                        ->whereIn('jabatan_id', [1,2])
                        ->select('userid','username','nama','jabatan_id','area_id')
                        ->orderBy('nama','asc')
                        ->get();

        $roles = DB::table('roles as a')
                    ->select('a.id', 'a.nama', 'b.user_userid')
                    ->leftJoin('roles_user as b', function ($join) use ($user) {
                        $join->on('b.roles_id', '=', 'a.id')
                            ->where('b.user_userid', $user->userid);
                    })
                    ->where('a.id','<>',1)
                    ->get();

        $cluster = Cluster::where('cluster_status','y')->get();

        $userarea = UserArea::where([
            'users_id'  => $user->userid
        ])->first();

        return view('user.edit')->with([
            'title'     => 'Edit User',
            'user'      => $user,
            'validator' => $validator,
            'roles'     => $roles,
            'area'      => $area,
            'userarea'  => $user_area,
            'areaids'   => $areaids,
            'spv'       => $spv,
            'cluster'   => $cluster,
            'userarea'  => $userarea,
            'region'    => $region,
            'regionids' => $regionids,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, User $user)
    {
        $roles = $r->input('roles');
        if (!empty($roles)) {
            foreach ($roles as $roles_id) {
                $record[] = [
                    'user_userid' => $user->userid,
                    'roles_id'  => $roles_id,
                    'created_at' => Carbon::now(),
                ];
            }
        }

        DB::beginTransaction();
        try {
            // update roles_user
            DB::table('roles_user')->where('user_userid',$user->userid)->delete();
            DB::table('roles_user')->insert($record);

            // Update users_area
            UserArea::where('users_id',$user->userid)->delete();

            if($r->region){
                foreach($r->region as $region){
                    $user_area = [
                        'users_id'     => $user->userid,
                        'cluster_id'   => $r->cluster,
                        'region_id'      => $region,
                    ];

                    UserArea::create($user_area);
                }
            }else{
                $user_area = [
                    'users_id'     => $user->userid,
                    'cluster_id'   => $r->cluster,
                ];

                UserArea::create($user_area);
            }

            if($r->hasFile('foto')){
                $r->validate([
                    'foto'  => 'image|max:1000'
                ]);

                $name = $user->userid.$user->username;
                $ext  = $r->foto->getClientOriginalExtension();
                $foto = base64_encode($name).'.'.$ext;

                $r->foto->storeAs('public/foto', $foto);

                $record_foto = [
                    'foto'  => $foto
                ];

                // Update foto user
                User::where('userid',$user->userid)->update($record_foto);
            }

            // Cek apakah dengan ganti password
            if ($r->password) {
                $r->validate([
                    'nama'      => 'required',
                    'password'  => 'confirmed'
                ]);

                $update = [
                    'username'  => $r->username,
                    'nama'      => $r->nama,
                    'email'     => $r->email,
                    'ma_id'     => $r->ma_id,
                    'sandi'     => Hash::make($r->password),
                ];

            }else{
                $r->validate([
                    'nama'      => 'required',
                ]);

                $update = [
                    'username'  => $r->username,
                    'nama'      => $r->nama,
                    'email'     => $r->email,
                    'ma_id'     => $r->ma_id,
                ];
            }

            // Update user
            User::where('userid',$user->userid)->update($update);
            DB::commit();

            input_log();
            return redirect('/user')->with(['pesan' => '<div class="alert alert-success">Data berhasil diperbarui</div>']);

        } catch (QueryException $e) {
            DB::rollBack();
            return redirect('/user')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id, User $user)
    {

        try {
            $status = User::find($id)->status;
            if ($status == 'y') {
                User::where('userid', $id)->update([
                    'status' => 'n'
                ]);
                input_log();

                return response()->json([
                    'tipe' => true,
                    'pesan' => 'User berhasil dinonaktifkan'
                ]);
            } else {
                User::where('userid', $id)->update([
                    'status' => 'y'
                ]);
                input_log();

                return response()->json([
                    'tipe' => true,
                    'pesan' => 'User berhasil diakftikan kembali'
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'tipe' => false,
                'pesan' => $e->errorInfo,
            ]);
        }
    }
}
