<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Produit; // Vous pouvez changer selon votre modèle de produit
use App\Models\Commande;

class ReviewController extends Controller
{
    // Affiche le formulaire de notation
        public function create($commande_id)
    {
        $commande = Commande::findOrFail($commande_id);
        return view('review', compact('commande'));
    }


    // Enregistre l'avis de l'utilisateur
    public function store(Request $request, $product_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);
    
        // Vérifier si le produit existe avant d'ajouter un avis
        $product = Produit::findOrFail($product_id);
    
        // Enregistrement de l'avis
        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
    
        return redirect()->route('propos');
    }


        public function latestReviews()
    {
        $reviews = Review::latest()->take(9)->get();
        return view('reviews_section', compact('reviews'));
    }

    public function showReviews()
    {
        $reviews = Review::latest()->take(9)->get();
        return view('propos', compact('reviews'));
    }
}
 