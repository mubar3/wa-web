<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cluster;
use App\Models\MobileAgent;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserArea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('role:roles,read')->only('index');
        $this->middleware('role:roles,create')->only(['create','store']);
        $this->middleware('role:roles,update')->only(['edit','update']);
        $this->middleware('role:roles,delete')->only('delete');
    }

    public function index()
    {

        $data['title'] = 'Pengaturan Roles';
        return view('roles.index', $data);
    }

    public function ajax()
    {
        return DataTables::eloquent(Roles::query())
                        ->addColumn('aksi', function ($d) {
                            $data = '';

                            if(hakAksesMenu('roles','update')){
                                $data .= '<a href="/roles/'.$d->id.'/edit" class="edit-btn"><i class="feather-edit"></i></a>';
                            }

                            if(hakAksesMenu('roles','delete')){
                                $data .= '<a href="/roles/delete/'.$d->id.'" data-nama="Roles '.$d->nama.'" data-tipe="hapus" class="hapus-btn hapus_data_list"><i class="feather-x-circle"></i></a>';
                            }

                            return $data;
                        })
                        ->rawColumns(['aksi'])
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $title = 'Tambah Roles';
        $validator = JSvalidation::make([
            'nama'  => 'required'
        ]);

        $rolesitem = DB::table('roles_items AS a')
                        ->get();

        return view('roles.create')->with([
            'title' => $title,
            'validator' => $validator,
            'rolesitem' => $rolesitem
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

        try{
            Roles::create([
                'nama' => $r->nama
            ]);
            $roles_id = Roles::latest()->first()->id;

            $creates= $r->input('create');
            $reads  = $r->input('read');
            $updates= $r->input('update');
            $deletes= $r->input('delete');
            $prints = $r->input('print');

            $roles_item = $r->role_items_id;
            foreach($roles_item as $item_id){
                //create
                if(!empty($creates)){
                    if(array_key_exists($item_id, $creates)){
                        $items_create [] = [
                            'roles_item_id' => $item_id,
                            'create' => 1,
                        ];
                    }else{
                        $items_create [] = [
                            'roles_item_id' => $item_id,
                            'create' => 0,
                        ];
                    }
                }else{
                    $items_create [] = [
                        'roles_item_id' => $item_id,
                        'create' => 0,
                    ];
                }


                // read
                if(!empty($reads)){
                    if(array_key_exists($item_id, $reads)){
                        $items_read [] = [
                            'roles_item_id' => $item_id,
                            'read' => 1,
                        ];
                    }else{
                        $items_read [] = [
                            'roles_item_id' => $item_id,
                            'read' => 0,
                        ];
                    }
                }else{
                    $items_read [] = [
                        'roles_item_id' => $item_id,
                        'read' => 0,
                    ];
                }

                // update
                if(!empty($updates)){
                    if(array_key_exists($item_id, $updates)){
                        $items_update [] = [
                            'roles_item_id' => $item_id,
                            'update' => 1,
                        ];
                    }else{
                        $items_update [] = [
                            'roles_item_id' => $item_id,
                            'update' => 0,
                        ];
                    }
                }else{
                    $items_update [] = [
                        'roles_item_id' => $item_id,
                        'update' => 0,
                    ];
                }

                // delete
                if(!empty($deletes)){
                    if(array_key_exists($item_id, $deletes)){
                        $items_delete [] = [
                            'roles_item_id' => $item_id,
                            'delete' => 1,
                        ];
                    }else{
                        $items_delete [] = [
                            'roles_item_id' => $item_id,
                            'delete' => 0,
                        ];
                    }
                }else{
                    $items_delete [] = [
                        'roles_item_id' => $item_id,
                        'delete' => 0,
                    ];
                }

                // print
                if(!empty($prints)){
                    if(array_key_exists($item_id, $prints)){
                        $items_print [] = [
                            'roles_item_id' => $item_id,
                            'print' => 1,
                        ];
                    }else{
                        $items_print [] = [
                            'roles_item_id' => $item_id,
                            'print' => 0,
                        ];
                    }
                }else{
                    $items_print [] = [
                        'roles_item_id' => $item_id,
                        'print' => 0,
                    ];
                }

            }

            $record = [];
            foreach($roles_item as $items){
                $record [] = [
                    'roles_id'      => $roles_id,
                    'roles_item_id' => $items,
                    'create'        => $this->__getValueArr($items_create, $items, 'create'),
                    'read'          => $this->__getValueArr($items_read, $items, 'read'),
                    'update'        => $this->__getValueArr($items_update, $items, 'update'),
                    'delete'        => $this->__getValueArr($items_delete, $items, 'delete'),
                    'print'         => $this->__getValueArr($items_print, $items, 'print'),
                    'created_at'    => Carbon::now(),
                ];
            }

            // Buat baru untuk roles item nya
            DB::table('roles_item_pivot')
                ->insert($record);

            input_log();
            return redirect('/roles')->with(['pesan'=>'<div class="alert alert-success">Data berhasil ditambahkan</div>']);

        }catch(QueryException $e){

            return redirect('/roles')->with(['pesan'=>'<div class="alert alert-danger">'.$e->errorInfo.'</div>']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $role)
    {
        dd($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $role)
    {

        $title = 'Edit Roles';
        $validator = JSvalidation::make([
            'nama'  => 'required'
        ]);


        $rolesitem = DB::table('roles_items AS a')
                        ->leftJoin('roles_item_pivot AS b', function($join) use ($role){
                            $join->on('b.roles_item_id','=','a.id')
                            ->where('b.roles_id','=',$role->id);
                        })
                        ->get();

        return view('roles.edit')->with([
            'roles' => $role,
            'title' => $title,
            'validator' => $validator,
            'rolesitem' => $rolesitem
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Roles $role)
    {

        // Update nama roles
        Roles::where('id', $role->id)->update([
            'nama'  => $r->nama,
        ]);


        $creates= $r->input('create');
        $reads  = $r->input('read');
        $updates= $r->input('update');
        $deletes= $r->input('delete');
        $prints = $r->input('print');

        $roles_item = $r->role_items_id;
        foreach($roles_item as $item_id){
            //create
            if(!empty($creates)){
                if(array_key_exists($item_id, $creates)){
                    $items_create [] = [
                        'roles_item_id' => $item_id,
                        'create' => 1,
                    ];
                }else{
                    $items_create [] = [
                        'roles_item_id' => $item_id,
                        'create' => 0,
                    ];
                }
            }else{
                $items_create [] = [
                    'roles_item_id' => $item_id,
                    'create' => 0,
                ];
            }


            // read
            if(!empty($reads)){
                if(array_key_exists($item_id, $reads)){
                    $items_read [] = [
                        'roles_item_id' => $item_id,
                        'read' => 1,
                    ];
                }else{
                    $items_read [] = [
                        'roles_item_id' => $item_id,
                        'read' => 0,
                    ];
                }
            }else{
                $items_read [] = [
                    'roles_item_id' => $item_id,
                    'read' => 0,
                ];
            }

            // update
            if(!empty($updates)){
                if(array_key_exists($item_id, $updates)){
                    $items_update [] = [
                        'roles_item_id' => $item_id,
                        'update' => 1,
                    ];
                }else{
                    $items_update [] = [
                        'roles_item_id' => $item_id,
                        'update' => 0,
                    ];
                }
            }else{
                $items_update [] = [
                    'roles_item_id' => $item_id,
                    'update' => 0,
                ];
            }

            // delete
            if(!empty($deletes)){
                if(array_key_exists($item_id, $deletes)){
                    $items_delete [] = [
                        'roles_item_id' => $item_id,
                        'delete' => 1,
                    ];
                }else{
                    $items_delete [] = [
                        'roles_item_id' => $item_id,
                        'delete' => 0,
                    ];
                }
            }else{
                $items_delete [] = [
                    'roles_item_id' => $item_id,
                    'delete' => 0,
                ];
            }

            // print
            if(!empty($prints)){
                if(array_key_exists($item_id, $prints)){
                    $items_print [] = [
                        'roles_item_id' => $item_id,
                        'print' => 1,
                    ];
                }else{
                    $items_print [] = [
                        'roles_item_id' => $item_id,
                        'print' => 0,
                    ];
                }
            }else{
                $items_print [] = [
                    'roles_item_id' => $item_id,
                    'print' => 0,
                ];
            }

        }

        $record = [];
        foreach($roles_item as $items){
            $record [] = [
                'roles_id'      => $role->id,
                'roles_item_id' => $items,
                'create'        => $this->__getValueArr($items_create, $items, 'create'),
                'read'          => $this->__getValueArr($items_read, $items, 'read'),
                'update'        => $this->__getValueArr($items_update, $items, 'update'),
                'delete'        => $this->__getValueArr($items_delete, $items, 'delete'),
                'print'         => $this->__getValueArr($items_print, $items, 'print'),
                'updated_at'    => Carbon::now()
            ];
        }

        try{
            // Delete dulu yang ada
            DB::table('roles_item_pivot')
                ->where('roles_id',$role->id)
                ->delete();

            // Buat baru untuk roles item nya
            DB::table('roles_item_pivot')
                ->insert($record);

            input_log();
            return redirect('/roles')->with(['pesan'=>'<div class="alert alert-success">Data berhasil diperbarui</div>']);

        }catch(QueryException $e){
            return redirect('/roles')->with(['pesan'=>'<div class="alert alert-danger">'.$e->errorInfo[2].'</div>']);
        }

    }

    private function __getValueArr($val_arr, $roles_item_id, $tipe){
        foreach($val_arr as $arr){
            if($arr['roles_item_id'] == $roles_item_id){
                return $arr[$tipe];
            }
        }
    }

    public function delete($id, Roles $role){

        $roles = Roles::with('users')
                        ->where('id',$id)
                        ->withCount('users')
                        ->first();

        if($roles->users_count > 0){
            return response()->json([
                'tipe' => false,
                'pesan' => 'Roles masih digunakan oleh users'
            ]);
        }

        Roles::where('id',$id)->delete();
        input_log();

        return response()->json([
            'tipe' => true,
            'pesan' => 'Roles berhasil dihapus'
        ]);

    }

    public function pilihan()
    {
        $data['title']  = 'Pilih Roles';

        $userid = Auth::user()->id;
        $roles  = User::with('roles')
                        ->withCount('roles')
                        ->find($userid);

        if($roles->roles_count > 1){
            $data['roles'] = $roles->roles;
            return view('roles.pilihan', $data);
        }

        $roleid = $roles->roles->first()->id;
        return redirect('/roles/pilih/'.$roleid);

    }

    public function pilih($id){
        // get roles
        $roles = Roles::find($id);



        $data = [
            'roles_id'      => $roles->id,
            'roles_nama'    => $roles->nama,
        ];

        session($data);

        // input_log();
        return redirect(route('sender'));
    }
}
