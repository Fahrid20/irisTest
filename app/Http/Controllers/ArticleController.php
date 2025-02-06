<?php

namespace App\Http\Controllers;

use App\Models\Produit; // Import du modèle Produit
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function produits()
    {
        $produits = Produit::with(['caracteristiques', 'categorie'])->get();

        return view('produits', compact('produits'));
    }

    public function categorieProduit(Request $request)
    {
        $categorieId = $request->input('categorie'); // Récupère la catégorie depuis l'URL

        if ($categorieId) {
            $produits = Produit::where('categorie', $categorieId)->get();
        } else {
            $produits = Produit::all();
        }

        return view('produits', compact('produits'));
    }

    

 
}


