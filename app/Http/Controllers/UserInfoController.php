<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    // Afficher le profil de l'utilisateur connecté
    /*public function show()
    {
        $user = auth()->user();
        $profile = $user->profile; // Accéder au profil associé
        return view('profile', compact('user', 'profile'));
    }*/

    /*public function show()
    {
        $user = auth()->user(); // Utilisateur connecté
        $userInfo = $user->userInfo; // Accède à la relation

        return view('profile', compact('user', 'userInfo'));
    }*/

    public function show()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Vérifier si un profil existe ou en créer un vide
        $userInfo = $user->userInfo ?: $user->userInfo()->create([
            'phone' => null,
            'address' => null,
            'birthdate' => null,
            'country' => null,
            'city' => null,
            'zip_code' => null,
        ]);

        // Passer les données à la vue
        return view('profile', compact('user', 'userInfo'));
    }


    // Mettre à jour les informations du profil utilisateur
    public function updatePersonalInfo(Request $request)
    {
        $user = auth()->user();

        // Valider les informations envoyées
        $request->validate([
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
        ]);

        // Mettre à jour les informations dans la table profiles
        $user->userInfo->update($request->only([
            'phone', 'address', 'birthdate', 'country', 'city', 'zip_code'
        ]));

        return back()->with('success', 'Informations mises à jour.');
    }
}