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
            $loss = Loss::with('purchase', 'product');
            return DataTables::of($loss)
            ->addIndexColumn()
            ->editColumn('status', function($row){
                if ($row->status == 'checked'){
                    return '<span class="label label-success">'.ucfirst($row->status).'</span>';
                } else {
                    return '<span class="label label-warning">'.ucfirst($row->status).'</span>';
                }
            })
            ->addColumn('action', function($row){
                if ($row->status == 'checking') {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Checking" class="btn btn-success btn-sm check"><i class="fa fa-clock-o"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Detail" class="btn btn-default btn-sm detail"><i class="fa fa-search"></i></a>';
                    return $btn;
                } else {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Detail" class="btn btn-default btn-sm detail"><i class="fa fa-search"></i></a>';
                    return $btn;
                }
            })
            ->editColumn('product', function($row) {
                $product =  '<span class="label label-primary">'.$row->purchase->invoice.'</span> <strong>'.$row->product_id.'</strong>';
                return $product;
            })
            ->editColumn('date', function($row) {
                $input =  $row->date;
                $date = strtotime($input);
                return date('d-m-Y', $date);
            })
            ->escapeColumns([])
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('backend.loss', compact('purchase', 'product'));
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
            'invoice'       => 'required',
            'product_id'    => 'required',
            'qty'           => 'required',
            'price'         => 'required',
            'date'          => 'required',
            'total'         => 'required',
            'desc'          => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json(['error'        => '<i class="fa fa-clock-o"></i> <i>Tolong isi semua form yang ada!</i>'], 422);
        }
        $loss = Loss::updateOrCreate(['id' => $request->id], [
            'invoice'       => $request->invoice,
            'product_id'    => $request->product_id,
            'qty'           => $request->qty,
            'price'         => $request->price,
            'date'          => $request->date,
            'total'         => $request->total,
            'desc'          => $request->desc
        ]);
        if ($loss) {
            if ($request->qty >= $loss->purchase->qty) {
                $loss->delete();
                return response()->json(['error'    => '<i class="fa fa-clock-o"></i> <i>Melebihi jumlah pembelian!</i>'], 500);
            } elseif ($request->qty = '0') {
                $loss->delete();
                return response()->json(['error'    => '<i class="fa fa-clock-o"></i> <i>Silahkan isi jumlah barang!</i>'], 500);
            } else {
                return response()->json(['success'  => '<i class="fa fa-clock-o"></i> <i>Data berhasil disimpan!</i>'], 200);
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

    public function checking($id)
    {
        $loss = Loss::where('id', $id)->first();
        if ($loss) {
            $qty      = $loss->product->qty - $loss->qty;
            $loss_qty = $loss->product->loss_qty + $loss->qty;
            $loss->update([
                'status' => 'checked'
            ]);
            $loss->product->update([
                'qty' => $qty,
                'loss_qty' => $loss_qty
            ]);
            return response()->json(['success' => '<i class="fa fa-clock-o"></i> <i>Data berhasil dicek!</i>']);
        }
        return response()->json(['error' => 'Gagal Approve!']);
    }

    public function getData(Request $request)
    {
        $data = Purchase::where('id', $request->id)->first();
        if ($data) {
            return response()->json(['success' => 'Data success', 'data' => $data], 200);
        } else {
            return response()->json(['error' => 'Data failed', 'data' => $data], 404);
        }
    }
}
