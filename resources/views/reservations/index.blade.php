@extends('layouts.app')

@section('title', auth()->user()->isAdmin() ? 'Gestion des Réservations' : 'Mes Réservations')

@section('content')
<h1><i class="bi bi-calendar-check"></i> {{ auth()->user()->isAdmin() ? 'Gestion des Réservations' : 'Mes Réservations' }}</h1>
<hr>

@if($reservations->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    @if(auth()->user()->isAdmin())
                        <th>Utilisateur</th>
                    @endif
                    <th>Livre</th>
                    <th>Auteur</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        @if(auth()->user()->isAdmin())
                            <td>{{ $reservation->user->name }}<br><small class="text-muted">{{ $reservation->user->email }}</small></td>
                        @endif
                        <td>{{ $reservation->livre->titre }}</td>
                        <td>{{ $reservation->livre->auteur }}</td>
                        <td>{{ $reservation->date_debut->format('d/m/Y') }}</td>
                        <td>{{ $reservation->date_fin->format('d/m/Y') }}</td>
                        <td>
                            @if($reservation->etat === 'en_attente')
                                <span class="badge bg-warning">En attente</span>
                            @elseif($reservation->etat === 'validee')
                                <span class="badge bg-success">Validée</span>
                            @else
                                <span class="badge bg-danger">Annulée</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-info" title="Voir détails">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin())
                                @if($reservation->etat === 'en_attente')
                                    <form action="{{ route('reservations.valider', $reservation) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Valider" onclick="return confirm('Valider cette réservation?')">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('reservations.annuler', $reservation) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="Annuler" onclick="return confirm('Annuler cette réservation?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                @elseif($reservation->etat === 'validee')
                                    <form action="{{ route('reservations.annuler', $reservation) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="Annuler" onclick="return confirm('Annuler cette réservation?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if($reservation->etat === 'en_attente')
                                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Annuler ma réservation" onclick="return confirm('Annuler cette réservation?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $reservations->links() }}
@else
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> {{ auth()->user()->isAdmin() ? 'Aucune réservation trouvée.' : 'Vous n\'avez aucune réservation.' }}
    </div>
@endif
@endsection

