@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <h4 class="mb-4 text-center" style="color: #2c3e50; font-weight: 700;">Connexion</h4>

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
               autofocus 
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
               autocomplete="current-password"
               placeholder="••••••••">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember" style="color: #2c3e50;">
            Se souvenir de moi
        </label>
    </div>

    <!-- Forgot Password -->
    @if (Route::has('password.request'))
        <div class="mb-4 text-end">
            <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #3498db; font-weight: 500;">
                Mot de passe oublié ?
            </a>
        </div>
    @endif

    <!-- Submit Button - Centré et plus grand -->
    <div class="d-grid mb-4">
        <button type="submit" class="btn btn-custom-primary">
            <i class="bi bi-box-arrow-in-right"></i> Se connecter
        </button>
    </div>

    <!-- Register Link -->
    <div class="text-center">
        <p class="mb-0" style="color: #2c3e50;">Pas encore de compte ? 
            <a href="{{ route('register') }}" class="text-decoration-none" style="color: #3498db; font-weight: 600;">S'inscrire</a>
        </p>
    </div>
</form>
@endsection
