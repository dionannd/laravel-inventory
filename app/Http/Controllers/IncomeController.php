<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Finance;
use DataTables;
use Validator;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $finance = Finance::all();
        if ($request->ajax()) {
            $income = Income::with('finance');
            return DataTables::of($income)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->editColumn('created_at', function($item) {
                return '' . $item->created_at->format('d M Y') . '';
            })
            ->editColumn('nominal', function($row) {
                return 'Rp. ' . number_format($row->price, 0) . '';
            })
            ->make(true);
        }
        return view('backend.income', compact('finance'));
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
            'expense'       => 'required',
            'finance_id'    => 'required',
            'desc'          => 'required',
            'nominal'       => 'required',
        ];
        $validator = Validator::make($input, $rule);
        if ($validator->fails()){
            return response()->json([
                'error'    => 'Kesalahan saat mengisi form!'
            ], 422);
        }
        $income = Income::updateOrCreate([
            'id'            => $request->id
        ],[
            'expense'       => $request->expense,
            'finance_id'    => $request->finance_id,
            'desc'          => $request->desc,
            'nominal'       => $request->nominal
        ]);
        if ($income){
            $finance = Finance::where('id', $request->finance_id)->first();
            $result = $finance->balance + $request->nominal;
            $finance->update(['balance' => $result]);
            return response()->json([
                'success'  => '<i class="fa fa-clock-o"></i> Data berhasil disimpan!'
            ], 200);
        } else {
            return response()->json([
                'error'    => 'Simpan gagal!'
            ], 500);
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
        $income = Income::find($id);
        return response()->json($income);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $income = Income::find($id)->delete();
        if ($income) {
            return response()->json([
                'success'   => '<i class="fa fa-clock-o"></i> Data berhasil dihapus!'
            ], 200);
        } else {
            return response()->json([
                'error'     => 'Hapus gagal!.'
            ], 500);
        }
    }
}

