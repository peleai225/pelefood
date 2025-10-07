<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        return view('staff.orders.index');
    }

    public function show($id)
    {
        return view('staff.orders.show', compact('id'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Logique de mise à jour du statut
        return back()->with('success', 'Statut mis à jour');
    }

    public function export()
    {
        // Logique d'export
        return back()->with('success', 'Export en cours');
    }
} 