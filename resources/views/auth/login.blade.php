@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <h4 class="mb-4 text-center">Connexion</h4>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               required 
               autofocus 
               autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               id="password" 
               name="password" 
               required 
               autocomplete="current-password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">
            Se souvenir de moi
        </label>
    </div>

    <!-- Forgot Password -->
    @if (Route::has('password.request'))
        <div class="mb-3 text-end">
            <a href="{{ route('password.request') }}" class="text-decoration-none">
                Mot de passe oublié ?
            </a>
        </div>
    @endif

    <!-- Submit Button -->
    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-box-arrow-in-right"></i> Se connecter
        </button>
    </div>

    <!-- Register Link -->
    <div class="text-center">
        <p class="mb-0">Pas encore de compte ? 
            <a href="{{ route('register') }}" class="text-decoration-none">S'inscrire</a>
        </p>
    </div>
</form>
@endsection
