<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private function formatRupiah($value)
    {
        return 'Rp ' . number_format($value, 2, ',', '.');
    }


    public function collection()
    {
        $details = TransactionDetail::with('transaction')->get();
        $data = $details->map(function ($detail) {
            return [
                'transaction_code' => $detail->transaction->transaction_code,
                'transaction_date' => $detail->transaction->transaction_date,
                'id_product' => $detail->id_product,
                'quantity' => $detail->quantity,
                'price' => self::formatRupiah($detail->price),
                'subtotal' => self::formatRupiah($detail->subtotal),
                'total_amount' => self::formatRupiah($detail->transaction->total_amount),
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
            'Transaction Code',
            'Transaction Date',
            'Product Code',
            'Quantity',
            'Price',
            'Subtotal',
            'Total Amount',
        ];
    }
}
