<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use DataTables;
use Validator;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $finance = Finance::latest()->get();
            return DataTables::of($finance)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm edit"><i class="icon-pencil7"></i></a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="icon-bin"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->editColumn('balance', function($item) {
                return 'Rp. ' . number_format($item->balance, 0) . '';
            })
            ->editColumn('created_at', function($item) {
                return '' . $item->created_at->format('d, M Y H:i') . '';
            })
            ->make(true);
        }
        return view('backend.finance');
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
            'code'      => 'required',
            'name'      => 'required',
            'desc'      => 'nullable',
            'category'  => 'required',
            'balance'   => 'required'
        ];
        $validator = Validator::make($input, $rule);
        if ($validator->fails()) {
            return response()->json(['error'    => 'Kesalahan saat mengisi form!'], 422);
        }
        $finance = Finance::updateOrCreate(['id' => $request->id], [
            'code'      => $request->code,
            'name'      => $request->name,
            'desc'      => $request->desc,
            'category'  => $request->category,
            'balance'   => $request->balance
        ]);
        if ($finance) {
            return response()->json([
                'success'  => 'Data berhasil disimpan!'], 200);
        } else {
            return response()->json([
                'error'    => 'Simpan gagal!'], 500);
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
        $finance = Finance::find($id);
        return response()->json($finance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $finance = Finance::find($id)->delete();
        if ($finance) {
            return response()->json(['success' => 'Data berhasil dihapus!'], 200);
        }
        return response()->json(['error' => 'Hapus gagal!'], 500);
    }
}
