@extends('layouts.app')

@section('title', 'Détails Réservation')

@section('content')
<h1><i class="bi bi-calendar-check"></i> Détails de la Réservation</h1>
<hr>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informations de la réservation</h5>
                <p><strong>Livre:</strong> {{ $reservation->livre->titre }}</p>
                <p><strong>Auteur:</strong> {{ $reservation->livre->auteur }}</p>
                <p><strong>Utilisateur:</strong> {{ $reservation->user->name }}</p>
                <p><strong>Date de début:</strong> {{ $reservation->date_debut->format('d/m/Y') }}</p>
                <p><strong>Date de fin:</strong> {{ $reservation->date_fin->format('d/m/Y') }}</p>
                <p><strong>État:</strong> 
                    <span class="badge bg-{{ $reservation->etat === 'validee' ? 'success' : ($reservation->etat === 'en_attente' ? 'warning' : 'danger') }}">
                        {{ ucfirst(str_replace('_', ' ', $reservation->etat)) }}
                    </span>
                </p>
                <p><strong>Date de création:</strong> {{ $reservation->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Actions</h5>
                @auth
                    @if(auth()->user()->isAdmin())
                        @if($reservation->etat === 'en_attente')
                            <form action="{{ route('reservations.valider', $reservation) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-circle"></i> Valider la réservation
                                </button>
                            </form>
                            <form action="{{ route('reservations.annuler', $reservation) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Annuler cette réservation?')">
                                    <i class="bi bi-x-circle"></i> Annuler la réservation
                                </button>
                            </form>
                        @elseif($reservation->etat === 'validee')
                            <form action="{{ route('reservations.annuler', $reservation) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Annuler cette réservation validée? Le livre redeviendra disponible.')">
                                    <i class="bi bi-x-circle"></i> Annuler la réservation
                                </button>
                            </form>
                        @endif
                    @else
                        @if($reservation->etat === 'en_attente')
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="mb-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Annuler votre réservation?')">
                                    <i class="bi bi-x-circle"></i> Annuler ma réservation
                                </button>
                            </form>
                        @endif
                    @endif
                @endauth
                <a href="{{ route('reservations.index') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

