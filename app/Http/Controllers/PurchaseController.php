<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Finance;
use Validator;
use DataTables;
use PDF;
use App;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $supplier   = Supplier::all();
        $product    = Product::all();
        $last_no    = Purchase::max('id')+rand();
        $invoice = 'ORD/'.date('ym').$last_no;
        $filter     = Finance::where('category', '=' ,'Pembelian')->get();
        if ($request->ajax()) {
            $purchase = Purchase::with('product', 'supplier', 'finance');
            return DataTables::of($purchase)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->status == 'pending') {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Approve" class="edit btn btn-info btn-sm approve"><i class="icon-forward"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="icon-bin"></i></a>';
                    return $btn;
                } else {
                    $btn = '<a href="' . route('purchase.show', ['id' => $row->id]) . '" class="dropdown-item"><i class="icon-file-eye"></i></a>';
                    return $btn;
                }
            })
            ->editColumn('status', function($row){
                if ($row->status == 'approve'){
                    $approve = ' <span class="badge badge-success">' .$row->status. '</span>';
                    return $approve;
                } else {
                    $pending = ' <span class="badge badge-danger">' .$row->status. '</span>';
                    return $pending;
                }
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
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);
        }
        return view('backend.purchase', compact('invoice', 'supplier', 'product', 'filter', 'purchase'));
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
            'supplier_id'  => 'required',
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
        $purchase = Purchase::updateOrCreate([
            'id'            => $request->id
        ],[
            'invoice'       => $request->invoice,
            'supplier_id'   => $request->supplier_id,
            'finance_id'    => $request->finance_id,
            'product_id'    => $request->product_id,
            'qty'           => $request->qty,
            'price'         => $request->price,
            'subtotal'      => $request->subtotal,
            'cost'          => $request->cost,
            'total'         => $request->total
        ]);
        $product = Product::where('id', $request->product_id)->first();
        $finance = Finance::where('id', $request->finance_id)->first();
        if ($purchase){
            if ($finance->balance <= $request->total) {
                $purchase->delete();
                return response()->json(['error'    => 'Pembayaran tidak cukup!'], 500);
            } else {
                return response()->json(['success'  => 'Data berhasil disimpan!'], 200);
            }
        } else {
            return response()->json(['error'        => 'Simpan gagal!'], 500);
        }
    }

    public function approve($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->update(['status' => 'approve']);
        if ($purchase->status == 'approve') {
            $product = Product::select('qty')->where('id', $id)->get();
            $finance = Finance::select('balance')->where('id', $id)->get();
            $qty     = $product->qty + $purchase->qty;
            $balance = $finance->balance - $purchase->total;
            $product->update(['qty' => $qty]);
            $product->update(['purchase_qty' => $qty]);
            $finance->update(['balance' => $balance]);
            return redirect()->back();
        }
        return response()->json(['error' => $purchase]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $product    = Product::where('id', $id)->first();
    //     $finance    = Finance::where('id', $id)->first();
    //     $supplier   = Supplier::all();
    //     $invoice    = Purchase::with('supplier', 'product','finance')->where('id', $id)->first();
    //     return view('frontend.purchase_invoice', compact('invoice', 'product', 'finance', 'supplier' ));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase   = Purchase::find($id);
        return response()->json($purchase);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::find($id)->delete();
        if ($purchase) {
            return response()->json(['success'  => 'Data berhasil dihapus!'], 200);
        } else {
            return response()->json(['error'    => 'Hapus gagal!'], 500);
        }
    }

    public function data(Request $request)
    {
        $purchase = Purchase::with('supplier', 'product', 'finance');
        return DataTables::of($purchase)
        ->addIndexColumn()
        ->addColumn('action', function ($item) {
            if ($item->status == 'approve'){
                return '<div class="list-icons list-icons-extended">
                            <div class="list-icons-item dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="' . route('purchase.show', ['id' => $item->id]) . '" class="dropdown-item"><i class="icon-file-eye"></i> Invoice</a>
                                    <a href="#" class="dropdown-item delete" data-id="'.$item->id.'"><i class="icon-bin"></i> Hapus</a>
                                </div>
                            </div>
                        </div>';
            } else {
                return '<div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item approve" data-id="'.$item->id.'"><i class="icon-forward"></i> Approve</a>
                                    <a href="#" class="dropdown-item delete" data-id="'.$item->id.'"><i class="icon-bin"></i> Hapus</a>
                                </div>
                            </div>
                        </div>';
            }
        })
        ->editColumn('status', function($item){
            if($item->status == 'approve'){
                return '<label class="badge badge-success">'.$item->status.'</label>';
            } else {
                return '<label class="badge badge-danger">'.$item->status.'</label>';
            }
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
        ->escapeColumns([])
        ->make(true);
    }

    public function export_pdf($id)
    {
        $invoicePurchase = MsPurchase::with('supplier', 'product','finance')->where('id', $id)->first();
        $product = MsProduct::where('id')->first();
        $finance = MsFinance::where('id')->first();
        $supplier = MsSupplier::all();

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadView('frontend.purchase_pdf', compact('invoicePurchase', 'product', 'finance', 'supplier' ));
        $pdf->setPaper('a4')->setOption('margin-top', 0)->setOption('margin-bottom', 0);
        return $pdf->inline();
    }
}
