@extends('layouts.app')
@section('title', 'Produits')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
  <h2 data-aos="fade-right">Produits</h2>
  <a href="{{ route('articles.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm" data-aos="fade-left">
    <i class="bi bi-plus-lg me-2"></i>Ajouter produit
  </a>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert" data-aos="zoom-in">
  <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow-lg border-0 rounded-4" data-aos="fade-up">
  <div class="card-body p-0">
    <div class="table-responsive rounded-4">
      <table class="table table-hover mb-0">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Référence</th>
            <th>Catégorie</th>
            <th>Quantité</th>
            <th>Seuil min</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($articles ?? [] as $article)
          <tr class="table-row-hover">
            <td>{{ $loop->iteration }}</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center me-2">
                  <i class="bi bi-box text-muted"></i>
                </div>
                <div>
                  <strong>{{ $article->nom }}</strong>
                  <br><small class="text-muted">{{ $article->reference }}</small>
                </div>
              </div>
            </td>
            <td><code>{{ $article->reference }}</code></td>
            <td><span class="badge bg-light text-dark px-2 py-1">{{ $article->categorie->nom ?? 'N/A' }}</span></td>
            <td>
              <span class="fw-bold {{ $article->quantite <= $article->seuil_minimum ? 'text-danger' : 'text-success' }}">
                {{ $article->quantite }}
              </span>
              @if($article->quantite <= $article->seuil_minimum)
              <i class="bi bi-exclamation-triangle ms-1 text-warning"></i>
              @endif
            </td>
            <td><span class="text-muted">{{ $article->seuil_minimum }}</span></td>
            <td>
              <div class="btn-group" role="group">
                <a href="{{ route('articles.show', $article) }}" class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-outline-warning">
                  <i class="bi bi-pencil"></i>
                </a>
                <form method="POST" action="{{ route('articles.destroy', $article) }}" class="d-inline" data-confirm="Supprimer ce produit ?" data-loading="true">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger border-0">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <i class="bi bi-boxes display-1 text-muted mb-3"></i>
              <h5 class="text-muted">Aucun produit</h5>
              <a href="{{ route('articles.create') }}" class="btn btn-primary">Ajouter le premier</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@if($articles->hasPages())
<div class="d-flex justify-content-center mt-4">
  {{ $articles->links() }}
</div>
@endif
@endsection
