<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'StockPro - Gestion Stock')</title>

  <!-- Bootstrap core -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">

  <!-- Animations -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  @stack('styles')
</head>
<body class="app-shell">

<!-- Global loader -->
<div id="page-loader" class="page-loader d-none">
  <div class="loader-inner">
    <div class="spinner-border text-primary" role="status"></div>
    <p class="mt-2 fw-semibold text-primary">Chargement...</p>
  </div>
</div>

<!-- SIDEBAR -->


<!-- MAIN -->
<div class="main-wrap">
 

  <!-- FLASH -->
  <div class="px-4 pt-3">
    @if(session('success'))
    <div class="alert alert-success fade-up mb-0">
      <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger fade-up mb-0">
      <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
    @endif
  </div>

  <!-- CONTENT -->
  <main class="page-content">
    @yield('content')
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
// Sidebar toggle (mobile)
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
  const sidebar = document.getElementById('sidebar');
  sidebar?.classList.toggle('open');
  sidebar?.classList.toggle('show');
  document.querySelector('.main-wrap').classList.toggle('expanded');
});

// Counter animation for stat numbers
function animateCounters() {
  document.querySelectorAll('.stat-val[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count || '0', 10);
    let current = 0;
    const increment = Math.max(target / 40, 1);
    const timer = setInterval(() => {
      current += increment;
      if (current >= target) { current = target; clearInterval(timer); }
      el.textContent = Math.floor(current).toLocaleString();
    }, 20);
  });
}

// Global confirm helper
function bindConfirms() {
  document.querySelectorAll('[data-confirm]').forEach(el => {
    if (el.dataset.confirmBound) return;
    el.dataset.confirmBound = '1';
    const handler = (e) => {
      if (!confirm(el.dataset.confirm)) { e.preventDefault(); e.stopPropagation(); }
    };
    if (el.tagName === 'FORM') el.addEventListener('submit', handler);
    else el.addEventListener('click', handler);
  });
}

// Show loader on form submit (opt-in)
function bindLoaders() {
  const loader = document.getElementById('page-loader');
  document.querySelectorAll('form[data-loading]').forEach(form => {
    if (form.dataset.loaderBound) return;
    form.dataset.loaderBound = '1';
    form.addEventListener('submit', () => {
      loader?.classList.remove('d-none');
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  AOS.init({ duration: 650, once: true, offset: 40 });
  animateCounters();
  bindConfirms();
  bindLoaders();
});
</script>
@stack('scripts')
</body>
</html>

