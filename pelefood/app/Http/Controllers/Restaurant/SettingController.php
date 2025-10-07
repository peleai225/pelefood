<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        return view('restaurant.settings.index', compact('restaurant'));
    }
}
