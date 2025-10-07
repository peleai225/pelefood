<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentTransactionController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()->restaurant->paymentTransactions()->paginate(20);
        return view('restaurant.payment-transactions.index', compact('transactions'));
    }
} 