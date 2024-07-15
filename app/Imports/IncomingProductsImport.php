<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\IncomingProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\IncomingProductDetail;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IncomingProductsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Pastikan kode dan tanggal keluar ada
                if (isset($row['incoming_code']) && isset($row['incoming_date']) && isset($row['product_name'])) {
                    // Konversi tanggal keluar ke format Y-m-d
                    $incomingDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['incoming_date'])->format('Y-m-d');

                    // Buat atau temukan entri IncomingProduct
                    $incomingProduct = IncomingProduct::firstOrCreate(
                        ['incoming_code' => $row['incoming_code']],
                        ['incoming_date' => $incomingDate]
                    );

                    // Temukan produk berdasarkan nama
                    $product = Product::where('product_name', $row['product_name'])->first();

                    // Pastikan produk ada
                    if ($product) {
                        // Buat detail produk keluar
                        $incomingProductDetail = IncomingProductDetail::create([
                            'id_incoming' => $incomingProduct->id,
                            'id_product' => $product->id_product,
                            'quantity' => $row['quantity'],
                            'description' => $row['description'],
                            'current_qty' => 0,
                        ]);

                        // Update jumlah produk di tabel produk
                        $product->quantity += $incomingProductDetail->quantity;
                        $product->save();

                        // Update current_qty di tabel detail produk keluar
                        $incomingProductDetail->current_qty = $product->quantity;
                        $incomingProductDetail->save();
                    } else {
                        Log::warning('Product not found', ['product_name' => $row['product_name']]);
                    }
                } else {
                    Log::warning('Missing incoming_code, incoming_date, or product_name', $row->toArray());
                }
            }
        });
    }
}
