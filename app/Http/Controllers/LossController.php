<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loss;
use App\Models\Product;
use App\Models\Purchase;
use Validator;
use DataTables;

class LossController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product  = Product::all();
        $purchase = Purchase::all();
        if ($request->ajax()) {
            $loss = Loss::with('product', 'purchase');
            return DataTables::of($loss)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="icon-bin"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('backend.loss', compact('product', 'purchase'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'product_id'    => 'required',
            'qty'           => 'required',
            'price'         => 'required',
            'date'          => 'required',
            'total'         => 'required',
            'desc'          => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json(['error'        => 'Kesalahan saat mengisi fom!'], 422);
        }
        $loss = Loss::updateOrCreate([
            'id'            => $request->id
        ], [
            'product_id'    => $request->product_id,
            'qty'           => $request->qty,
            'price'         => $request->price,
            'date'          => $request->date,
            'total'         => $request->total,
            'desc'          => $request->desc
        ]);
        $purchase = Purchase::where('id', $request->product_id)->first();
        $product  = Product::where('id', $request->id)->first();
        if ($loss) {
            if ($purchase->qty <= $request->qty) {
                return response()->json(['error'    => 'Melebihi jumlah pembelian!'], 500);
            } else {
                $qty = $product->qty - $request->qty;
                $product->update(['qty' => $qty]);
                return response()->json(['success'  => 'Data berhasil disimpan!'], 200);
            }
        } else {
            return response()->json(['error'        => 'Data error'], 500);
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
        $loss = Loss::find($id);
        return response()->json($loss);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loss = Loss::find($id)->delete();
        if ($loss) {
            return response()->json(['success' => 'Data berhasil dihapus!'], 200);
        }
        return response()->json(['error' => 'Hapus gagal!'], 500);
    }

    public function data(Request $request)
    {
        $loss = Loss::with('purchase', 'product');
        return DataTables::of($loss)
            ->addColumn('action', function ($item) {
                return '<div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item edit" data-id="' . $item->id . '"><i class="icon-pencil7"></i> Edit</a>
                                    <a href="#" class="dropdown-item delete" data-id="' . $item->id . '"><i class="icon-bin"></i> Hapus</a>
                                </div>
                            </div>
                        </div>';
            })
            // ->editColumn('id_product', function($item) {
            //     return '' . $item->product->name_product . '';
            // })
            ->editColumn('price', function($item) {
                return 'Rp. ' . number_format($item->price, 0) . '';
            })
            ->editColumn('total', function($item) {
                return 'Rp. ' . number_format($item->total, 0) . '';
            })
            ->make(true);
    }

    public function getData(Request $request)
    {
        $purchase = Purchase::with('product')->where('id', $request->id)->first();
        if ($purchase) {
            // dd($purchase);
            return response()->json(['success' => 'Data success', 'data' => $purchase], 200);
        } else {
            return response()->json(['error' => 'Data failed', 'data' => $purchase], 404);
        }
    }
}
