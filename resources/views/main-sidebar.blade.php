<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Sapeurs
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-fire-extinguisher"></i>
            <p>
              Alarmes
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Exercices & Séances
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-sitemap"></i>
            <p>
              Organisation
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="fas fa-calculator nav-icon"></i>
            <p>
              Frais
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-hand-holding-usd"></i>
            <p>
              Amendes
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-envelope"></i>
            <p>
              Publipostage
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-toolbox"></i>
            <p>
              Matériel personel
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-file-medical-alt"></i>
            <p>
              Certificats médicaux
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-sitemap"></i>
            <p>
              Impressions
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-sliders-h"></i>
            <p>
              Configuration
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sapeur.index') }}" class="nav-link internal-link">
            <i class="nav-icon fas fa-globe-africa"></i>
            <p>
              Exportation -> RTA
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
