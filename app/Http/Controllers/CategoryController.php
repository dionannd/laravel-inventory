<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Validator;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $category = Category::latest()->get();
            return DataTables::of($category)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm edit"><i class="fa fa-edit"></i></a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('backend.category');
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
            'name' => 'required|string|max:100',
            'desc' => 'required'
        ];
        $validation = Validator::make($input, $rule);
        if($validation->fails()){
            return response()->json([
                'error' => '<i class="fa fa-clock-o"></i> <i>Tolong isi semua form yang ada!</i>'
            ], 422);
        }
        $category = Category::updateOrCreate(['id' => $request->id], [
            'name'  => $request->name,
            'desc'  => $request->desc
        ]);
        return response()->json([
            'success'   => '<i class="fa fa-clock-o"></i> <i>Data berhasil disimpan!</i>,
                            <i>Kategori: <strong>'.$request->name.'</strong> telah ditambahkan.</i>'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'success'   => '<i class="fa fa-clock-o"></i> <i>Kategori: <strong>'.$category->name.'</strong> berhasil dihapus!'
        ], 200);
    }
}
