<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Finance;
use App\Models\Sales;
use App\Models\Cashout;
use DataTables;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product = Product::count();
        $customer= Customer::count();
        $supplier= Supplier::count();
        $jual    = Sales::sum('qty');
        $beli    = Purchase::sum('qty');
        $sales   = Sales::sum('total');
        $finance = Finance::sum('balance');
        $cashout = Cashout::sum('nominal');
        $date    = date_default_timezone_set("Asia/Jakarta");
        $b       = time();
        $hour    = date("G",$b);
        $pagi    = "Selamat Pagi";
        $siang   = "Selamat Siang";
        $sore    = "Selamat Sore";
        $petang  = "Selamat Petang";
        $malam   = "Selamat Malam";
        return view('dashboard', compact(
            'product', 'customer', 'supplier', 'sales', 'finance', 'cashout', 'date', 'b', 'hour', 'pagi', 'siang', 'sore', 'petang', 'malam', 'beli', 'jual'
        ));
    }

    public function data(Request $request)
    {
        $product = Product::all();
        return DataTables::of($product)
        ->editColumn('price', function($item) {
            return 'Rp. ' . number_format($item->price, 0) . '';
        })
        ->make(true);
    }
}
