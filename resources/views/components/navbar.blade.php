<header class="client-navbar">

    <a href="{{ route('home') }}" class="client-brand">
        <img
            src="{{ asset('images/logo.png') }}"
            alt="Salão Sempre Diva"
            class="client-brand-image"
        >
    </a>

    <nav class="client-top-menu">

        <a href="{{ route('home') }}">
            Início
        </a>

        <a href="{{ route('site.sobre') }}">
            Sobre Mim
        </a>

        <a href="{{ route('site.servicos') }}">
            Serviços
        </a>

        <a href="{{ route('site.produtos') }}">
            Produtos
        </a>

        <a href="{{ route('site.ia') }}">
            IA
            <i class="bi bi-image"></i>
        </a>

        <a href="#" class="client-notifications-link">

            Notificações

            <span class="client-notification-wrapper">

                <i class="bi bi-bell-fill"></i>

                <span class="client-notification-count">
                    0
                </span>

            </span>

        </a>

    </nav>


    @if(session('cliente'))

        <a
            href="{{ route('cliente.perfil') }}"
            class="client-profile"
        >

            <img
                src="{{ asset('images/logo.png') }}"
                class="client-avatar"
                alt="Perfil"
            >

            <div class="client-profile-info">

                <strong>
                    {{ session('cliente')->nome }}
                </strong>

                <span>
                    Cliente
                </span>

            </div>

        </a>

        <a
            href="{{ route('cliente.perfil') }}"
            class="client-settings"
            title="Perfil"
        >
            <i class="bi bi-gear-fill"></i>
        </a>

        <a
            href="{{ route('cliente.logout') }}"
            class="client-logout"
            title="Sair"
        >
            <i class="bi bi-box-arrow-right"></i>
        </a>

    @else

        <a
            href="{{ route('cliente.login') }}"
            class="client-login"
        >
            Login
        </a>

    @endif

</header>