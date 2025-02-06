<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Panier;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function afficherCommande()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour passer une commande.');
        }

        $panier = Panier::where('user_id', Auth::id())->with('produit')->get();
        $total = $panier->sum(function ($item) {
            return $item->produit->prix * $item->quantite;
        });

        return view('commande', compact('panier', 'total'));
    }

    public function passerCommande(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:500',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
            'mode_paiement' => 'required|in:carte,paypal,cash',
            'carte_numero' => 'required_if:mode_paiement,carte|nullable|digits:16',
            'carte_expiration' => 'required_if:mode_paiement,carte|nullable|date_format:Y-m',
            'carte_cvv' => 'required_if:mode_paiement,carte|nullable|digits:3',
            'paypal_email' => 'required_if:mode_paiement,paypal|nullable|email',
        ]);
        

        $panier = Panier::where('user_id', Auth::id())->with('produit')->get();
        $total = $panier->sum(function ($item) {
            return $item->produit->prix * $item->quantite;
        });

        if ($total == 0) {
            return redirect()->route('panier.afficher')->with('error', 'Votre panier est vide.');
        }

        $commande = Commande::create([
            'user_id' => Auth::id(),
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'code_postal' => $request->code_postal,
            'mode_paiement' => $request->mode_paiement,
            'total' => $total,
            'statut' => 'en attente',
        ]);

        Panier::where('user_id', Auth::id())->delete();

        return redirect()->route('commande.success', ['id' => $commande->id])->with('success', 'Commande passée avec succès !');
    }

    public function commandeSuccess($id)
    {
        $commande = Commande::findOrFail($id);
        return view('commande-success', compact('commande'));
    }
}
