<header class="topbar shadow-sm">
  <div class="d-flex align-items-center">
    <button class="btn-toggle-sidebar btn btn-link p-0 me-3 d-lg-none" id="sidebarToggle">
      <i class="bi bi-list fs-3 text-white"></i>
    </button>
    <h5 class="mb-0 fw-bold text-white">@yield('title', 'Dashboard')</h5>
  </div>

  <div class="d-flex align-items-center gap-3">
    <!-- Notifications -->
    <div class="position-relative">
      <button class="btn btn-icon btn-outline-light rounded-circle p-2" data-bs-toggle="dropdown">
        <i class="bi bi-bell fs-5"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          3
          <span class="visually-hidden">Nouvelles notifications</span>
        </span>
      </button>
      <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2" style="width: 320px; max-height: 400px; overflow-y: auto; z-index: 1080;">
        <h6 class="dropdown-header">Notifications</h6>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item p-2">
          <div class="d-flex">
            <div class="flex-shrink-0">
              <i class="bi bi-box-arrow-down text-warning fs-4"></i>
            </div>
            <div class="flex-grow-1 ms-3">
              <div class="fw-semibold">Nouvelle entrée stock</div>
              <small class="text-muted">Il y a 2 min</small>
            </div>
          </div>
        </a>
        <!-- More notifications -->
        <div class="dropdown-divider"></div>
        <a href="{{ route('notifications.index') }}" class="dropdown-item text-center fw-semibold">Voir tout</a>
      </div>
    </div>

    <!-- User dropdown -->
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle hidden-arrow p-2 rounded-circle" id="userDropdown" data-bs-toggle="dropdown">
        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=6366f1&color=fff&size=40&bold=true&rounded=true" class="rounded-circle" width="40" height="40" alt="{{ auth()->user()->name }}">
      </a>
<ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3" style="min-width: 220px; z-index: 1070 !important; position: absolute !important;">
        <li>
          <h6 class="dropdown-header text-dark">{{ auth()->user()->name }}</h6>
          <p class="dropdown-item-text text-muted mb-1">{{ auth()->user()->email }}</p>
          <span class="badge badge-{{ strtolower(auth()->user()->role) }} ms-2">{{ ucfirst(auth()->user()->role) }}</span>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item rounded-2" href="{{ route('profile.edit') }}"><i class="bi bi-gear me-2"></i> Paramètres</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="dropdown-item rounded-2 text-danger w-100 text-start border-0 bg-transparent"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</header>
