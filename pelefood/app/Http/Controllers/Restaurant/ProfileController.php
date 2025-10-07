<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $restaurant = auth()->user()->restaurant;
        return view('restaurant.profile.show', compact('restaurant'));
    }

    public function edit()
    {
        $restaurant = auth()->user()->restaurant;
        return view('restaurant.profile.edit', compact('restaurant'));
    }

    public function update(Request $request)
    {
        $restaurant = auth()->user()->restaurant;
        $restaurant->update($request->validated());
        return back()->with('success', 'Profil mis à jour');
    }
} 