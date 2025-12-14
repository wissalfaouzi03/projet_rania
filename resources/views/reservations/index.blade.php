@extends('layouts.app')

@section('title', auth()->user()->isAdmin() ? 'Gestion des Réservations' : 'Mes Réservations')

@section('content')
<h1 style="color: #2c3e50;"><i class="bi bi-calendar-check"></i> {{ auth()->user()->isAdmin() ? 'Gestion des Réservations' : 'Mes Réservations' }}</h1>
<hr style="border-color: #3498db;">

@if($reservations->count() > 0)
    <div class="row">
        @foreach($reservations as $reservation)
            <div class="col-md-6 mb-4">
                <div class="card card-custom h-100">
                    <div class="card-header-custom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $reservation->livre->titre }}</h5>
                            <span class="badge-custom-{{ $reservation->etat === 'validee' ? 'success' : ($reservation->etat === 'en_attente' ? 'warning' : 'danger') }}">
                                {{ ucfirst(str_replace('_', ' ', $reservation->etat)) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(auth()->user()->isAdmin())
                            <p class="mb-2">
                                <i class="bi bi-person text-primary"></i> <strong>Utilisateur:</strong> {{ $reservation->user->name }}<br>
                                <small class="text-muted">{{ $reservation->user->email }}</small>
                            </p>
                        @endif
                        <p class="mb-2">
                            <i class="bi bi-pencil text-primary"></i> <strong>Auteur:</strong> {{ $reservation->livre->auteur }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-calendar-event text-primary"></i> <strong>Début:</strong> {{ $reservation->date_debut->format('d/m/Y') }}
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-calendar-check text-primary"></i> <strong>Fin:</strong> {{ $reservation->date_fin->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="card-footer bg-light" style="border: none; padding: 1rem;">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-custom-primary btn-sm">
                                <i class="bi bi-eye"></i> Détails
                            </a>
                            @if(auth()->user()->isAdmin())
                                @if($reservation->etat === 'en_attente')
                                    <form action="{{ route('reservations.valider', $reservation) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-custom-success btn-sm" onclick="return confirm('Valider cette réservation?')">
                                            <i class="bi bi-check-circle"></i> Valider
                                        </button>
                                    </form>
                                    <form action="{{ route('reservations.annuler', $reservation) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-custom-danger btn-sm" onclick="return confirm('Annuler cette réservation?')">
                                            <i class="bi bi-x-circle"></i> Annuler
                                        </button>
                                    </form>
                                @elseif($reservation->etat === 'validee')
                                    <form action="{{ route('reservations.annuler', $reservation) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-custom-danger btn-sm" onclick="return confirm('Annuler cette réservation?')">
                                            <i class="bi bi-x-circle"></i> Annuler
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if($reservation->etat === 'en_attente')
                                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-custom-danger btn-sm" onclick="return confirm('Annuler cette réservation?')">
                                            <i class="bi bi-x-circle"></i> Annuler
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $reservations->links() }}
    </div>
@else
    <div class="alert alert-info text-center" style="border-radius: 15px;">
        <i class="bi bi-info-circle"></i> {{ auth()->user()->isAdmin() ? 'Aucune réservation trouvée.' : 'Vous n\'avez aucune réservation.' }}
    </div>
@endif
@endsection

