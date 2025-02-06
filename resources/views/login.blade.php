@extends('layout')
@section('title', 'Login')
@section('content')

<main class="container" id="login-container">
    <h1>Connexion</h1>

    <!-- Display Errors -->
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if(session('Error'))
        <div class="alert alert-danger">{{ session('Error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Login Form -->
    <form action="{{ route('login.post') }}" method="POST">
        @csrf 

        <!-- Email Input -->
        <label for="email">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="Entrez votre email" 
            value="{{ old('email') }}" 
            required>

        <!-- Password Input -->
        <label for="password">Mot de passe</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Entrez votre mot de passe" 
            required>

        <!-- Submit Button -->
        <button type="submit">Se connecter</button>

        <!-- Links -->
        <div class="link">
            <a href="#">Mot de passe oublié ?</a> <!-- Placeholder -->
        </div>
        <div class="link">
            <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </form>
</main>

@endsection
