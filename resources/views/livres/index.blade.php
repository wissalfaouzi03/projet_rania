@extends('layouts.app')

@section('title', 'Liste des Livres')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1><i class="bi bi-book"></i> Catalogue des Livres</h1>
    </div>
    @auth
        @if(auth()->user()->isAdmin())
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.livres.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajouter un livre
                </a>
            </div>
        @endif
    @endauth
</div>

<!-- Formulaire de recherche et filtrage -->
<form method="GET" action="{{ route('livres.index') }}" class="mb-4">
    <div class="row g-3">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par titre ou auteur..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="categorie" class="form-select">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <div class="d-grid gap-2 d-md-flex">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-search"></i> Rechercher
                </button>
                @if(request('search') || request('categorie'))
                    <a href="{{ route('livres.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </a>
                @endif
            </div>
        </div>
    </div>
</form>

<!-- Liste des livres -->
@if($livres->count() > 0)
    <div class="row">
        @foreach($livres as $livre)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $livre->titre }}</h5>
                        <p class="card-text">
                            <strong>Auteur:</strong> {{ $livre->auteur }}<br>
                            <strong>Catégorie:</strong> {{ $livre->categorie->nom }}<br>
                            <strong>Date de publication:</strong> {{ $livre->date_publication->format('d/m/Y') }}
                        </p>
                        @if($livre->description)
                            <p class="card-text text-muted">{{ Str::limit($livre->description, 100) }}</p>
                        @endif
                        <div class="mt-2">
                            @if(isset($livre->isReservedByCurrentUser) && $livre->isReservedByCurrentUser)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-bookmark-check"></i> Réservé par vous
                                </span>
                            @elseif($livre->disponible)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Disponible
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle"></i> Indisponible
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('livres.show', $livre) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Voir détails
                        </a>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.livres.edit', $livre) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <form action="{{ route('admin.livres.destroy', $livre) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $livres->links() }}
    </div>
@else
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Aucun livre trouvé.
    </div>
@endif
@endsection

