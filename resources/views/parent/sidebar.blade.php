<!-- resources/views/parent/sidebar.blade.php -->
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="#">
      <span class="ms-1 font-weight-bold">Parent Dashboard</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('parent.dashboard') }}">
          <i class="ni ni-tv-2 text-primary"></i>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('parent.profile') }}">
          <i class="ni ni-single-02 text-yellow"></i>
          <span class="nav-link-text ms-1">Mon Profil</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('parent.children') }}">
          <i class="ni ni-circle-08 text-info"></i>
          <span class="nav-link-text ms-1">Mes Enfants</span>
        </a>
      </li>
      <!-- Ajouter plus d'éléments si nécessaire -->
    </ul>
  </div>
</aside>
