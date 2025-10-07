<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = auth()->user()->restaurant->paymentMethods()->paginate(20);
        return view('restaurant.payment-methods.index', compact('paymentMethods'));
    }
} 