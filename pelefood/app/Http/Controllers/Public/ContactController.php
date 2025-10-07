<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('landing.contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Ici vous pouvez ajouter la logique pour envoyer l'email
        // Par exemple, utiliser Mail::send() ou un service d'email

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès !');
    }
} 