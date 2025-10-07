<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = auth()->user()->restaurant->invoices()->paginate(20);
        return view('restaurant.invoices.index', compact('invoices'));
    }
}
