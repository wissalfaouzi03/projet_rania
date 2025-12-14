@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <h4 class="mb-4 text-center" style="color: #2c3e50; font-weight: 700;">Inscription</h4>

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label" style="color: #2c3e50; font-weight: 600;">
            <i class="bi bi-person text-primary"></i> Nom
        </label>
        <input type="text" 
               class="form-control form-control-custom @error('name') is-invalid @enderror" 
               id="name" 
               name="name" 
               value="{{ old('name') }}" 
               required 
               autofocus 
               autocomplete="name"
               placeholder="Votre nom">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label" style="color: #2c3e50; font-weight: 600;">
            <i class="bi bi-envelope text-primary"></i> Email
        </label>
        <input type="email" 
               class="form-control form-control-custom @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               required 
               autocomplete="username"
               placeholder="votre@email.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label" style="color: #2c3e50; font-weight: 600;">
            <i class="bi bi-lock text-primary"></i> Mot de passe
        </label>
        <input type="password" 
               class="form-control form-control-custom @error('password') is-invalid @enderror" 
               id="password" 
               name="password" 
               required 
               autocomplete="new-password"
               placeholder="••••••••">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label" style="color: #2c3e50; font-weight: 600;">
            <i class="bi bi-lock-fill text-primary"></i> Confirmer le mot de passe
        </label>
        <input type="password" 
               class="form-control form-control-custom" 
               id="password_confirmation" 
               name="password_confirmation" 
               required 
               autocomplete="new-password"
               placeholder="••••••••">
    </div>

    <!-- Submit Button -->
    <div class="d-grid mb-4">
        <button type="submit" class="btn btn-custom-primary">
            <i class="bi bi-person-plus"></i> S'inscrire
        </button>
    </div>

    <!-- Login Link -->
    <div class="text-center">
        <p class="mb-0" style="color: #2c3e50;">Déjà un compte ? 
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #3498db; font-weight: 600;">Se connecter</a>
        </p>
    </div>
</form>
@endsection
