<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Finance;
use Validator;
use DataTables;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer   = Customer::all();
        $product    = Product::all();
        $finance    = Finance::all();
        $last_no    = rand();
        $invoice = 'INV/'.date('ym').$last_no;
        if ($request->ajax()) {
            $sales = Sales::with('customer', 'product', 'finance')->get();
            return DataTables::of($sales)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->status == 'pending') {
                    $approve = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Approve" class="btn btn-warning btn-sm approve"><i class="fa fa-clock-o"></i></a>';
                    $delete = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i></a>';
                    $btn = $approve.' '.$delete.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Detail" class="btn btn-default btn-sm detail"><i class="fa fa-search"></i></a>';
                    return $btn;
                } else {
                    $invo = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show Invoice" class="btn btn-default btn-sm invoice"><i class="fa fa-file-archive-o"></i></a>';
                    $btn = $invo. ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Detail" class="btn btn-default btn-sm detail"><i class="fa fa-search"></i></a>';
                    return $btn;
                }
            })
            ->editColumn('status', function($row){
                if ($row->status == 'approve'){
                    return '<span class="label label-success">'.ucfirst($row->status).'</span>';
                } else {
                    return '<span class="label label-danger">'.ucfirst($row->status).'</span>';
                }
            })
            ->editColumn('product', function($row){
                $product = '<strong>'.$row->product->name.'</strong>';
                return $product;
            })
            ->editColumn('created_at', function($row){
                return ''.$row->created_at->format('D, d-m-Y').'';
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);
        }
        return view('backend.sales', compact('customer', 'product', 'invoice', 'finance'));
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
            'invoice'      => 'required',
            'customer_id'  => 'required',
            'finance_id'   => 'required',
            'product_id'   => 'required',
            'qty'          => 'required',
            'desc'         => 'required',
            'price'        => 'required',
            'cost'         => 'required',
            'total'        => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json(['error'        => '<i class="fa fa-clock-o"></i> <i>Tolong isi semua form yang ada!</i>'], 422);
        }
        $sales = Sales::updateOrCreate(['id' => $request->id], [
            'invoice'     => $request->invoice,
            'customer_id' => $request->customer_id,
            'finance_id'  => $request->finance_id,
            'product_id'  => $request->product_id,
            'qty'         => $request->qty,
            'desc'        => $request->desc,
            'price'       => $request->price,
            'cost'        => $request->cost,
            'total'       => $request->total
        ]);
        $product = Product::where('id', $request->product_id)->first();
        if ($sales) {
            if ($product->qty <= $request->qty) {
                $sales->delete();
                return response()->json(['error'    => '<i class="fa fa-clock-o"></i> <i>Stock barang tidak cukup!</i>'], 500);
            } else {
                return response()->json(['success'  => '<i class="fa fa-clock-o"></i> <i>Data berhasil disimpan!</i>'], 200);
            }
        } else {
            return response()->json(['error'        => 'Simpan gagal!'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice  = Sales::with('customer', 'product')->where('id', $id)->first();
        $product  = Product::where('id')->first();
        $finance  = Finance::where('id')->first();
        $customer = Customer::all();
        return view('frontend.sales_invoice', compact('invoice', 'product', 'customer', 'finance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales = Sales::find($id);
        return response()->json($sales);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales = Sales::find($id)->delete();
        if ($sales) {
            return response()->json(['success'  => '<i class="fa fa-clock-o"></i> <i>Data berhasil dihapus!</i>']);
        } else {
            return response()->json(['error'    => 'Hapus gagal!']);
        }
    }

    public function getPrice(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        if ($product) {
            return response()->json(['success' => 'Data success', 'data' => $product], 200);
        } else {
            return response()->json(['error' => 'Data failed', 'data' => $product], 404);
        }
    }

    public function approve($id)
    {
        $sales = Sales::find($id);
        if ($sales) {
            $qty     = $sales->product->qty - $sales->qty;
            $sales_qty = $sales->product->sales_qty + $sales->qty;
            $balance = $sales->finance->balance + $sales->total;
            $sales->update([
                'status' => 'approve'
            ]);
            $sales->product->update([
                'qty' => $qty,
                'sales_qty' => $sales_qty
            ]);
            $sales->finance->update([
                'balance' => $balance
            ]);
            return response()->json(['success' => '<i class="fa fa-clock-o"></i> <i>Aprrove berhasil!</i>']);
        }
        return response()->json(['error' => 'Gagal Approve!']);
    }

    public function invoice(Request $request, $id)
    {
        $sales = MsSales::with('customer', 'product')->where('id', $id)->first();
        $product = MsProduct::where('id')->first();
        $customer = MsCustomer::all();
        return view('backend.sales.invoice', compact('sales', 'product', 'customer'));
    }
}
