<!-- <header class="navbar">

    <img src="{{ asset('images/logo.png') }}" class="logo">

    <nav>

        <a href="{{ route('site.home') }}">Início</a>

        <a href="{{ route('site.sobre') }}">Sobre Mim</a>

        <a href="{{ route('site.servicos') }}">Serviços</a>

        <a href="#">Produtos</a>

        <a href="#">IA</a>

        <a href="#">Notificações</a>

        <a href="{{ route('cliente.login') }}" class="btn-login">
            Login
        </a>

    </nav>

</header> -->

<nav class="navbar navbar-expand-lg bg-wine px-3 px-lg-5 fixed-top shadow-sm align-items-center">
    <div class="container-fluid px-0 justify-content-end">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-label="Abrir menu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse flex-grow-0" id="navMenu">
        <ul class="navbar-nav align-items-lg-center gap-lg-4 me-lg-4">
          <li class="nav-item"><a class="nav-link" href="#">Início</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Sobre mim</a></li>
          <li class="nav-item"><a class="nav-link active" href="#" aria-current="page">Produtos</a></li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              IA
              <svg class="icon icon-sm" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true">
                <path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/>
              </svg>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              Notificações
              <svg class="icon icon-sm" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 01-3.46 0"/>
              </svg>
            </a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
          <button class="btn btn-wine rounded-pill d-flex align-items-center gap-2 px-3" type="button">
            <span class="login-avatar">
              <svg class="icon icon-sm" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
            </span>
            Login
          </button>
          <button class="btn btn-icon-transparent rounded-circle" type="button" aria-label="Configurações">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="3"/>
              <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06A1.65 1.65 0 004.6 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06A1.65 1.65 0 009 4.6a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </nav>