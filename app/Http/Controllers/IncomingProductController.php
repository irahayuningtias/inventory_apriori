<?php

namespace App\Http\Controllers;

use App\Models\IncomingProduct;
use App\Models\IncomingProductDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomingProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incoming_products = IncomingProduct::with('details')->get();
       
        return view('persediaan.barang_masuk.index', compact('incoming_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        return view('persediaan.barang_masuk.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $details = new IncomingProductDetail;

        //melakukan validasi data
        // dd($request->all());
        $data = $request->validate([
            'incoming_code' => 'required|unique:incoming_product,incoming_code',
            'incoming_date' => 'required|date',
            'details.*.id_product' => 'required|exists:product,id_product',
            'details.*.quantity' => 'required|integer|min:0',
            'details.*.description' => 'required',
        ]);

        $incomings = IncomingProduct::create([
            'incoming_code' => $request->input('incoming_code'),
            'incoming_date' => $request->input('incoming_date'),
        ]);

        $detailIncoming = [];
        foreach ($request->input('details') as $detail) {
            $products = Product::find($detail['id_product']);

            $detailIncoming[] = $incomings->details()->create([
                'id_incoming' => $incomings->id,
                'id_product' => $detail['id_product'],
                'quantity' => $detail['quantity'],
                'description' => $detail['description'],
            ]);

        }

        DB::commit();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('incoming_product')
            ->with('success', 'Barang Masuk Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(IncomingProduct $incoming_product)
    {
        $incoming_product->load('details');
        $incoming_product->details->each(function($detail) {
            $detail->load('product');
        });
        return view('persediaan.barang_masuk.show', compact('incoming_product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomingProduct $incoming_product)
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        $details = $incoming_product->details;
        return view('persediaan.barang_masuk.edit', compact('incoming_product', 'products', 'details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, IncomingProduct $incoming_product)
    {
        DB::beginTransaction();

        $details = new IncomingProductDetail;

        // Validate data
        $data = $request->validate([
            'incoming_code' => 'required|unique:incoming_product,incoming_code,' . $incoming_product->id,
            'incoming_date' => 'required|date',
            'details.*.id_product' => 'required|exists:product,id_product',
            'details.*.quantity' => 'required|integer|min:0',
            'details.*.description' => 'required',
            'details.*.id' => 'nullable|numeric',
        ]);

        try {
            // Update incoming product
            $incoming_product->update([
                'incoming_code' => $request->input('incoming_code'),
                'incoming_date' => $request->input('incoming_date'),
            ]);

            $detailIncoming = [];

            foreach ($request->input('details') as $detail) {
                $products = Product::find($detail['id_product']);

                if (isset($detail['id']) && !empty($detail['id'])) {
                    $inDetailModel = IncomingProductDetail::find($detail['id']);
                    if ($inDetailModel) {
                        $inDetailModel->update([
                            'id_incoming' => $incoming_product->id,
                            'id_product' => $detail['id_product'],
                            'quantity' => $detail['quantity'],
                            'description' => $detail['description'],
                        ]);
                    }
                } else {
                    $createdInDetail = IncomingProductDetail::create([
                        'id_product' => $detail['id_product'],
                        'quantity' => $detail['quantity'],
                        'description' => $detail['description'],
                        'id_incoming' => $incoming_product->id,
                    ]);
                }
            }

            DB::commit();

            // If data is successfully updated, return to the main page
            return redirect()->route('incoming_product')
                ->with('success', 'Barang Masuk Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Barang Masuk Gagal Diupdate: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //fungsi eloquent untuk menghapus data
        IncomingProduct::find($id)->delete();
        return redirect()->route('incoming_product')
            ->with('success', 'Barang Masuk Berhasil Dihapus');
    }
}
