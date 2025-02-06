@extends('layouts.app')

@section('content')


<div class="container" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0f172a, #1e293b); color: #ffffff;">
    <div class="row justify-content-center" style="width: 100%; margin: 0;">
        <div class="col-md-6">
            <!-- Card -->
            <div class="card" style="background: #1e293b; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);">
                <div class="card-header text-center" style="background: #111827; padding: 20px;">
                    <h2 style="font-family: 'Roboto', sans-serif; font-weight: bold; color: #38bdf8;">Connexion</h2>
                    <p style="font-size: 14px; color: #94a3b8;">Accédez à votre compte et explorez nos produits technologiques</p>
                </div>

                <div class="card-body" style="padding: 30px; animation: fadeIn 1s ease;">
                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="form-label" style="color: #94a3b8;">Adresse email</label>
                            <div style="position: relative;">
                                <input 
                                    id="email" 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus 
                                    style="background: #334155; border: none; padding: 12px 15px; color: #fff; border-radius: 8px; width: 100%; transition: box-shadow 0.3s;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-4">
                            <label for="password" class="form-label" style="color: #94a3b8;">Mot de passe</label>
                            <div style="position: relative;">
                                <input 
                                    id="password" 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" 
                                    required 
                                    style="background: #334155; border: none; padding: 12px 15px; color: #fff; border-radius: 8px; width: 100%; transition: box-shadow 0.3s;">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="remember" 
                                    id="remember" 
                                    {{ old('remember') ? 'checked' : '' }} 
                                    style="background: #334155; border-color: #38bdf8;">
                                <label class="form-check-label" for="remember" style="color: #94a3b8;">
                                    Se souvenir de moi
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-4 text-center">
                            <button 
                                type="submit" 
                                class="btn btn-primary" 
                                style="width: 100%; padding: 12px; background: #38bdf8; border: none; border-radius: 8px; font-weight: bold; color: #fff; transition: background 0.3s; cursor: pointer;"
                                onmouseover="this.style.background='#0284c7'" 
                                onmouseout="this.style.background='#38bdf8'">
                                Connexion
                            </button>
                        </div>

                        <!-- Forgot Password and Register Links -->
                        <div class="text-center">
                            <p style="color: #94a3b8;">Mot de passe oublié ? 
                                <a href="{{ route('password.request') }}" style="color: #38bdf8; text-decoration: none;">Réinitialiser</a>
                            </p>
                            <p style="color: #94a3b8;">Vous n'avez pas de compte ? 
                                <a href="{{ route('register') }}" style="color: #38bdf8; text-decoration: none;">Créer un compte</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>


@endsection
