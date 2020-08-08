<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cashout;
use App\Models\Finance;
use DataTables;
use Validator;

class CashoutController extends Controller
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
            $cashout = Cashout::with('finance');
            return DataTables::of($cashout)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->editColumn('nominal', function($row) {
                return 'Rp. ' . number_format($row->nominal, 0) . '';
            })
            ->editColumn('created_at', function($item) {
                return '' . $item->created_at->format('d M Y') . '';
            })
            ->make(true);
        }
        return view('backend.cashout', compact('finance'));
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
        $cashout = Cashout::updateOrCreate([
            'id'            => $request->id
        ],[
            'expense'       => $request->expense,
            'finance_id'    => $request->finance_id,
            'desc'          => $request->desc,
            'nominal'       => $request->nominal
        ]);
        if ($cashout){
            $finance = Finance::where('id', $request->finance_id)->first();
            $result = $finance->balance - $request->nominal;
            $finance->update(['balance' => $result]);
            return response()->json([
                'success'  => 'Data berhasil disimpan!'
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
        $cashout = Cashout::find($id);
        return response()->json($cashout);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cashout = Cashout::find($id)->delete();
        if ($cashout) {
            return response()->json([
                'success'   => 'Data berhasil dihapus!'
            ], 200);
        } else {
            return response()->json([
                'error'     => 'Hapus gagal!.'
            ], 500);
        }
    }
}
