@extends('layouts.sneat-layout')
@section('title', 'Gestionnaire Dashboard - StockPro')

@push('styles')
<style>
  .sneat-gestionnaire-card { border-left: 4px solid #10b981; }
  .stock-table tbody tr:hover { background-color: rgba(16, 185, 129, 0.05); }
  .progress-gestionnaire { height: 8px; border-radius: 4px; }
</style>
@endpush

@section('content')
<!-- Page header -->
<div class="page-header">
  <h3 class="page-title mb-1">
    <i class="bx bx-line-chart me-2"></i>
    Tableau de bord Gestionnaire
  </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
      <li class="breadcrumb-item active">Gestionnaire</li>
    </ol>
  </nav>
</div>

<!-- Stats -->
<div class="row mb-4">
  <div class="col-lg-3 col-md-6">
    <div class="card sneat-stat-card sneat-gestionnaire-card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar bg-success rounded me-3">
            <i class="bx bx-package fs-4 text-white"></i>
          </div>
          <div class="flex-grow-1">
            <h4 class="mb-1">{{ $totalProducts ?? 0 }}</h4>
            <small class="text-success fw-semibold">Produits en stock</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-6">
    <div class="card sneat-stat-card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar bg-warning rounded me-3">
            <i class="bx bx-error-alt fs-4 text-white"></i>
          </div>
          <div>
            <h4 class="mb-1 text-warning">{{ $lowStockCount ?? 0 }}</h4>
            <small class="text-muted">À réapprovisionner</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6">
    <div class="card sneat-stat-card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar bg-primary rounded me-3">
            <i class="bx bx-git-merge fs-4 text-white"></i>
          </div>
          <div>
            <h4 class="mb-1">{{ $mouvementsToday ?? 0 }}</h4>
            <small class="text-muted">Mouvements jour</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6">
    <div class="card sneat-stat-card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar bg-info rounded me-3">
            <i class="bx bx-file me-2 fs-4 text-white"></i>
          </div>
          <div>
            <h4 class="mb-1">{{ $totalDecharges ?? 0 }}</h4>
            <small class="text-muted">Décharges total</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Stock overview -->
<div class="row">
  <div class="col-xl-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h5 class="card-title mb-0">Inventaire - Vue rapide</h5>
<a href="/products" class="btn btn-sm btn-primary">Gérer stocks</a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th>Produit</th>
              <th>Catégorie</th>
              <th>Stock actuel</th>
              <th>Stock min</th>
              <th>État</th>
            </tr>
          </thead>
          <tbody>
            @forelse($criticalProducts ?? [] as $product)
            <tr>
              <td>{{ $product->designation }}</td>
              <td>{{ $product->category->nom ?? 'N/A' }}</td>
              <td><span class="fw-bold text-danger">{{ $product->quantity }}</span></td>
              <td>{{ $product->seuil_minimum }}</td>
              <td>
                <span class="badge bg-danger">
                  Critique ({{ round(($product->quantity / $product->seuil_minimum) * 100, 0) }}%)
                </span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">
                Aucun produit critique pour le moment
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-xl-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Mouvements récents</h5>
      </div>
      <div class="card-body">
        <ul class="list-unstyled mb-0">
          @forelse($recentMovements ?? [] as $mouvement)
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span>{{ $mouvement->product->designation ?? 'N/A' }}</span>
            <span class="badge {{ $mouvement->type == 'entree' ? 'bg-success' : 'bg-danger' }}">
              {{ $mouvement->quantity }} {{ $mouvement->type }}
            </span>
          </li>
          @empty
          <li class="text-center text-muted py-4">Aucun mouvement récent</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Quick actions -->
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-3">Actions rapides</h5>
        <div class="row">
          <div class="col-md-3 mb-3">
<a href="/products/create" class="d-block p-3 border rounded text-center text-decoration-none sneat-stat-card">
              <i class="bx bx-plus fs-2 text-primary mb-2 d-block"></i>
              <span class="fw-semibold d-block">Nouveau produit</span>
            </a>
          </div>
          <div class="col-md-3 mb-3">
<a href="/decharges/create" class="d-block p-3 border rounded text-center text-decoration-none sneat-stat-card">
              <i class="bx bx-box bx-tilt fs-2 text-success mb-2 d-block"></i>
              <span class="fw-semibold d-block">Décharge</span>
            </a>
          </div>
          <div class="col-md-3 mb-3">
            <a href="/rapports" class="d-block p-3 border rounded text-center text-decoration-none sneat-stat-card">
              <i class="bx bx-file fs-2 text-info mb-2 d-block"></i>
              <span class="fw-semibold d-block">Rapports</span>
            </a>
          </div>
          <div class="col-md-3 mb-3">
            <a href="/inventaires" class="d-block p-3 border rounded text-center text-decoration-none sneat-stat-card">
              <i class="bx bx-list-check fs-2 text-warning mb-2 d-block"></i>
              <span class="fw-semibold d-block">Inventaire</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Simple chart placeholder - real data will populate via JS later
</script>
@endpush

