<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Place;
use DataTables;
use Validator;
use File;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = Category::all();
        $place    = Place::all();
        $product  = Product::where('id')->get();
        if ($request->ajax()) {
            $product = Product::with('category', 'place')->latest()->get();
            return DataTables::of($product)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm edit"><i class="fa fa-edit"></i></a>';
                $del = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i></a>';
                $show = $btn.' '.$del.' <a href="javascript:void(0)" class="btn btn-default btn-sm detail" rel="tooltip"
                                            data-placement="bottom"
                                            data-original-title="Detail" 
                                            data-id="'.$row->id.'">
                                                <i class="fa fa-search"></i>
                                        </a>';
                return $show;
            })
            ->editColumn('name', function($row) {
                $name =  '<strong>' .$row->name. '</strong> ';
                $code = '<span class="label label-info ml-auto">' .$row->code. '</span> '.$name;
                return $code;
            })
            ->editColumn('price', function($row) {
                return 'Rp. ' . number_format($row->price, 0) . '';
            })
            ->rawColumns(['action', 'name'])
            ->make(true);
        }
        return view('backend.product', compact('category', 'place', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request->image)) {
            $imageName = $request->date . '_' . $request->image->getClientOriginalExtension();
            request()->image->move(public_path('images/product/' . $request->code_product), $imageName);
        }
        $input = $request->all();
        $rule = [
            'name'        => 'required|string|max:100',
            'code'        => 'required',
            'category_id' => 'required',
            'place_id'    => 'required',
            'qty'         => 'required',
            'purchase_qty'=> 'required',
            'sales_qty'   => 'required',
            'loss_qty'    => 'required',
            'price'       => 'required',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png'
        ];
        $validation = Validator::make($input, $rule);
        if ($validation->fails()) {
            return response()->json(['error' => '<i class="fa fa-clock-o"></i> <i>Tolong isi semua form yang ada!</i>'], 422);
        }
        $image = $request->image;
        if ($request->hasFile('image')) {
            !empty($image) ? File::delete(public_path('upload/product/' . $image)):null;
            $image = $this->saveFile($request->name, $request->file('image'));
        }
        $product = Product::updateOrCreate([
            'id'          => $request->id
        ], [
            'name'        => $request->name,
            'category_id' => $request->category_id,
            'code'        => $request->code,
            'place_id'    => $request->place_id,
            'qty'         => $request->qty,
            'purchase_qty'=> $request->purchase_qty,
            'sales_qty'   => $request->sales_qty,
            'loss_qty'    => $request->loss_qty,
            'price'       => $request->price,
            'image'       => $image
        ]);
        if ($product) {
            return response()->json([
                'success'   => '<i class="fa fa-clock-o"></i> <i>Data berhasil disimpan!</i>,
                                <i>Barang: <strong>'.$request->name.'</strong> telah ditambahkan.</i>'
            ], 200);
        } else {
            return response()->json(['error' => '<i class="fa fa-clock-o"></i> Simpan gagal!'], 500);
        }
    }

    /**
     * Function add Photo
     * 
     * @param int $name $photo
     * @return \Illuminate\Http\Response
     */
    private function saveFile($name, $image)
    {
        $images = str_slug($name) . time() . '.' . $image->getClientOriginalExtension();
        $path   = public_path('upload/product');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        Image::make($image)->save($path . '/' . $images);
        return $images;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id)->delete();
        if ($product) {
            return response()->json(['success' => '<i class="fa fa-clock-o"></i> <i>Data berhasil dihapus!</i>'], 200);
        }
        return response()->json(['error' => 'Hapus gagal!'], 500);
    }
}
