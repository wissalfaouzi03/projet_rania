@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h1><i class="bi bi-speedometer2"></i> Dashboard Administrateur</h1>
<hr>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Livres</h5>
                <h2>{{ $stats['total_livres'] }}</h2>
                <p class="card-text">{{ $stats['livres_disponibles'] }} disponibles</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Utilisateurs</h5>
                <h2>{{ $stats['total_utilisateurs'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Réservations</h5>
                <h2>{{ $stats['total_reservations'] }}</h2>
                <p class="card-text">{{ $stats['reservations_en_attente'] }} en attente</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Validées</h5>
                <h2>{{ $stats['reservations_validees'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Actions rapides</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.livres.create') }}" class="btn btn-primary mb-2 w-100">
                    <i class="bi bi-plus-circle"></i> Ajouter un livre
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-success mb-2 w-100">
                    <i class="bi bi-people"></i> Gérer les utilisateurs
                </a>
                <a href="{{ route('reservations.index') }}" class="btn btn-warning mb-2 w-100">
                    <i class="bi bi-calendar-check"></i> Gérer les réservations
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Réservations récentes</h5>
            </div>
            <div class="card-body">
                @if($recent_reservations->count() > 0)
                    <ul class="list-group">
                        @foreach($recent_reservations as $reservation)
                            <li class="list-group-item">
                                <strong>{{ $reservation->livre->titre }}</strong><br>
                                <small>Par {{ $reservation->user->name }} - {{ $reservation->created_at->format('d/m/Y') }}</small>
                                <span class="badge bg-{{ $reservation->etat === 'validee' ? 'success' : ($reservation->etat === 'en_attente' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($reservation->etat) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Aucune réservation récente</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

