@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h1 style="color: #2c3e50;"><i class="bi bi-speedometer2"></i> Dashboard Administrateur</h1>
<hr style="border-color: #3498db;">

<!-- Stats Cards - Nouveau design avec gradients -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card card-custom text-white" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); border: none;">
            <div class="card-body text-center">
                <i class="bi bi-book" style="font-size: 2.5rem; opacity: 0.9;"></i>
                <h2 class="mt-2 mb-1">{{ $stats['total_livres'] }}</h2>
                <h6 class="mb-0">Livres</h6>
                <small style="opacity: 0.9;">{{ $stats['livres_disponibles'] }} disponibles</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card card-custom text-white" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); border: none;">
            <div class="card-body text-center">
                <i class="bi bi-people" style="font-size: 2.5rem; opacity: 0.9;"></i>
                <h2 class="mt-2 mb-1">{{ $stats['total_utilisateurs'] }}</h2>
                <h6 class="mb-0">Utilisateurs</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card card-custom text-white" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); border: none;">
            <div class="card-body text-center">
                <i class="bi bi-calendar-check" style="font-size: 2.5rem; opacity: 0.9;"></i>
                <h2 class="mt-2 mb-1">{{ $stats['total_reservations'] }}</h2>
                <h6 class="mb-0">Réservations</h6>
                <small style="opacity: 0.9;">{{ $stats['reservations_en_attente'] }} en attente</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card card-custom text-white" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); border: none;">
            <div class="card-body text-center">
                <i class="bi bi-check-circle" style="font-size: 2.5rem; opacity: 0.9;"></i>
                <h2 class="mt-2 mb-1">{{ $stats['reservations_validees'] }}</h2>
                <h6 class="mb-0">Validées</h6>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Actions rapides - Boutons en colonne -->
    <div class="col-md-6 mb-4">
        <div class="card card-custom">
            <div class="card-header-custom">
                <h5 class="mb-0"><i class="bi bi-lightning"></i> Actions rapides</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.livres.create') }}" class="btn btn-custom-primary mb-3 w-100">
                    <i class="bi bi-plus-circle"></i> Ajouter un livre
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-custom-success mb-3 w-100">
                    <i class="bi bi-people"></i> Gérer les utilisateurs
                </a>
                <a href="{{ route('reservations.index') }}" class="btn btn-custom-warning w-100">
                    <i class="bi bi-calendar-check"></i> Gérer les réservations
                </a>
            </div>
        </div>
    </div>
    
    <!-- Réservations récentes -->
    <div class="col-md-6 mb-4">
        <div class="card card-custom">
            <div class="card-header-custom">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Réservations récentes</h5>
            </div>
            <div class="card-body">
                @if($recent_reservations->count() > 0)
                    <div class="list-group">
                        @foreach($recent_reservations as $reservation)
                            <div class="list-group-item mb-2" style="border-radius: 10px; border: 1px solid #e0e0e0;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong style="color: #2c3e50;">{{ $reservation->livre->titre }}</strong><br>
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> {{ $reservation->user->name }} 
                                            <i class="bi bi-calendar ms-2"></i> {{ $reservation->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <span class="badge-custom-{{ $reservation->etat === 'validee' ? 'success' : ($reservation->etat === 'en_attente' ? 'warning' : 'danger') }}">
                                        {{ ucfirst(str_replace('_', ' ', $reservation->etat)) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-3">Aucune réservation récente</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

