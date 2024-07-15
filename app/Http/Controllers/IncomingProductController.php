<?php

namespace App\Http\Controllers;

use App\Models\IncomingProduct;
use App\Models\IncomingProductDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IncomingProductsImport;
use App\Exports\IncomingProductsExport;


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

        // Format the incoming_date
        foreach ($incoming_products as $ip) {
            $ip->formatted_date = \Carbon\Carbon::parse($ip->incoming_date)->format('d M Y');
        }
       
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
            'details.*.qurrent_qty',
            'details.*.description' => 'required',
        ]);

        $incomings = IncomingProduct::create([
            'incoming_code' => $request->input('incoming_code'),
            'incoming_date' => $request->input('incoming_date'),
        ]);

        $detailIncoming = [];
        foreach ($request->input('details') as $detail) {
            $products = Product::find($detail['id_product']);

            // Update product quantity
            $product = Product::find($detail['id_product']);
            $product->quantity += $detail['quantity'];
            $product->save();

            $detailIncoming[] = $incomings->details()->create([
                'id_incoming' => $incomings->id,
                'id_product' => $detail['id_product'],
                'quantity' => $detail['quantity'],
                'description' => $detail['description'],
                'current_qty' => $products->quantity,
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
            'deleted_details' => 'nullable|array',
            'deleted_details.*' => 'nullable|numeric|exists:incoming_product_details,id',
        ]);

        try {
            // Update incoming product
            $incoming_product->update([
                'incoming_code' => $request->input('incoming_code'),
                'incoming_date' => $request->input('incoming_date'),
            ]);

            // Delete removed details
            if ($request->has('deleted_details')) {
                IncomingProductDetail::whereIn('id', $request->input('deleted_details'))->delete();
            }

            foreach ($request->input('details') as $detail) {
                $products = Product::find($detail['id_product']);

                if (isset($detail['id']) && !empty($detail['id'])) {
                    $inDetailModel = IncomingProductDetail::find($detail['id']);
                    if ($inDetailModel) {
                        // Rollback old quantity
                        $products->quantity -= $inDetailModel->quantity;

                        // Update product quantity
                        $products->quantity += $detail['quantity'];
                        $products->save();

                        $inDetailModel->update([
                            'id_incoming' => $incoming_product->id,
                            'id_product' => $detail['id_product'],
                            'quantity' => $detail['quantity'],
                            'description' => $detail['description'],
                            'current_qty' => $products->quantity,
                        ]);
                    }
                } else {
                    // If detail doesn't exist, create new detail
                    $products->quantity += $detail['quantity'];
                    $products->save();

                    $createdInDetail = IncomingProductDetail::create([
                        'id_product' => $detail['id_product'],
                        'quantity' => $detail['quantity'],
                        'description' => $detail['description'],
                        'current_qty' => $products->quantity,
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
        $incoming_product = IncomingProduct::find($id);
        if ($incoming_product) {
            DB::beginTransaction();

            try {
                foreach ($incoming_product->details as $detail) {
                    $product = Product::find($detail->id_product);
                    $product->decrement('quantity', $detail->quantity);
                }

                $incoming_product->delete();

                DB::commit();

                return redirect()->route('incoming_product.index')
                    ->with('success', 'Barang Masuk Berhasil Dihapus');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Barang Masuk Gagal Dihapus: ' . $e->getMessage());
            }
        }
        return redirect()->route('incoming_product')
            ->with('success', 'Barang Masuk Berhasil Dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        Excel::import(new IncomingProductsImport, $request->file('file'));

        return redirect()->route('incoming_product')
            ->with('success', 'Barang Masuk Berhasil Diimport');
    }

    public function export()
    {
        return Excel::download(new IncomingProductsExport, 'incoming_products.xlsx');
    }

}
