@extends('layouts.sneat-layout')
@section('title', 'Admin Dashboard - StockPro')

@push('styles')
<style>
  /* Sneat customizations for Admin dashboard */
  .sneat-stat-card { 
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .sneat-stat-card:hover { 
    transform: translateY(-4px); 
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
  }
  .chart-container { height: 300px; position: relative; }
  .table-sneat th { font-weight: 600; color: #697a8d; border: none; }
  .table-sneat td { vertical-align: middle; border-color: #f8f9fa; }
  .badge-admin { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
  .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 8px; }
  .status-active { background: #10b981; }
  .status-inactive { background: #ef4444; }
  .user-avatar { width: 36px; height: 36px; border-radius: 50%; font-size: 0.85rem; font-weight: 600; }
</style>
@endpush

@section('content')
<!-- Page header -->
<div class="page-header d-flex justify-content-between align-items-center">
  <div>
    <h3 class="page-title mb-1 fw-bold">{{ auth()->user()->name }}, Bienvenue dans le panneau d'administration</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Admin</li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2">
    <a href="/users" class="btn btn-primary">
      <i class="bx bx-user-plus"></i> Gérer utilisateurs
    </a>
    <a href="/products" class="btn btn-outline-primary">
      <i class="bx bx-box"></i> Produits
    </a>
  </div>
</div>

<!-- Stats cards -->
<div class="row mb-5">
  <!-- Total Products -->
  <div class="col-lg-3 col-md-6 col-12 mb-3">
    <div class="card sneat-stat-card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar bg-primary rounded me-3">
            <i class="bx bx-box fs-4 text-white"></i>
          </div>
          <div>
            <h4 class="mb-0">{{ $totalProducts ?? 0 }}</h4>
            <small class="text-muted">Total produits</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Low Stock -->
  <div class="col-lg-3 col-md-6 col-12 mb-3">
    <div class="card sneat-stat-card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar bg-warning rounded me-3">
            <i class="bx bx-error fs-4 text-white"></i>
          </div>
          <div>
            <h4 class="mb-0 text-warning">{{ $lowStockCount ?? 0 }}</h4>
            <small class="text-muted">Stock critique</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Movements Today -->
  <div class="col-lg-3 col-md-6 col-12 mb-3">
    <div class="card sneat-stat-card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar bg-success rounded me-3">
            <i class="bx bx-git-merge fs-4 text-white"></i>
          </div>
          <div>
            <h4 class="mb-0 text-success">{{ $mouvementsToday ?? 0 }}</h4>
            <small class="text-muted">Mouvements aujourd'hui</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Users -->
  <div class="col-lg-3 col-md-6 col-12 mb-3">
    <div class="card sneat-stat-card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar bg-info rounded me-3">
            <i class="bx bx-user fs-4 text-white"></i>
          </div>
          <div>
            <h4 class="mb-0">{{ $totalUsers ?? 0 }}</h4>
            <small class="text-muted">Utilisateurs</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Charts and tables -->
<div class="row">
  <!-- Mouvements Chart -->
  <div class="col-xl-8 col-lg-7">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Mouvements Stock - 30 derniers jours</h5>
        <div class="dropdown">
          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            Période
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">7 jours</a></li>
            <li><a class="dropdown-item" href="#">30 jours</a></li>
            <li><a class="dropdown-item" href="#">90 jours</a></li>
          </ul>
        </div>
      </div>
      <div class="card-body">
        <div id="mouvementsChart" class="chart-container"></div>
      </div>
    </div>
  </div>

  <!-- Products Critiques -->
  <div class="col-xl-4 col-lg-5">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Produits en stock critique</h5>
      </div>
      <div class="card-body">
        <ul class="list-unstyled mb-0">
          @forelse($criticalProducts ?? [] as $product)
          <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
            <div>
              <div class="fw-semibold">{{ $product->designation }}</div>
              <small class="text-muted">{{ $product->category->nom ?? 'Sans catégorie' }}</small>
            </div>
            <div class="text-end">
              <div class="fw-bold text-danger">{{ $product->quantity }}</div>
              <small class="text-muted">min: {{ $product->seuil_minimum }}</small>
            </div>
          </li>
          @empty
          <li class="text-center text-muted py-4">Aucun produit critique</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Recent movements table -->
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Derniers mouvements</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-sneat table-hover mb-0">
          <thead>
            <tr>
              <th>Date</th>
              <th>Produit</th>
              <th>Type</th>
              <th>Quantité</th>
              <th>Utilisateur</th>
              <th>Référence</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentMovements ?? [] as $mouvement)
            <tr>
              <td>{{ $mouvement->created_at->format('d/m H:i') }}</td>
              <td>{{ $mouvement->product->designation ?? '—' }}</td>
              <td>
                <span class="badge {{ $mouvement->type == 'entree' ? 'bg-success' : 'bg-danger' }}">
                  {{ $mouvement->type == 'entree' ? 'Entrée' : 'Sortie' }}
                </span>
              </td>
              <td><strong>{{ $mouvement->quantity }}</strong></td>
              <td>{{ $mouvement->user->name ?? 'Système' }}</td>
              <td>{{ $mouvement->reference ?? '—' }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Aucun mouvement récent</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Recent users -->
<div class="row mt-4">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Utilisateurs récents</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-sneat mb-0">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Rôle</th>
              <th>Statut</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentUsers ?? [] as $user)
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-3">
                    <div class="avatar-initial rounded-circle bg-primary">
                      {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                  </div>
                  {{ $user->name }}
                </div>
              </td>
              <td>
                <span class="badge badge-admin">{{ ucfirst($user->role) }}</span>
              </td>
              <td>
                <span class="status-dot {{ $user->active ? 'status-active' : 'status-inactive' }}"></span>
                {{ $user->active ? 'Actif' : 'Inactif' }}
              </td>
              <td>{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted">Aucun utilisateur récent</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // ApexCharts Mouvements
  var options = {
    series: [{
      name: 'Entrées',
      data: [31, 40, 28, 51, 42, 109, 100]
    }, {
      name: 'Sorties',
      data: [11, 32, 45, 32, 34, 52, 41]
    }],
    chart: {
      type: 'area',
      height: 300,
      toolbar: { show: false }
    },
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 2 },
    tooltip: { x: { format: 'dd/MM' } },
    grid: { borderColor: '#f8f9fa' },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.7,
        opacityTo: 0.3,
        stops: [0, 90, 100]
      }
    },
    xaxis: {
      categories: ['01/03', '02/03', '03/03', '04/03', '05/03', '06/03', '07/03'],
    },
    colors: ['#10b981', '#ef4444']
  };

  var chart = new ApexCharts(document.querySelector('#mouvementsChart'), options);
  chart.render();
</script>
@endpush

