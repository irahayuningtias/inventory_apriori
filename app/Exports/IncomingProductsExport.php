<?php

namespace App\Exports;

use App\Models\IncomingProduct;
use App\Models\IncomingProductDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncomingProductsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $details = IncomingProductDetail::with('incomingProduct')->get();
        $data = $details->map(function ($detail) {
            return [
                'incoming_code' => $detail->incomingProduct->incoming_code,
                'incoming_date' => $detail->incomingProduct->incoming_date,
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
            'Incoming Code',
            'Incoming Date',
            'Product Name',
            'Quantity',
            'Current Qty',
            'Description'
        ];
    }
}
