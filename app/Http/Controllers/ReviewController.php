<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product; // Vous pouvez changer selon votre modèle de produit

class ReviewController extends Controller
{
    // Affiche le formulaire de notation
    public function create(/*$product_id*/)
    {
        /*$product = Product::findOrFail(/*$product_id);*/
        return view('review', /*compact('product')*/);
    }

    // Enregistre l'avis de l'utilisateur
    public function store(Request $request/*, $product_id*/)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Validation de la note (1 à 5)
            'comment' => 'nullable|string|max:500', // Commentaire facultatif
        ]);

        // Enregistrement de l'avis
        Review::create([
            'product_id' => $product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('product.show'/*, $product_id*/)->with('success', 'Votre avis a été enregistré !');
    }
}
