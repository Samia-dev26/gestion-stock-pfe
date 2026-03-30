@extends('layouts.app')
@section('title', 'Modifier produit')

@section('content')
<div class="page-content">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <p class="text-muted mb-1" data-aos="fade-right">Stock • Edition</p>
      <h2 class="fw-bold mb-0" data-aos="fade-right" data-aos-delay="40">{{ $article->nom ?? 'Produit' }}</h2>
    </div>
    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary rounded-pill px-4" data-aos="fade-left">
      <i class="bi bi-arrow-left me-2"></i>Retour
    </a>
  </div>

  <div class="card shadow-lg border-0 rounded-4" data-aos="fade-up">
    <div class="card-body">
      <form method="POST" action="{{ route('articles.update', $article) }}" data-loading="true">
        @csrf
        @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $article->nom ?? '') }}" required>
            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Référence</label>
            <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror" value="{{ old('reference', $article->reference ?? '') }}" required>
            @error('reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Catégorie</label>
            <select name="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror" required>
              <option value="">Choisir</option>
              @forelse($categories ?? [] as $cat)
              <option value="{{ $cat->id }}" {{ (old('categorie_id', $article->categorie_id ?? null) == $cat->id) ? 'selected' : '' }}>{{ $cat->nom }}</option>
              @empty
              <option disabled>Aucune catégorie</option>
              @endforelse
            </select>
            @error('categorie_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-3">
            <label class="form-label">Quantité</label>
            <input type="number" name="quantite" class="form-control @error('quantite') is-invalid @enderror" value="{{ old('quantite', $article->quantite ?? 0) }}" required>
            @error('quantite') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-3">
            <label class="form-label">Seuil minimum</label>
            <input type="number" name="seuil_minimum" class="form-control @error('seuil_minimum') is-invalid @enderror" value="{{ old('seuil_minimum', $article->seuil_minimum ?? 1) }}" required>
            @error('seuil_minimum') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="{{ route('articles.index') }}" class="btn btn-light rounded-pill">Annuler</a>
          <button class="btn btn-primary rounded-pill px-4" type="submit">
            <i class="bi bi-check-lg me-2"></i>Mettre à jour
          </button>
        </div>
      </form>
      <form method="POST" action="{{ route('articles.destroy', $article) }}" class="mt-3 text-end" data-confirm="Supprimer définitivement ?" data-loading="true">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger rounded-pill"><i class="bi bi-trash me-2"></i>Supprimer</button>
      </form>
    </div>
  </div>
</div>
@endsection
