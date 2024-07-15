<?php

namespace App\Http\Controllers;

use App\Models\OutcomingProduct;
use App\Models\OutcomingProductDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OutcomingProductsImport;
use App\Exports\OutcomingProductsExport;

class OutcomingProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outcoming_products = OutcomingProduct::with('details')->get();

        // Format the incoming_date
        foreach ($outcoming_products as $op) {
            $op->formatted_date = \Carbon\Carbon::parse($op->outcoming_date)->format('d M Y');
        }
       
        return view('persediaan.barang_keluar.index', compact('outcoming_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        return view('persediaan.barang_keluar.create', compact('products'));
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

        $details = new OutcomingProductDetail;

        //melakukan validasi data
        // dd($request->all());
        $data = $request->validate([
            'outcoming_code' => 'required|unique:outcoming_products,outcoming_code',
            'outcoming_date' => 'required|date',
            'details.*.id_product' => 'required|exists:product,id_product',
            'details.*.quantity' => 'required|integer|min:0',
            'details.*.description' => 'required',
        ]);

        $outcomings = OutcomingProduct::create([
            'outcoming_code' => $request->input('outcoming_code'),
            'outcoming_date' => $request->input('outcoming_date'),
        ]);

        $detailOutcoming = [];
        foreach ($request->input('details') as $detail) {
            $products = Product::find($detail['id_product']);

            // Update product quantity
            $product = Product::find($detail['id_product']);
            $product->quantity -= $detail['quantity'];
            $product->save();

            $detailOutcoming[] = $outcomings->details()->create([
                'id_incoming' => $outcomings->id,
                'id_product' => $detail['id_product'],
                'quantity' => $detail['quantity'],
                'description' => $detail['description'],
                'current_qty' => $product->quantity,
            ]);
        }

        DB::commit();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('outcoming_product')
            ->with('success', 'Barang Keluar Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OutcomingProduct $outcoming_product)
    {
        $outcoming_product->load('details');
        $outcoming_product->details->each(function($detail) {
            $detail->load('product');
        });
        return view('persediaan.barang_keluar.show', compact('outcoming_product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OutcomingProduct $outcoming_product)
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        $details = $outcoming_product->details;
        return view('persediaan.barang_keluar.edit', compact('outcoming_product', 'products', 'details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, OutcomingProduct $outcoming_product)
    {
        DB::beginTransaction();

        $details = new OutcomingProductDetail;

        // Validate data
        $data = $request->validate([
            'outcoming_code' => 'required|unique:outcoming_products,outcoming_code,' . $outcoming_product->id,
            'outcoming_date' => 'required|date',
            'details.*.id_product' => 'required|exists:product,id_product',
            'details.*.quantity' => 'required|integer|min:0',
            'details.*.description' => 'required',
            'details.*.id' => 'nullable|numeric',
            'deleted_details' => 'nullable|array',
            'deleted_details.*' => 'nullable|numeric|exists:incoming_product_details,id',
        ]);

        try {
            // Update incoming product
            $outcoming_product->update([
                'outcoming_code' => $request->input('outcoming_code'),
                'outcoming_date' => $request->input('outcoming_date'),
            ]);

            // Delete removed details
            if ($request->has('deleted_details')) {
                OutcomingProductDetail::whereIn('id', $request->input('deleted_details'))->delete();
            }

            foreach ($request->input('details') as $detail) {
                $products = Product::find($detail['id_product']);

                if (isset($detail['id']) && !empty($detail['id'])) {
                    $outDetailModel = OutcomingProductDetail::find($detail['id']);
                    if ($outDetailModel) {
                        // Rollback old quantity
                        $products->quantity += $outDetailModel->quantity;

                        // Update product quantity
                        $products->quantity -= $detail['quantity'];
                        $products->save();

                        $outDetailModel->update([
                            'id_outcoming' => $outcoming_product->id,
                            'id_product' => $detail['id_product'],
                            'quantity' => $detail['quantity'],
                            'description' => $detail['description'],
                            'current_qty' => $products->quantity,
                        ]);
                    }
                } else {
                    // If detail doesn't exist, create new detail
                    $products->quantity -= $detail['quantity'];
                    $products->save();

                    $createdOutDetail = OutcomingProductDetail::create([
                        'id_product' => $detail['id_product'],
                        'quantity' => $detail['quantity'],
                        'description' => $detail['description'],
                        'current_qty' => $products->quantity,
                        'id_outcoming' => $outcoming_product->id,
                    ]);
                }
            }

            DB::commit();

            // If data is successfully updated, return to the main page
            return redirect()->route('outcoming_product')
                ->with('success', 'Barang Keluar Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Barang Keluar Gagal Diupdate: ' . $e->getMessage());
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
        OutcomingProduct::find($id)->delete();
        return redirect()->route('outcoming_product')
            ->with('success', 'Barang Keluar Berhasil Dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        Excel::import(new OutcomingProductsImport, $request->file('file'));

        return redirect()->route('outcoming_product')
            ->with('success', 'Barang Keluar Berhasil Diimport');
    }

    public function export()
    {
        return Excel::download(new OutcomingProductsExport, 'outcoming_products.xlsx');
    }
}
