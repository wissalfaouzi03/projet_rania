@extends('layouts.app')

@section('title', 'Détails Utilisateur')

@section('content')
<h1><i class="bi bi-person"></i> Détails de l'Utilisateur</h1>
<hr>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text">
                    <strong>Email:</strong> {{ $user->email }}<br>
                    <strong>Rôle:</strong> 
                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                        {{ ucfirst($user->role) }}
                    </span><br>
                    <strong>Date d'inscription:</strong> {{ $user->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        <h3 class="mt-4">Réservations</h3>
        @if($user->reservations->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Livre</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->livre->titre }}</td>
                                <td>{{ $reservation->date_debut->format('d/m/Y') }}</td>
                                <td>{{ $reservation->date_fin->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $reservation->etat === 'validee' ? 'success' : ($reservation->etat === 'en_attente' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($reservation->etat) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Aucune réservation</p>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Actions</h5>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning w-100 mb-2">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Supprimer cet utilisateur?')">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100 mt-2">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

