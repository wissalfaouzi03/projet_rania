@extends('layouts.app')

@section('title', 'Détails du Livre')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>{{ $livre->titre }}</h1>
        <hr>
        <p><strong>Auteur:</strong> {{ $livre->auteur }}</p>
        <p><strong>Catégorie:</strong> {{ $livre->categorie->nom }}</p>
        <p><strong>Date de publication:</strong> {{ $livre->date_publication->format('d/m/Y') }}</p>
        @if($livre->description)
            <div class="mt-3">
                <h5>Description</h5>
                <p>{{ $livre->description }}</p>
            </div>
        @endif
        <div class="mt-3">
            @if(isset($livre->isReservedByCurrentUser) && $livre->isReservedByCurrentUser)
                <span class="badge bg-warning text-dark fs-6">
                    <i class="bi bi-bookmark-check"></i> Réservé par vous
                </span>
                @php
                    $userReservation = auth()->user()->reservations()
                        ->where('livre_id', $livre->id)
                        ->whereIn('etat', ['en_attente', 'validee'])
                        ->first();
                @endphp
                @if($userReservation)
                    <div class="mt-2">
                        <small class="text-muted">
                            <strong>État:</strong> 
                            @if($userReservation->etat === 'en_attente')
                                <span class="badge bg-info">En attente de validation</span>
                            @elseif($userReservation->etat === 'validee')
                                <span class="badge bg-success">Validée</span>
                            @endif
                            <br>
                            <strong>Période:</strong> 
                            {{ $userReservation->date_debut->format('d/m/Y') }} - {{ $userReservation->date_fin->format('d/m/Y') }}
                        </small>
                    </div>
                @endif
            @elseif($livre->disponible)
                <span class="badge bg-success fs-6">
                    <i class="bi bi-check-circle"></i> Disponible
                </span>
            @else
                <span class="badge bg-danger fs-6">
                    <i class="bi bi-x-circle"></i> Indisponible
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Actions</h5>
                <a href="{{ route('livres.index') }}" class="btn btn-secondary w-100 mb-2">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                @auth
                    @if(auth()->user()->isUser())
                        @if(isset($livre->isReservedByCurrentUser) && $livre->isReservedByCurrentUser)
                            <div class="alert alert-info mb-2">
                                <i class="bi bi-info-circle"></i> Vous avez déjà réservé ce livre.
                            </div>
                            <a href="{{ route('reservations.index') }}" class="btn btn-info w-100">
                                <i class="bi bi-calendar-check"></i> Voir ma réservation
                            </a>
                        @elseif($livre->disponible)
                            @php
                                $hasActiveReservation = auth()->user()->reservations()
                                    ->whereIn('etat', ['en_attente', 'validee'])
                                    ->exists();
                            @endphp
                            @if($hasActiveReservation)
                                @php
                                    $activeReservation = auth()->user()->reservations()
                                        ->whereIn('etat', ['en_attente', 'validee'])
                                        ->with('livre')
                                        ->first();
                                @endphp
                                <div class="alert alert-warning mb-2">
                                    <i class="bi bi-exclamation-triangle"></i> 
                                    <strong>Réservation active en cours</strong><br>
                                    <small>
                                        Vous avez déjà une réservation du 
                                        <strong>{{ $activeReservation->date_debut->format('d/m/Y') }}</strong> 
                                        au <strong>{{ $activeReservation->date_fin->format('d/m/Y') }}</strong> 
                                        pour le livre "<strong>{{ $activeReservation->livre->titre }}</strong>".<br>
                                        Veuillez attendre la fin de cette période ou annuler votre réservation actuelle.
                                    </small>
                                </div>
                                <a href="{{ route('reservations.index') }}" class="btn btn-warning w-100">
                                    <i class="bi bi-calendar-check"></i> Voir ma réservation
                                </a>
                            @else
                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#reservationModal">
                                    <i class="bi bi-calendar-check"></i> Réserver ce livre
                                </button>
                            @endif
                        @else
                            <div class="alert alert-warning mb-2">
                                <i class="bi bi-exclamation-triangle"></i> Ce livre n'est pas disponible.
                            </div>
                        @endif
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.livres.edit', $livre) }}" class="btn btn-warning w-100 mb-2">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <form action="{{ route('admin.livres.destroy', $livre) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Êtes-vous sûr?')">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Modal de réservation -->
@auth
    @if(auth()->user()->isUser() && $livre->disponible && (!isset($livre->isReservedByCurrentUser) || !$livre->isReservedByCurrentUser))
        @php
            $hasActiveReservation = auth()->user()->reservations()
                ->whereIn('etat', ['en_attente', 'validee'])
                ->exists();
        @endphp
        @if(!$hasActiveReservation)
        <div class="modal fade" id="reservationModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title">Réserver "{{ $livre->titre }}"</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-exclamation-triangle"></i> Erreur
                                    </h6>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de début</label>
                                <input type="date" 
                                       class="form-control @error('date_debut') is-invalid @enderror" 
                                       id="date_debut" 
                                       name="date_debut" 
                                       value="{{ old('date_debut') }}"
                                       required 
                                       min="{{ date('Y-m-d') }}">
                                @error('date_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date de fin</label>
                                <input type="date" 
                                       class="form-control @error('date_fin') is-invalid @enderror" 
                                       id="date_fin" 
                                       name="date_fin" 
                                       value="{{ old('date_fin') }}"
                                       required>
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('livre_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @error('message')
                                    <div class="alert alert-warning mt-2 mb-0">
                                        <i class="bi bi-info-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Réserver</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endif
@endauth
@endsection

