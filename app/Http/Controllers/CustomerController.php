<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Validator;
use DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customer = Customer::latest()->get();
            return DataTables::of($customer)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm edit"><i class="icon-pencil7"></i></a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="icon-bin"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('backend.customer');
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
            'phone'     => 'required',
            'email'     => 'required',
            'address'   => 'required'
        ];
        $validation = Validator::make($input, $rule);
        if ($validation->fails()){
            return response()->json([
                'error'    => 'Kesalahan saat mengisi form!'], 422);
        }
        $customer = Customer::updateOrCreate(['id' => $request->id],[
            'name'      => $request->name,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'address'   => $request->address
        ]);
        if ($customer){
            return response()->json([
                'success'  => 'Data berhasil disimpan!'], 200);
        } else {
            return response()->json([
                'error'    => 'Simpan gagal!.'], 500);
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
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id)->delete();
        if ($customer) {
            return response()->json([
                'success' => 'Data berhasil dihapus!'], 200);
        }
        return response()->json([
            'error'       => 'Hapus gagal!'], 500);
    }
}
