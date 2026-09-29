<header class="client-navbar">

    <a
        href="{{ route('home') }}"
        class="client-brand"
    >

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


        @php

            $quantidadeCarrinho = array_sum(
                session('carrinho', [])
            );

        @endphp


        <a
            href="{{ route('cliente.carrinho') }}"
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


        @auth

            @if(!auth()->user()->is_admin)

                <a href="{{ route('agendamento.agendar') }}">
                    Agendamentos
                </a>


                <a
                    href="{{ route('cliente.notificacoes') }}"
                    class="client-notifications-link"
                >

                    Notificações

                    <span class="client-notification-wrapper">

                        <i class="bi bi-bell-fill"></i>


                        @if(($quantidadeNotificacoes ?? 0) > 0)

                            <span class="client-notification-count">

                                {{
                                    $quantidadeNotificacoes > 9
                                        ? '9+'
                                        : $quantidadeNotificacoes
                                }}

                            </span>

                        @endif

                    </span>

                </a>

            @endif

        @endauth

    </nav>


    @auth

        <a
            href="{{
                auth()->user()->is_admin
                    ? route('admin.dashboard')
                    : route('cliente.perfil')
            }}"
            class="client-profile"
        >

            <span class="client-avatar-initials">

                {{ auth()->user()->iniciais }}

            </span>


            <div class="client-profile-info">

                <strong>
                    {{ auth()->user()->nome }}
                </strong>


                <span>

                    {{
                        auth()->user()->is_admin
                            ? 'Administrador'
                            : 'Cliente'
                    }}

                </span>

            </div>

        </a>


        @if(!auth()->user()->is_admin)

            <a
                href="{{ route('cliente.perfil.editar') }}"
                class="client-settings"
                title="Editar perfil"
            >

                <i class="bi bi-gear-fill"></i>

            </a>

        @endif


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