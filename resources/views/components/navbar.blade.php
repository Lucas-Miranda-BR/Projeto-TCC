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

        @auth
            <a href="#">Notificações</a>
        @endauth
        
        <a href="{{ route('site.servicos') }}">
            Serviços
        </a>

        <a href="{{ route('site.produtos') }}">
            Produtos
        </a>
        @php
    $quantidadeCarrinho = array_sum(
        session('carrinho', [])
    );
@endphp


<a
    href="{{ route('carrinho.index') }}"
    class="client-cart-link"
>

    Carrinho

    <span class="client-cart-icon">

        <i class="bi bi-bag-fill"></i>

        @if($quantidadeCarrinho > 0)

            <span class="client-cart-count">
                {{ $quantidadeCarrinho }}
            </span>

        @endif

    </span>

</a>

        <a href="{{ route('site.ia') }}">
            IA
            <i class="bi bi-image"></i>
        </a>

        @if(session('cliente'))

            <a href="{{ route('agendamento.agendar') }}">
                Agendamentos
            </a>

        @endif


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


    @auth

        <a
            href="{{ route('cliente.perfil') }}"
            class="client-profile"
        >

            <span class="client-avatar-icon">
                <i class="bi bi-person-fill"></i>
            </span>

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
            href="{{ route('cliente.perfil.editar') }}"
            class="client-settings"
            title="Editar perfil"
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

    @endauth

</header>   