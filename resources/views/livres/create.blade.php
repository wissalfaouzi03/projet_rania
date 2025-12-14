@extends('layouts.app')

@section('title', 'Ajouter un Livre')

@section('content')
<h1><i class="bi bi-plus-circle"></i> Ajouter un Livre</h1>
<hr>

<form method="POST" action="{{ route('admin.livres.store') }}">
    @csrf
    <div class="mb-3">
        <label for="titre" class="form-label">Titre *</label>
        <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
        @error('titre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="auteur" class="form-label">Auteur *</label>
        <input type="text" class="form-control @error('auteur') is-invalid @enderror" id="auteur" name="auteur" value="{{ old('auteur') }}" required>
        @error('auteur')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="date_publication" class="form-label">Date de publication *</label>
        <input type="date" class="form-control @error('date_publication') is-invalid @enderror" id="date_publication" name="date_publication" value="{{ old('date_publication') }}" required>
        @error('date_publication')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="categorie_livre_id" class="form-label">Catégorie *</label>
        <select class="form-select @error('categorie_livre_id') is-invalid @enderror" id="categorie_livre_id" name="categorie_livre_id" required>
            <option value="">Sélectionner une catégorie</option>
            @foreach($categories as $categorie)
                <option value="{{ $categorie->id }}" {{ old('categorie_livre_id') == $categorie->id ? 'selected' : '' }}>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        @error('categorie_livre_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="disponible" name="disponible" value="1" {{ old('disponible', true) ? 'checked' : '' }}>
        <label class="form-check-label" for="disponible">Disponible</label>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
    <a href="{{ route('livres.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection

