<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransactionsImport;
use App\Exports\TransactionsExport;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::with('details')->get();
        // Format the incoming_date
        foreach ($transactions as $t) {
            $t->formatted_date = \Carbon\Carbon::parse($t->transaction_date)->format('d M Y');
        }
        return view('transaksi.transaction', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        return view('transaksi.add_transaction', compact('products'));
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

        $details = new TransactionDetail;

        //melakukan validasi data
        // dd($request->all());
        $data = $request->validate([
            'transaction_code' => 'required|unique:transaction,transaction_code',
            'transaction_date' => 'required|date',
            'details.*.id_product' => 'required|exists:product,id_product',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.price' => 'required|integer|min:0',
        ]);

        $transactions = Transaction::create([
            'transaction_code' => $request->input('transaction_code'),
            'transaction_date' => $request->input('transaction_date'),
            'total_amount' => 0,
        ]);

        $total_amount = 0;
        $detailTransctions = [];
        foreach ($request->input('details') as $detail) {
            $products = Product::find($detail['id_product']);

            $subtotal = $detail['quantity'] * $products['price'];
            $total_amount += $subtotal;

            $detailTransaction[] = $transactions->details()->create([
                'id_transaction' => $transactions->id,
                'id_product' => $detail['id_product'],
                'quantity' => $detail['quantity'],
                'price' => $products['price'],
                'subtotal' => $subtotal,
            ]);
        }

        $transactions->update(['total_amount' => $total_amount]);
        // dd([
        //     'Transaction' => $transactions,
        //     'detailTransaction' => $detailTransaction
        // ]);
        DB::commit();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('transaction')
            ->with('success', 'Transaksi Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('details');
        $transaction->details->each(function ($detail) {
            $detail->load('product');
        });

        // dd($transaction);
        //mengubah id kembali ke format semula
        // $Transaction = Transaction::findOrFail($id);
        return view('transaksi.detail_transaction', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $products = Product::orderBy('product_name', 'asc')->get();
        $details = $transaction->details;
        //$Transaction = Transaction::with('product')->find($id_transaction);
        return view('transaksi.edit_transaction', compact('transaction', 'products', 'details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        DB::beginTransaction();

        $details = new TransactionDetail;

        // Validate data
        $data = $request->validate([
            'transaction_code' => 'required|unique:transaction,transaction_code,' . $transaction->id,
            'transaction_date' => 'required|date',
            'details.*.id_product' => 'required|exists:product,id_product',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.price' => 'required|numeric|min:0',
            'details.*.id' => 'nullable|numeric',
            'deleted_details' => 'nullable|array',
            'deleted_details.*' => 'nullable|numeric|exists:transaction_details,id',
        ]);

        try {
            // Update transaction
            $transaction->update([
                'transaction_code' => $request->input('transaction_code'),
                'transaction_date' => $request->input('transaction_date'),
                'total_amount' => 0,
            ]);

            // Delete removed details
            if ($request->has('deleted_details')) {
                TransactionDetail::whereIn('id', $request->input('deleted_details'))->delete();
            }

            $total_amount = 0;
            $detailTransctions = [];

            foreach ($request->input('details') as $detail) {
                $products = Product::find($detail['id_product']);
                $subtotal = $detail['quantity'] * $products['price'];
                $total_amount += $subtotal;

                if (isset($detail['id']) && !empty($detail['id'])) {
                    $txDetailModel = TransactionDetail::find($detail['id']);
                    if ($txDetailModel) {
                        $txDetailModel->update([
                            'id_transaction' => $transaction->id,
                            'id_product' => $detail['id_product'],
                            'quantity' => $detail['quantity'],
                            'price' => $products['price'],
                            'subtotal' => $subtotal,
                        ]);
                    }
                } else {
                    $createdTxDetail = TransactionDetail::create([
                        'id_product' => $detail['id_product'],
                        'quantity' => $detail['quantity'],
                        'price' => $products['price'],
                        'subtotal' => $subtotal,
                        'id_transaction' => $transaction->id,
                    ]);
                }
            }

            // Update total amount
            $transaction->update(['total_amount' => $total_amount]);

            DB::commit();

            // If data is successfully updated, return to the main page
            return redirect()->route('transaction')
                ->with('success', 'Transaksi Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Transaksi Gagal Diupdate: ' . $e->getMessage());
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
        Transaction::find($id)->delete();
        return redirect()->route('transaction')
            ->with('success', 'Transaksi Berhasil Dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        Excel::import(new TransactionsImport, $request->file('file'));

        return redirect()->route('transaction')
            ->with('success', 'Transaksi Berhasil Diimport');
    }

    public function export()
    {
        return Excel::download(new TransactionsExport, 'transaction_products.xlsx');
    }
}
