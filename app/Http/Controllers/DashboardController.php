<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $users = User::count();
        $categories = Category::count();
        $products = Product::count();
        $transactions = Transaction::count();

        // Transaction Chart
        $selectedYear = $request->input('year', date('Y')); //Ambil tahun yang dipilih dari input form, default ke tahun saat ini

        $years = Transaction::selectRaw('YEAR(transaction_date) as year') //Ambil data semua tahun yang ada di tabel transaksi untuk dropdown
                        ->groupBy('year')
                        ->orderBy('year', 'desc')
                        ->pluck('year');
        
        $txChart = Transaction::selectRaw('MONTH(transaction_date) as month, COUNT(*) as count')
                        ->whereYear('transaction_date', $selectedYear)
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get();
        $labels = [];
        $data = [];

        foreach ($txChart as $tx) {
            $labels[] = Carbon::create()->month($tx->month)->format('F');
            $data[] = $tx->count;
        }

        $chartTxData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Number of Transactions',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                    'data' => $data,
                    'fill' => false,
                ],
            ],
        ];
        // end of transaction chart

        return view('dashboard', compact('users', 'categories', 'products','transactions', 'years', 'selectedYear', 'chartTxData'));
    }

}
