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
    public function index()
    {
        $customer   = Customer::all();
        $product    = Product::all();
        $finance    = Finance::all();
        $last_no    = Sales::max('id') + 25;
        $invoice = 'INV/' . date('ym') . $last_no;
        // $filter = MsFinance::where('category', '=' ,'Penjualan')->get();
        return view('backend.sales', compact('customer', 'product', 'invoice', 'finance', 'filter'));
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
            'desc'         => 'nullable',
            'price'        => 'required',
            'cost'         => 'required',
            'total'        => 'required',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json(['error'        => 'Kesalahan saat mengisi form!'], 422);
        }
        $sales = Sales::updateOrCreate([
            'id'          => $request->id
        ], [
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
        $finance = Finance::where('id', $request->finance_id)->first();
        if ($sales) {
            if ($product->qty <= $request->qty) {
                $sales->delete();
                return response()->json(['error'    => 'Jumlah barang tidak cukup!'], 500);
            } else {
                $qtyResult = $product->qty - $request->qty;
                $product->update(['qty'             => $qtyResult]);

                $balanceResult = $finance->balance + $request->total;
                $finance->update(['balance'         => $balanceResult]);

                return response()->json(['success'  => 'Data berhasil disimpan!'], 200);
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
            return response()->json(['success'  => 'Data berhasil dihapus!']);
        } else {
            return response()->json(['error'    => 'Hapus gagal!']);
        }
    }

    public function data(Request $request)
    {
        $sales = Sales::with('customer', 'product', 'finance');
        return DataTables::of($sales)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                return '<div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="' . route('sales.show', ['id' => $item->id]) . '" class="dropdown-item"><i class="icon-file-eye"></i> Invoice</a>
                                    <a href="#" class="dropdown-item delete" data-id="' . $item->id . '"><i class="icon-cross2"></i> Hapus</a>
                                </div>
                            </div>
                        </div>';
            })
            ->editColumn('price', function($item) {
                return 'Rp. ' . number_format($item->price, 0) . '';
            })
            ->editColumn('subtotal', function($item) {
                return 'Rp. ' . number_format($item->subtotal, 0) . '';
            })
            ->editColumn('cost', function($item) {
                return 'Rp. ' . number_format($item->cost, 0) . '';
            })
            ->editColumn('total', function($item) {
                return 'Rp. ' . number_format($item->total, 0) . '';
            })
            ->make(true);
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

    public function invoice(Request $request, $id)
    {
        $sales = MsSales::with('customer', 'product')->where('id', $id)->first();
        $product = MsProduct::where('id')->first();
        $customer = MsCustomer::all();
        return view('backend.sales.invoice', compact('sales', 'product', 'customer'));
    }
}
