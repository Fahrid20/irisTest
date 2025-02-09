<?php
namespace App\Http\Controllers;

use App\Models\Caracteristique;

use App\Models\Produit; // Import du modèle Produit
use App\Models\User;
use App\Models\Commande;
use App\Models\Promotion;
use App\Models\CommandeDetail;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use App\Mail\CommandeStatut;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Log;

use App\Mail\SendEmailToClient;

use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth'); // Assure que l'utilisateur est connecté
   
    }

  

    public function dashboard() {
        $promotions = Promotion::all();
        $clients = User::where('role', 'client')->get();
        $produits = Produit::all();
        $produits = Produit::all();
        $commandes = Commande::with('user')->get();
        $admins = User::where('role', 'admin')->get();

        return view('dashboard', compact('clients', 'produits', 'commandes', 'admins', 'promotions'));
    }

    public function updateProduit(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);
    
        // 📝 Mise à jour des informations principales du produit
        $produit->nom = $request->nom;
        $produit->prix = $request->prix;
        $produit->stock = $request->stock;
        $produit->save();
    
        // ✅ Mise à jour des caractéristiques du produit
        if ($request->has('caracteristiques')) {
            foreach ($request->caracteristiques as $carac) {
                $caracteristique = Caracteristique::find($carac['id']);
                if ($caracteristique) {
                    $caracteristique->description = $carac['description'] ?? $caracteristique->description;
                    $caracteristique->marque = $carac['marque'] ?? $caracteristique->marque;
                    $caracteristique->couleur = $carac['couleur'] ?? $caracteristique->couleur;
                    $caracteristique->save();
                }
            }
        }
    
        return response()->json(['message' => 'Produit mis à jour avec succès']);
    }
    

    
        //senmail

    public function sendEmail(Request $request)
    {
        // Validation des champs
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:2000',
        ]);
    
        // Récupérer le client
        $client = User::findOrFail($request->user_id);
    
        try {
            Mail::to($client->email)->send(new SendEmailToClient($request->message));
            return redirect()->back()->with('success', 'Email envoyé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur d\'envoi d\'email : ' . $e->getMessage());
        }
    }

    public function deleteProduit($id)
    {
        $produit = Produit::findOrFail($id);

        // ❗ Supprimer les caractéristiques associées avant de supprimer le produit
        $produit->caracteristiques()->delete();
        
        /* ❗ Supprimer l'image du produit du stockage
        if ($produit->image) {
            Storage::delete('public/' . $produit->image);
        }*/

        // ✅ Supprimer le produit
        $produit->delete();

        return response()->json(['message' => 'Produit supprimé avec succès']);
    }

    

    public function addAdmin(Request $request)
    {
        // ✅ Validation des champs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
    
        // ✅ Création de l'admin en forçant le rôle à "admin"
        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // 🔑 Hash du mot de passe
            'role' => 'admin', // ✅ Forcer le rôle à "admin"
        ]);
    
        return response()->json([
            'message' => '✅ Admin ajouté avec succès',
            'admin' => $admin
        ]);
    }

    //changer statut commande

    public function updateCommande(Request $request, $id)
    {
        try {
            \Log::info("📩 Requête reçue", ['id' => $id, 'données' => $request->all()]);
    
            $commande = Commande::findOrFail($id);
    
            $request->validate([
                'statut' => 'required|string|in:en attente,en cours de traitement,envoyée'
            ]);
    
            $commande->statut = $request->statut;
            $commande->save();
    
            \Log::info("✅ Statut mis à jour", ['nouveau statut' => $commande->statut]);
    
            // 🔔 Envoi d'un email au client
            Mail::to($commande->user->email)->send(new CommandeStatut($commande));
    
            return response()->json(['message' => 'Statut mis à jour avec succès et email envoyé.']);
        } catch (\Exception $e) {
            \Log::error("❌ Erreur updateCommande", ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    
    //add product

    
 
    
public function ajouterProduit(Request $request)
{
    // Valider les données
    $validator = Validator::make($request->all(), [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'data' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Sauvegarde de l’image
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            // Stockage de l'image dans le répertoire 'public' du storage
            $imagePath = $request->file('image')->store('produits', 'public');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors du téléchargement de l\'image : ' . $e->getMessage()], 500);
        }
    } else {
        return response()->json(['error' => 'Image invalide ou absente'], 400);
    }

    // Décoder les autres données envoyées sous forme de JSON
    $productData = json_decode($request->input('data'), true);

    if (is_null($productData)) {
        return response()->json(['error' => 'Les données du produit sont incorrectes ou absentes'], 400);
    }

    // Création du produit
    try {
        $produit = Produit::create([
            'nom' => $productData['nom'],
            'image' => $imagePath,  // Sauvegarder seulement le chemin relatif
            'stock' => $productData['stock'],
            'prix' => $productData['prix'],
            'categorie' => $productData['categorie_id'],
           
        ]);

        // Ajout des caractéristiques
        foreach ($productData['caracteristics'] as $caracteristic) {
            $newCaracteristic = Caracteristique::create([
                'description' => $caracteristic['description'],
                'marque' => $caracteristic['marque'],
                'couleur' => $caracteristic['couleur'],
                'waterproof' => $caracteristic['waterproof'],
            ]);

            // Association produit <-> caractéristique
            $produit->caracteristiques()->attach($newCaracteristic->id);
        }

        return response()->json(['success' => 'Produit ajouté avec succès'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la création du produit : ' . $e->getMessage()], 500);
    }
}



public function storePromotion(Request $request)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|max:1024',
        'prix_original' => 'nullable|numeric',
        'prix_promo' => 'required|numeric',
        'type' => 'required|string|in:remise,nouveau,offre speciale',
    ]);

    $promotion = new Promotion();
    $promotion->titre = $request->titre;
    $promotion->description = $request->description;
    $promotion->prix_original = $request->prix_original;
    $promotion->prix_promo = $request->prix_promo;
    $promotion->type = $request->type;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('promotions', 'public');
        $promotion->image = $path;
    }

    $promotion->save();

    return response()->json(['success' => 'Promotion ajoutée avec succès', 'promotion' => $promotion]);
}


