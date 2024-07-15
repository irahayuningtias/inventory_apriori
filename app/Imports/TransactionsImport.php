<?php

namespace App\Imports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;

class TransactionsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    private function convertToDecimal($string)
    {
        // Hapus "Rp " dan ganti titik dengan kosong
        $number = str_replace(['Rp ', '.'], ['', ''], $string);
        // Ganti koma dengan titik untuk format decimal
        $number = str_replace(',', '.', $number);

        // Konversi ke float dan format dengan 2 angka di belakang koma
        return number_format((float)$number, 2, '.', '');
    }

    private function convertToDate($value)
    {
        if (is_numeric($value)) {
            // Convert Excel serial date to DateTime object
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }
        return $value;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            $transactions = []; // Untuk menyimpan total_subtotal berdasarkan kode transaksi

            foreach ($rows as $row) {
                if ($row[0] == 'transaction_code') {
                    continue;
                } else if ($row[0] == null) {
                    break;
                }

                // Ambil data dari row
                $transactionCode = $row[0];
                $transactionDate = $this->convertToDate($row[1]);
                $quantity = (int)$row[3];
                $price = $this->convertToDecimal($row[4]);
                $subtotal = $quantity * $price;

                // Menyimpan subtotal berdasarkan kode transaksi
                if (!isset($transactions[$transactionCode])) {
                    $transactions[$transactionCode] = [
                        'transaction_date' => $transactionDate,
                        'total_amount' => 0,
                    ];
                }
                $transactions[$transactionCode]['total_amount'] += $subtotal;

                // Buat detail transaksi
                $transactionDetailData = [
                    'id_product' => $row[2],
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];

                // Simpan detail transaksi
                $transaction = Transaction::firstOrCreate(
                    ['transaction_code' => $transactionCode],
                    [
                        'transaction_date' => $transactionDate,
                        'total_amount' => $transactions[$transactionCode]['total_amount'] // Sertakan total_amount di sini
                    ]
                );

                $transaction->details()->create($transactionDetailData);
            }

            // Update total_amount untuk setiap transaksi
            foreach ($transactions as $code => $data) {
                $transaction = Transaction::where('transaction_code', $code)->first();
                $transaction->total_amount = $data['total_amount'];
                $transaction->save();
            }
        });
    }
}
