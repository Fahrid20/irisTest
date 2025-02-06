<?php
namespace App\Http\Controllers;

use App\Models\Caracteristique;

use App\Models\Produit; // Import du modèle Produit
use App\Models\User;
use App\Models\Commande;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Mail\SendEmailToClient;

class AdminController extends Controller
{

    public function dashboard() {
        $clients = User::where('role', 'client')->get();
        $produits = Produit::all();
        $commandes = Commande::with('user')->get();
        $admins = User::where('role', 'admin')->get();

        return view('dashboard', compact('clients', 'produits', 'commandes', 'admins'));
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
    



}