//details commande
//details commande
public function getCommandeDetails($id)
{
    Log::info("🔍 Récupération des détails pour la commande ID : " . $id);
    
    // Charger les données avec les relations nécessaires
    $commande = Commande::with(['user', 'details.produit', 'details.produit.caracteristique'])->findOrFail($id);


    // Log pour vérifier les données, notamment la couleur
    foreach ($commande->details as $detail) {
        $produit = $detail->produit;
        $caracteristique = $produit->caracteristique;
        $couleur = $caracteristique ? $caracteristique->couleur : 'Non spécifié';
        
        Log::info("Produit : " . $produit->nom . " - Couleur : " . $couleur);
    }

    // Retourner les détails en format JSON
    return response()->json([
        'nom' => $commande->user->name ?? 'Inconnu',
        'email' => $commande->user->email ?? 'Inconnu',
        'adresse' => $commande->user->adresse ?? 'Inconnue',
        'ville' => $commande->user->ville ?? 'Inconnue',
        'code_postal' => $commande->user->code_postal ?? 'Inconnu',
        'mode_paiement' => $commande->mode_paiement ?? 'Non spécifié',
        'details' => $commande->details->map(function ($detail) {
            $produit = $detail->produit;
            $caracteristique = $produit->caracteristique;
            $couleur = $caracteristique ? $caracteristique->couleur : 'Non spécifié';
            
            return [
                'produit' => [
                    'nom' => $produit->nom ?? 'Produit inconnu',
                    'caracteristique' => [
                        'couleur' => $couleur
                    ]
                ],
                'quantite' => $detail->quantite,
                'prix_unitaire' => $detail->prix_unitaire,
            ];
        }),
    ]);
}







}