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
        $last_no    = rand();
        $invoice = 'ORD/'.date('ym').$last_no;
        $filter     = Finance::where('category', '=' ,'Pembelian')->get();
        if ($request->ajax()) {
            $purchase = Purchase::orderByRaw("FIELD(status, \"pending\", \"approve\")")->with('product', 'supplier', 'finance')->get();
            return DataTables::of($purchase)
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
        return view('backend.purchase', compact('invoice', 'supplier', 'product', 'filter'));
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
            return response()->json(['error'        => '<i class="fa fa-clock-o"></i> <i>Tolong isi semua form yang ada!</i>'], 422);
        }
        $purchase = Purchase::updateOrCreate(['id' => $request->id],[
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
                return response()->json(['error'    => '<i class="fa fa-clock-o"></i> <i>Pembayaran tidak cukup, Saldo anda kurang!</i>'], 500);
            } else {
                return response()->json(['success'  => '<i class="fa fa-clock-o"></i> <i>Data berhasil disimpan!</i>'], 200);
            }
        } else {
            return response()->json(['error'        => 'Simpan gagal!'], 500);
        }
    }

    public function approve($id)
    {
        $purchase = Purchase::find($id);
        if ($purchase) {
            $qty     = $purchase->product->qty + $purchase->qty;
            $balance = $purchase->finance->balance - $purchase->total;
            $purchase->update([
                'status' => 'approve'
            ]);
            $purchase->product->update([
                'qty' => $qty,
                'purchase_qty' => $qty
            ]);
            $purchase->finance->update([
                'balance' => $balance
            ]);
            return response()->json(['success' => '<i class="fa fa-clock-o"></i> <i>Aprrove berhasil!</i>']);
        }
        $purchase->update(['status' => 'pending']);
        return response()->json(['error' => 'Gagal Approve!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product    = Product::where('id', $id)->first();
        $finance    = Finance::where('id', $id)->first();
        $supplier   = Supplier::all();
        $invoice    = Purchase::with('supplier', 'product','finance')->where('id', $id)->first();
        return view('frontend.purchase_invoice', compact('invoice', 'product', 'finance', 'supplier' ));
    }

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
            return response()->json(['success'  => '<i class="fa fa-clock-o"></i> <i>Data berhasil dihapus!</i>'], 200);
        } else {
            return response()->json(['error'    => '<i class="fa fa-clock-o"></i> <i>Hapus gagal!</i>'], 500);
        }
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
