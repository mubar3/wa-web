<?php

namespace App\Http\Controllers;

use App\Models\RolesItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;
use Illuminate\Database\QueryException;

class RolesItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('role:rolesitem,read')->only('index');
        $this->middleware('role:rolesitem,create')->only(['create','store']);
        $this->middleware('role:rolesitem,update')->only(['edit','update']);
        $this->middleware('role:rolesitem,delete')->only('delete');
    }

    public function index()
    {
        $data['title'] = 'Pengaturan Roles Item';
        return view('rolesitem.index', $data);
    }

    public function ajax()
    {
        return DataTables::eloquent(RolesItem::query())
            ->addColumn('aksi', function ($d) {
                $data = '';

                if(hakAksesMenu('rolesitem','update')){
                    $data .= '<a href="/rolesitem/' . $d->id . '/edit" class="edit-btn"><i class="feather-edit"></i></a>';
                }

                if(hakAksesMenu('rolesitem','delete')){
                    $data .= '<a href="/rolesitem/delete/' . $d->id . '" data-nama="' . $d->nama . '" data-tipe="hapus" class="hapus-btn hapus_data_list"><i class="feather-x-circle"></i></a>';
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
        $title = 'Tambah Roles Item';
        $validator = JSvalidation::make([
            'nama'  => 'required|unique:roles_items'
        ]);

        return view('rolesitem.create')->with([
            'title' => $title,
            'validator' => $validator
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

        $validasi = $r->validate([
            'nama'  => 'required|unique:roles_items'
        ]);

        try {
            RolesItem::create($validasi);

            input_log();
            return redirect('/rolesitem')->with(['pesan' => '<div class="alert alert-success">Data berhasil ditambahkan</div>']);
        } catch (QueryException $e) {

            return redirect('/rolesitem')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RolesItem  $rolesItem
     * @return \Illuminate\Http\Response
     */
    public function show(RolesItem $rolesitem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RolesItem  $rolesItem
     * @return \Illuminate\Http\Response
     */
    public function edit(RolesItem $rolesitem)
    {

        $title = 'Edit Roles Item';
        $validator = JSvalidation::make([
            'nama'  => 'required|unique:roles_items,nama,' . $rolesitem->id,
        ]);

        return view('rolesitem.edit')->with([
            'rolesitem' => $rolesitem,
            'title' => $title,
            'validator' => $validator
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RolesItem  $rolesItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, RolesItem $rolesitem)
    {

        $validasi = $r->validate([
            'nama'  => 'required|unique:roles_items,nama,' . $rolesitem->id,
        ]);
        RolesItem::where('id', $rolesitem->id)->update($validasi);

        input_log();
        return redirect('/rolesitem')->with(['pesan' => '<div class="alert alert-success">Data berhasil diperbarui</div>']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RolesItem  $rolesItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(RolesItem $rolesItem)
    {
        //
    }

    public function delete($id, RolesItem $rolesitem)
    {

        try {
            RolesItem::where('id', $id)->delete();
            input_log();
            return response()->json([
                'tipe' => true,
                'pesan' => 'Roles Item berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'tipe' => false,
                'pesan' => 'Roles item gagal dihapus'
            ]);
        }
    }
}
