<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $categories = Category::count();
        $products = Product::count();
        $transactions = Transaction::count();
        return view('dashboard', compact('users', 'categories', 'products','transactions'));
    }

}
