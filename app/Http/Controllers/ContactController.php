<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Models\Contact; // Import du modèle

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Enregistrer dans la base de données
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);

        // Envoyer l'email
        Mail::to('mmarc71779@gmail.com')->send(new ContactMail($validated));

        return redirect()->back()->with('success', 'Votre message a été envoyé et enregistré.');
    }
}
