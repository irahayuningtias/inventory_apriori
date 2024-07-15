<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\OutcomingProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\OutcomingProductDetail;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OutcomingProductsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Pastikan kode dan tanggal keluar ada
                if (isset($row['outcoming_code']) && isset($row['outcoming_date']) && isset($row['product_name'])) {
                    // Konversi tanggal keluar ke format Y-m-d
                    $outcomingDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['outcoming_date'])->format('Y-m-d');

                    // Buat atau temukan entri OutcomingProduct
                    $outcomingProduct = OutcomingProduct::firstOrCreate(
                        ['outcoming_code' => $row['outcoming_code']],
                        ['outcoming_date' => $outcomingDate]
                    );

                    // Temukan produk berdasarkan nama
                    $product = Product::where('product_name', $row['product_name'])->first();

                    // Pastikan produk ada
                    if ($product) {
                        // Buat detail produk keluar
                        $outcomingProductDetail = OutcomingProductDetail::create([
                            'id_outcoming' => $outcomingProduct->id,
                            'id_product' => $product->id_product,
                            'quantity' => $row['quantity'],
                            'description' => $row['description'],
                            'current_qty' => 0,
                        ]);

                        // Update jumlah produk di tabel produk
                        $product->quantity -= $outcomingProductDetail->quantity;
                        $product->save();

                        // Update current_qty di tabel detail produk keluar
                        $outcomingProductDetail->current_qty = $product->quantity;
                        $outcomingProductDetail->save();
                    } else {
                        Log::warning('Product not found', ['product_name' => $row['product_name']]);
                    }
                } else {
                    Log::warning('Missing outcoming_code, outcoming_date, or product_name', $row->toArray());
                }
            }
        });
    }
}
