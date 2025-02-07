<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
        }

        return redirect(route('login'))->withErrors(['email' => 'Invalid email or password.']);
    }

    public function registerPost(Request $request)
    {
        $request->validate([ 
            'fullname' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:8', 
            'regex:/[a-z]/', // Au moins une minuscule 
            'regex:/[A-Z]/', // Au moins une majuscule 
            'regex:/[0-9]/', // Au moins un chiffre 
            'regex:/[@$!%*?&]/', // Au moins un caractère spécial 
            'confirmed', // Le mot de passe doit correspondre à la confirmation 
        ]);
        $user = User::create([
            'name' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            return redirect(route('register'))->withErrors(['error' => 'Registration failed, please try again.']);
        }

        
        return redirect(route('login'))->with('success', 'Registration successful!');
    }

   /* public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect(route('login'))->with('success', 'Logged out successfully.');
    }*/
   
 
    public function logout(Request $request) 
    { 
        Auth::logout();  // Déconnecter l'utilisateur 
        $request->session()->invalidate();  // Invalider la session 
        $request->session()->regenerateToken();  // Régénérer le token CSRF pour la sécurité 
        return redirect(route('login'))->with('success', 'Logged out successfully.');  // Rediriger vers la page d'accueil ou autre 
    }
}
