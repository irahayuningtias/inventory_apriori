<?php

namespace App\Exports;

use App\Models\OutcomingProduct;
use App\Models\OutcomingProductDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OutcomingProductsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $details = OutcomingProductDetail::with('outcomingProduct')->get();
        // Map data sesuai dengan urutan yang diinginkan
        $data = $details->map(function ($detail) {
            return [
                'outcoming_code' => $detail->outcomingProduct->outcoming_code,
                'outcoming_date' => $detail->outcomingProduct->outcoming_date,
                'product_name' => $detail->product->product_name,
                'quantity' => $detail->quantity,
                'current_qty' => $detail->current_qty,
                'description' => $detail->description,
            ];
        });
        return $data;
    }

    /**
     * Define headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Outcoming Code',
            'Outcoming Date',
            'Product Name',
            'Quantity',
            'Current Qty',
            'Description'
        ];
    }
}
