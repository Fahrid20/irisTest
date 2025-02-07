<?php



namespace App\Http\Controllers;

use App\Models\Produit; // Import du modèle Produit
use App\Models\CommandeDetail; // Import du modèle CommandeDetail
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

        // Récupérer les 3 produits les plus vendus
        $topVentes = CommandeDetail::select('produit_id')
            ->selectRaw('SUM(quantite) as total_vendu')
            ->groupBy('produit_id')
            ->orderByDesc('total_vendu')
            ->take(3)
            ->with('produit') // Charger les infos des produits
            ->get()
            ->map(function ($detail) {
                return $detail->produit;
            });

        return view('home', compact('telephones', 'pcs', 'accessoires', 'topVentes'));
    }
}
