<?php

namespace App\Http\Controllers;

use App\Models\Produit; // Import du modèle Produit
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        // Récupérer les produits (6 par catégorie)
        $telephones = Produit::where('categorie', 1)->take(6)->get();
        $pcs = Produit::where('categorie', 2)->take(6)->get();
        $accessoires = Produit::where('categorie', 3)->take(6)->get();

        return view('home', compact('telephones', 'pcs', 'accessoires'));
    }
}
