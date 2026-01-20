<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
          <p>hotel de Estiven</p>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

       
       <!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
           <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">--> 
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::check() ? Auth::user()->name : 'Usuario' }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            @if(Auth::check())
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name }}</h6>
              <span>{{ Auth::user()->email }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Salir</span>
                </button>
              </form>
            </li>
            @else
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Iniciar Sesión</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('register') }}">
                <i class="bi bi-person-plus"></i>
                <span>Registrarse</span>
              </a>
            </li>
            @endif
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header>