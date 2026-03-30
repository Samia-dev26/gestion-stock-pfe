<nav
  class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
  id="layout-navbar"
>
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        <i class="bx bx-search fs-4 lh-0"></i>
        <input
          type="text"
          class="form-control border-0 shadow-none"
          placeholder="Rechercher produits..."
          aria-label="Search..."
        />
      </div>
    </div>
    <!-- /Search -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Notifications -->
      <li class="nav-item dropdown-notifications">
        <a class="nav-link nav-link-dropdown-toggle notification-toggle hide-arrow d-flex align-items-center p-2" href="javascript:void(0);" data-bs-toggle="dropdown">
          <i class="bx bx-bell bx-sm"></i>
          <span class="badge rounded-pill bg-danger position-absolute top-0 right-0 start-0 translate-middle"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end border-0 box-shadow-0 dropdown-notifications-list">
          <li class="border-bottom">
            <div class="row px-3 pt-2 pb-1">
              <h6 class="mb-0 dropdown-header text-uppercase fs-6">Notifications</h6>
            </div>
          </li>
          <li class="list-group list-group-flush px-2">
            <!-- More notifications will be added via JS -->
          </li>
        </ul>
      </li>

      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'User' }}&background=6366f1&color=fff&size=40" alt class="w-px-40 h-auto rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
          <li>
            <div class="px-3 pt-2 pb-2">
              <a href="{{ route('profile.edit') }}" class="d-flex align-items-center text-decoration-none">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'User' }}&background=6366f1&color=fff&size=40" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                  <small class="text-muted">{{ ucfirst(auth()->user()->role ?? 'agent') }}</small>
                </div>
              </a>
            </div>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
              <i class="bx bx-cog me-2"></i>
              <span class="align-middle">Paramètres</span>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
              @csrf
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Déconnexion</span>
              </a>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

