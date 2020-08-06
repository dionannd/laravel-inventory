<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Validator;
use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $supplier = Supplier::latest()->get();
            return DataTables::of($supplier)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm edit"><i class="icon-pencil7"></i></a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="icon-bin"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('backend.supplier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rule = [
            'name'      => 'required',
            'company'   => 'nullable',
            'phone'     => 'required',
            'telp'      => 'nullable',
            'email'     => 'required',
            'address'   => 'required',
        ];
        $validation = Validator::make($input, $rule);
        if ($validation->fails()){
            return response()->json(['error'    => 'Kesalahan saat mengisi form!'], 422);
        }
        $supplier = Supplier::updateOrCreate([
            'id'        => $request->id
        ],[
            'name'      => $request->name,
            'company'   => $request->company,
            'phone'     => $request->phone,
            'telp'      => $request->telp,
            'email'     => $request->email,
            'address'   => $request->address
        ]);
        if ($supplier){
            return response()->json(['success'  => 'Data berhasil disimpan!'], 200);
        } else {
            return response()->json(['error'    => 'Simpan gagal!'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id)->delete();
        if ($supplier) {
            return response()->json(['success'  => 'Data berhasil dihapus!'], 200);
        } else {
            return response()->json(['error'    => 'Hapus gagal!'], 500);
        }
    }

    public function data(Request $request)
    {
        $supplier = Supplier::query();
        return DataTables::of($supplier)
        ->addIndexColumn()
        ->addColumn('action', function ($item) {
            return '<div class="list-icons">
                        <div class="dropdown">
                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item edit" data-id="'.$item->id.'"><i class="icon-pencil7"></i> Edit</a>
                                <a href="#" class="dropdown-item delete" data-id="'.$item->id.'"><i class="icon-bin"></i> Hapus</a>
                            </div>
                        </div>
                    </div>';
        })
        ->make(true);
    }
}