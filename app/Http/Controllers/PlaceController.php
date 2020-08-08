<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use Validator;
use DataTables;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $place = Place::latest()->get();
            return DataTables::of($place)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm edit"><i class="fa fa-edit"></i></a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('backend.place');
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
            'name'  => 'required|string|max:100',
            'desc'  => 'required|string'
        ];
        $validation = Validator::make($input, $rule);
        if($validation->fails()) {
            return response()->json(['error'    => '<i class="fa fa-clock-o"></i> <i>Tolong isi semua form yang ada!</i>'], 422);
        }
        $place = Place::updateOrCreate(['id'    => $request->id],[
            'name'  => $request->name,
            'desc'  => $request->desc
        ]);
        return response()->json([
            'success'   => '<i class="fa fa-clock-o"></i> <i>Data berhasil disimpan!</i>,
                            <i>Tempat Barang: <strong>'.$request->name.'</strong> telah ditambahkan.</i>',
            'data'      => $place
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
        $place = Place::find($id);
        return response()->json($place);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::find($id);
        $place->delete();
        return response()->json(['success'  => '<i class="fa fa-clock-o"></i> <i>Tempat Barang: <strong>'.$place->name.'</strong> berhasil dihapus!'], 200);
    }
}
