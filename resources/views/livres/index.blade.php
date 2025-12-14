@extends('layouts.app')

@section('title', 'Liste des Livres')

@section('content')
<!-- En-tête avec bouton en haut à droite -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 style="color: #2c3e50;"><i class="bi bi-book-half"></i> Catalogue des Livres</h1>
    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.livres.create') }}" class="btn btn-custom-primary">
                <i class="bi bi-plus-circle"></i> Ajouter un livre
            </a>
        @endif
    @endauth
</div>

<!-- Formulaire de recherche et filtrage -->
<div class="search-box">
    <form method="GET" action="{{ route('livres.index') }}">
        <div class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-custom" placeholder="🔍 Rechercher par titre ou auteur..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="categorie" class="form-select form-control-custom">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-custom-primary">
                        <i class="bi bi-search"></i> Rechercher
                    </button>
                    @if(request('search') || request('categorie'))
                        <a href="{{ route('livres.index') }}" class="btn btn-custom-secondary">
                            <i class="bi bi-x-circle"></i> Réinitialiser
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Liste des livres -->
@if($livres->count() > 0)
    <div class="row">
        @foreach($livres as $livre)
            <div class="col-md-4 mb-4">
                <div class="card card-custom h-100">
                    <div class="card-header-custom">
                        <h5 class="mb-0">{{ $livre->titre }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-2">
                            <i class="bi bi-person text-primary"></i> <strong>Auteur:</strong> {{ $livre->auteur }}
                        </p>
                        <p class="card-text mb-2">
                            <i class="bi bi-tag text-primary"></i> <strong>Catégorie:</strong> {{ $livre->categorie->nom }}
                        </p>
                        <p class="card-text mb-3">
                            <i class="bi bi-calendar text-primary"></i> <strong>Date:</strong> {{ $livre->date_publication->format('d/m/Y') }}
                        </p>
                        @if($livre->description)
                            <p class="card-text text-muted" style="font-size: 0.9rem;">{{ Str::limit($livre->description, 100) }}</p>
                        @endif
                        <div class="mt-3 mb-3">
                            @if(isset($livre->isReservedByCurrentUser) && $livre->isReservedByCurrentUser)
                                <span class="badge-custom-warning">
                                    <i class="bi bi-bookmark-check"></i> Réservé par vous
                                </span>
                            @elseif($livre->disponible)
                                <span class="badge-custom-success">
                                    <i class="bi bi-check-circle"></i> Disponible
                                </span>
                            @else
                                <span class="badge-custom-danger">
                                    <i class="bi bi-x-circle"></i> Indisponible
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-light" style="border: none; padding: 1rem;">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('livres.show', $livre) }}" class="btn btn-custom-primary btn-sm">
                                <i class="bi bi-eye"></i> Détails
                            </a>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.livres.edit', $livre) }}" class="btn btn-custom-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.livres.destroy', $livre) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-custom-danger btn-sm" onclick="return confirm('Êtes-vous sûr?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $livres->links() }}
    </div>
@else
    <div class="alert alert-info text-center" style="border-radius: 15px;">
        <i class="bi bi-info-circle"></i> Aucun livre trouvé.
    </div>
@endif
@endsection

