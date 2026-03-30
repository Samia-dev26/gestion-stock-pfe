@extends('layouts.sneat-layout')
@section('title', 'Agent Dashboard - StockPro')

@push('styles')
<style>
  .agent-stats { background: linear-gradient(135deg, #059669, #047857); }
  .agent-card-personal { border-left: 4px solid #10b981; }
  .agent-product-grid { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); }
  .decharge-badge { font-size: 0.75rem; padding: 0.4em 0.8em; }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="page-header d-print-none">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h3 class="page-title mb-1">
        <i class="bx bx-user-check me-2 text-success"></i>
        Dashboard Agent
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
          <li class="breadcrumb-item active" aria-current="page">Agent</li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
<a href="/decharges/create" class="btn btn-success">
        <i class="bx bx-plus-circle"></i> Nouvelle décharge
      </a>
    </div>
  </div>
</div>

<!-- Personal Stats -->
<div class="row mb-4">
  <div class="col-md-4">
    <div class="card agent-stats">
      <div class="card-body text-center text-white">
        <h2 class="mb-1">{{ $totalProducts ?? 0 }}</h2>
        <p class="mb-0 opacity-75">Produits disponibles</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card agent-card-personal">
      <div class="card-body">
        <h4 class="mb-1">{{ count($myDecharges ?? []) }}</h4>
        <small class="text-success fw-semibold">Mes décharges validées</small>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h4 class="mb-1 text-warning">{{ $lowStockCount ?? 0 }}</h4>
        <small class="text-muted">À surveiller</small>
      </div>
    </div>
  </div>
</div>

<!-- Product search & grid -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <i class="bx bx-search-alt-2 me-2"></i>Rechercher produits
    </h5>
  </div>
  <div class="card-body">
    <div class="input-group mb-4">
      <span class="input-group-text"><i class="bx bx-search"></i></span>
      <input type="text" class="form-control" id="productSearch" placeholder="Nom ou référence du produit...">
      <button class="btn btn-outline-secondary" type="button" id="clearSearch">Effacer</button>
    </div>
    <div class="agent-product-grid" id="productGrid">
      @forelse($criticalProducts ?? [] as $product)
      <div class="card border-0 shadow-sm h-100 product-card" data-name="{{ strtolower($product->designation) }}">
        <div class="card-body d-flex flex-column">
          <h6 class="card-title mb-2">{{ $product->designation }}</h6>
          <small class="text-muted mb-3">{{ $product->category->nom ?? 'Sans catégorie' }}</small>
          <div class="d-flex justify-content-between align-items-end flex-grow-1">
            <div>
              <div class="fw-bold fs-4 text-success">{{ $product->quantity }}</div>
              <small class="text-muted">Stock actuel</small>
            </div>
            <div class="text-end">
              <small class="text-muted">Min:</small><br>
              <span class="fw-bold">{{ $product->seuil_minimum }}</span>
            </div>
          </div>
        </div>
      </div>
      @empty
      <!-- Fallback demo cards -->
      <div class="card border-0 shadow-sm h-100 product-card" data-name="ordinateur">
        <div class="card-body d-flex flex-column">
          <h6 class="card-title mb-2">Ordinateur Dell</h6>
          <small class="text-muted mb-3">Informatique</small>
          <div class="d-flex justify-content-between align-items-end flex-grow-1">
            <div>
              <div class="fw-bold fs-4 text-success">15</div>
              <small class="text-muted">Stock actuel</small>
            </div>
            <div class="text-end">
              <small class="text-muted">Min:</small><br>
              <span class="fw-bold">5</span>
            </div>
          </div>
        </div>
      </div>
      @endforelse
    </div>
  </div>
</div>

<!-- Mes décharges -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h5 class="card-title mb-0">Mes décharges récentes</h5>
        <a href="#" class="btn btn-sm btn-outline-success">Voir toutes mes décharges</a>
      </div>
      <div class="card-body">
        @forelse($myDecharges ?? [] as $decharge)
        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
          <div class="flex-grow-1 me-3">
            <h6 class="mb-1">{{ $decharge->reference ?? 'DCH-' . $loop->index }}</h6>
            <small class="text-muted">{{ $decharge->created_at->format('d/m/Y H:i') }}</small>
          </div>
          <div class="text-end">
            <span class="decharge-badge bg-success">Validée</span>
            <a href="#" class="btn btn-sm btn-icon ms-2">
              <i class="bx bx-download"></i>
            </a>
          </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
          <i class="bx bx-box bx-lg mb-3 opacity-50"></i>
          <p>Aucune décharge récente</p>
          <a href="/decharges/create" class="btn btn-success">Créer ma première décharge</a>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Product search filter
  document.getElementById('productSearch').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    document.querySelectorAll('.product-card').forEach(card => {
      const name = card.dataset.name;
      card.style.display = name.includes(query) ? 'block' : 'none';
    });
  });

  document.getElementById('clearSearch')?.addEventListener('click', function() {
    document.getElementById('productSearch').value = '';
    document.querySelectorAll('.product-card').forEach(card => {
      card.style.display = 'block';
    });
  });
</script>
@endpush

