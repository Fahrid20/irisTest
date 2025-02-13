<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Panier;
use Illuminate\Support\Facades\Auth;
use App\Models\CommandeDetail; // Import du modèle
use Stripe\StripeClient;
use Illuminate\Support\Facades\Log;

use Stripe\Stripe;
use Stripe\Charge;





class CommandeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
            $total = $panier->sum(fn ($item) => $item->produit->prix * $item->quantite);

            if ($total == 0) {
                return redirect()->route('panier.afficher')->with('error', 'Votre panier est vide.');
            }

            // 🔹 Enregistrer la commande principale
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

            // 🔹 Enregistrer chaque produit commandé dans `commande_details`
            foreach ($panier as $item) {
                CommandeDetail::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $item->produit->id,
                    'quantite' => $item->quantite,
                    'prix_unitaire' => $item->produit->prix,
                ]);
            }

            // 🔹 Vider le panier après validation
            Panier::where('user_id', Auth::id())->delete();

            return redirect()->route('commande.success', ['id' => $commande->id])
                            ->with('success', 'Commande passée avec succès !');
        }



        public function detailsCommande($id)
        {
            $commande = Commande::with(['details.produit'])->findOrFail($id);

            return response()->json([
                'nom' => $commande->nom,
                'email' => $commande->email,
                'adresse' => $commande->adresse,
                'ville' => $commande->ville,
                'code_postal' => $commande->code_postal,
                'mode_paiement' => $commande->mode_paiement,
                'details' => $commande->details->map(function ($detail) {
                    return [
                        'produit' => [
                            'nom' => $detail->produit->nom,
                        ],
                        'quantite' => $detail->quantite,
                        'prix_unitaire' => $detail->prix_unitaire,
                    ];
                }),
            ]);
        }



    public function commandeSuccess($id)
    {
        $commande = Commande::findOrFail($id);
        return view('commande-success', compact('commande'));
    }


   
   

    /*public function passerCommande(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'nom' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telephone' => 'required|string|max:20',
                'adresse' => 'required|string|max:500',
                'ville' => 'required|string|max:255',
                'code_postal' => 'required|string|max:10',
                'mode_paiement' => 'required|in:carte,paypal,cash',
                'stripeToken' => 'required_if:mode_paiement,carte|string',
            ]);
    
            // Récupération du panier de l'utilisateur
            $panier = Panier::where('user_id', Auth::id())->with('produit')->get();
            $total = $panier->sum(fn ($item) => $item->produit->prix * $item->quantite);
    
            if ($total == 0) {
                return redirect()->route('panier.afficher')->with('error', 'Votre panier est vide.');
            }
    
            // Création de la commande
            try {
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
            } catch (\Exception $e) {
                Log::error('Erreur lors de la création de la commande : ' . $e->getMessage());
                return back()->with('error', 'Une erreur est survenue lors de la création de la commande.');
            }
    
            // Gestion du paiement via Stripe
            if ($request->mode_paiement == 'carte') {
                if (!$request->has('stripeToken') || empty($request->stripeToken)) {
                    return back()->with('error', 'Le token de paiement est invalide.');
                }
            
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            
                try {
                    $charge = \Stripe\Charge::create([
                        'amount' => intval($total * 100), // Montant en centimes
                        'currency' => 'eur',
                        'description' => 'Commande #' . $commande->id,
                        'source' => $request->stripeToken,
                    ]);
            
                    Log::info('Paiement Stripe réussi : ', ['charge_id' => $charge->id]);
            
                    // Mettre à jour la commande avec le statut "payée"
                    $commande->update(['statut' => 'payée']);
            
                } catch (\Stripe\Exception\CardException $e) {
                    Log::error('Erreur Stripe : ' . $e->getMessage());
                    return back()->with('error', 'Erreur de paiement : ' . $e->getMessage());
                }
            }
            
    
            // Enregistrement des détails de la commande
            try {
                foreach ($panier as $item) {
                    CommandeDetail::create([
                        'commande_id' => $commande->id,
                        'produit_id' => $item->produit->id,
                        'quantite' => $item->quantite,
                        'prix_unitaire' => $item->produit->prix,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l’enregistrement des détails de la commande : ' . $e->getMessage());
                return back()->with('error', 'Une erreur est survenue lors de l’ajout des produits à votre commande.');
            }
    
            // Vider le panier
            try {
                Panier::where('user_id', Auth::id())->delete();
            } catch (\Exception $e) {
                Log::error('Erreur lors de la suppression du panier : ' . $e->getMessage());
                return back()->with('error', 'Une erreur est survenue lors de la mise à jour du panier.');
            }
    
            return redirect()->route('commande.success', ['id' => $commande->id])
                            ->with('success', 'Commande passée avec succès !');
    
        } catch (\Exception $e) {
            Log::error('Erreur inattendue : ' . $e->getMessage());
            return back()->with('error', 'Une erreur inattendue est survenue. Veuillez réessayer.');
        }
    }*/
}



