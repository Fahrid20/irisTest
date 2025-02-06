<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    public function ajouterAuPanier($produit_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour ajouter au panier.');
        }

        $produit = Produit::findOrFail($produit_id);

        $panier = Panier::where('user_id', Auth::id())->where('produit_id', $produit_id)->first();

        if ($panier) {
            $panier->increment('quantite'); // Augmente la quantité si le produit est déjà dans le panier
        } else {
            Panier::create([
                'user_id' => Auth::id(),
                'produit_id' => $produit_id,
                'quantite' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    public function afficherPanier()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour voir votre panier.');
        }

        $panier = Panier::where('user_id', Auth::id())->with('produit')->get();

        return view('panier', compact('panier'));
    }

    public function supprimerDuPanier($id)
    {
        $panier = Panier::findOrFail($id);

        if ($panier->user_id == Auth::id()) {
            $panier->delete();
        }

        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }

    public function mettreAJourQuantite(Request $request, $id)
    {
        $item = Panier::findOrFail($id);

        if ($request->action == 'increase') {
            $item->quantite += 1;
        } elseif ($request->action == 'decrease' && $item->quantite > 1) {
            $item->quantite -= 1;
        }

        $item->save();

        return redirect()->back()->with('success', 'Quantité mise à jour avec succès.');
    }

    /**
     * Fonction pour compter le nombre total d'articles dans le panier de l'utilisateur connecté.
     */
    public static function compterArticlesPanier()
    {
        if (Auth::check()) {
            return Panier::where('user_id', Auth::id())->sum('quantite');
        }
        return 0;
    }
}
