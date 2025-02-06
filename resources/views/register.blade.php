@extends('layout')
@section('title', 'Registration')
@section('content')


<div class="container" id="signup-container"> 
    <h1>Inscription</h1>

    <!-- Display Success or Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('Error'))
        <div class="alert alert-danger">{{ session('Error') }}</div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">

        @csrf 

        <!-- Fullname -->
        <label for="fullname">Nom complet</label>
        <input 
            type="text" 
            id="fullname" 
            name="fullname" 
            placeholder="Entrez votre nom complet" 
            required 
            value="{{ old('fullname') }}">
        @error('fullname')
            <span class="error">{{ $message }}</span>
        @enderror

        <!-- Email -->
        <label for="email">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="Entrez votre email" 
            required 
            value="{{ old('email') }}">
        @error('email')
            <span class="error">{{ $message }}</span>
        @enderror

        <!-- Password -->
        <label for="password">Mot de passe</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Créez un mot de passe" 
            required>
        @error('password')
            <span class="error">{{ $message }}</span>
        @enderror

        <!-- Confirm Password -->
        <label for="confirm-password">Confirmez le mot de passe</label>
        <input 
            type="password" 
            id="confirm-password" 
            name="password_confirmation" 
            placeholder="Confirmez votre mot de passe" 
            required>
        @error('password_confirmation')
            <span class="error">{{ $message }}</span>
        @enderror

        <!-- Submit Button -->
        <button type="submit">S'inscrire</button>

        <!-- Login Link -->
        <div class="link">
            <a href="{{ route('login') }}">J'ai déjà un compte</a>
        </div>
    </form>
</div>

@endsection
