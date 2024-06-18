<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $products = Product::with('category')->orderBy('id_category', 'asc')->get();
        return view('barang.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('barang.add_product', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'id_product' => 'required',
            'id_category' => 'required',
            'product_name' => 'required',
            'quantity' => 'required',
            'price' => 'required'
        ]);

        //fungsi eloquent untuk menambah data
        Product::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('product')
            ->with('success', 'Barang Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_product)
    {
        $Product = Product::find($id_product);
        return view('barang.detail_product', compact('Product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_product)
    {
        $categories = Category::all();
        $Product = Product::with('category')->find($id_product);
        return view('barang.edit_product', compact('Product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_product)
    {
        //melakukan validasi data
        $request->validate([
            'id_product' => 'required',
            'id_category' => 'required',
            'product_name' => 'required',
            'quantity' => 'required',
            'price' => 'required'
        ]);

        //fungsi eloquent untuk mengupdate data inputan
        Product::find($id_product)->update($request->all());

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('product')
            -> with('success', 'Barang Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_product)
    {
        //fungsi eloquent untuk menghapus data
        Product::find($id_product)->delete();
        return redirect()->route('product')
            ->with('success', 'Barang Berhasil Dihapus');
    }

    public function search(Request $request)
    {
        $search = $request->input('q');
        $products = Product::where('product_name', 'LIKE', "%$search%")->get();
        return response()->json($products);
    }
}
