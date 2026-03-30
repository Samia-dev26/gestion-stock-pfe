<div class="sidebar" id="sidebar">
  <a href="{{ route('dashboard') }}" class="sb-brand text-decoration-none">
    <div class="sb-logo"><i class="bi bi-boxes"></i></div>
    <div class="sb-name">Stock<span>Pro</span></div>
  </a>

  <div class="sb-user">
    <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
    <div>
      <div class="sb-uname">{{ auth()->user()->name }}</div>
      <span class="sb-badge {{ auth()->user()->role === 'admin' ? 'badge-admin' : (auth()->user()->role === 'gestionnaire' ? 'badge-gest' : 'badge-agent') }}">
        {{ ucfirst(auth()->user()->role) }}
      </span>
    </div>
  </div>

  <div class="sb-nav">
    <!-- Principal -->
    <div class="sb-section">Principal</div>
    <a href="{{ route('dashboard') }}" class="nav-lnk {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-aos="fade-left">
      <i class="bi bi-grid-1x2-fill"></i> Tableau de bord
    </a>

    <!-- Settings -->
    <div class="sb-section">Paramètres</div>
    <a href="{{ route('profile.edit') }}" class="nav-lnk {{ request()->routeIs('profile.*') ? 'active' : '' }}" data-aos="fade-left">
      <i class="bi bi-gear"></i> Paramètres
    </a>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="nav-lnk-container">
      @csrf
      <button type="submit" class="nav-lnk w-100 text-start border-0 bg-transparent p-0 h-auto" style="line-height: 1.4;">
        <i class="bi bi-box-arrow-right"></i> Déconnexion
      </button>
    </form>

    <!-- Stock -->
    <div class="sb-section">Stock</div>
    <a href="{{ route('articles.index') }}" class="nav-lnk {{ request()->routeIs('articles.*') ? 'active' : '' }}" data-aos="fade-left" data-aos-delay="50">
      <i class="bi bi-box-seam"></i> Produits
    </a>
    <a href="{{ route('categories.index') }}" class="nav-lnk {{ request()->routeIs('categories.*') ? 'active' : '' }}" data-aos="fade-left" data-aos-delay="100">
      <i class="bi bi-tag"></i> Catégories
    </a>

    <!-- Opérations -->
    <div class="sb-section">Opérations</div>
    <a href="{{ route('mouvements.index') }}" class="nav-lnk {{ request()->routeIs('mouvements.*') ? 'active' : '' }}" data-aos="fade-left">
      <i class="bi bi-arrow-left-right"></i> Mouvements
    </a>
    <a href="{{ route('decharges.index') }}" class="nav-lnk {{ request()->routeIs('decharges.*') ? 'active' : '' }}" data-aos="fade-left" data-aos-delay="50">
      <i class="bi bi-box-arrow-right"></i> Décharges
    </a>

    @if(auth()->user()->role === 'gestionnaire' || auth()->user()->role === 'admin')
    <!-- Rapports -->
    <div class="sb-section">Rapports</div>
    <a href="{{ route('rapports.index') }}" class="nav-lnk {{ request()->routeIs('rapports.*') ? 'active' : '' }}" data-aos="fade-left">
      <i class="bi bi-file-earmark-bar-graph"></i> Rapports
    </a>
    @endif

    @if(auth()->user()->role === 'admin')
    <!-- Admin -->
    <div class="sb-section">Administration</div>
    <a href="{{ route('users.index') }}" class="nav-lnk {{ request()->routeIs('users.*') ? 'active' : '' }}" data-aos="fade-left">
      <i class="bi bi-people"></i> Utilisateurs
    </a>
    @endif
  </div>
</div>
