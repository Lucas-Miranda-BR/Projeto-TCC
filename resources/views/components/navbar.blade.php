@php
    $quantidadeCarrinho = array_sum(session('carrinho', []));

    // página atual: o link correspondente fica com a barrinha embaixo
    $ativa = fn (...$rotas) => request()->routeIs(...$rotas);
@endphp

<header class="client-navbar">

    <a href="{{ route('home') }}" class="client-brand">
        <img
            src="{{ asset('images/logo.png') }}"
            alt="Salão Sempre Diva"
            class="client-brand-image"
        >
    </a>

    <nav class="client-top-menu">

        <a href="{{ route('home') }}" @class(['active' => $ativa('home', 'inicio')])>Início</a>
        <a href="{{ route('site.sobre') }}" @class(['active' => $ativa('site.sobre')])>Sobre Mim</a>
        <a href="{{ route('site.servicos') }}" @class(['active' => $ativa('site.servicos')])>Serviços</a>
        <a href="{{ route('site.produtos') }}" @class(['active' => $ativa('site.produtos', 'site.produto.*')])>Produtos</a>

        <a href="{{ route('cliente.carrinho') }}" @class(['active' => $ativa('cliente.carrinho')])>
            Carrinho

            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                    <path d="M3 6h18"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>

                @if($quantidadeCarrinho > 0)
                    <span class="nav-badge">{{ $quantidadeCarrinho }}</span>
                @endif
            </span>
        </a>

        <a href="{{ route('site.ia') }}" @class(['active' => $ativa('site.ia')])>
            IA

            <span class="nav-icon nav-icon-ia">
                <svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor"
                     stroke-width=".8" stroke-linejoin="round">
                    <path d="M8.5 5.7Q10.4 12.3 17 14.2Q10.4 16.1 8.5 22.7Q6.6 16.1 0 14.2Q6.6 12.3 8.5 5.7Z"/>
                    <path opacity=".75" d="M17.1 1.3Q18 4.6 21.3 5.5Q18 6.4 17.1 9.7Q16.2 6.4 12.9 5.5Q16.2 4.6 17.1 1.3Z"/>
                    <path opacity=".5" d="M21.9 8.2Q22.35 9.85 24 10.3Q22.35 10.75 21.9 12.4Q21.45 10.75 19.8 10.3Q21.45 9.85 21.9 8.2Z"/>
                </svg>
            </span>
        </a>

        @auth
            @if(!auth()->user()->is_admin)

                <a href="{{ route('agendamento.agendar') }}" @class(['active' => $ativa('agendamento.*')])>Agendamentos</a>

                <a href="{{ route('cliente.notificacoes') }}" @class(['active' => $ativa('cliente.notificacoes*')])>
                    Notificações

                    <span class="nav-icon">
                        <i class="bi bi-bell"></i>

                        @if(($quantidadeNotificacoes ?? 0) > 0)
                            <span class="nav-badge">
                                {{ $quantidadeNotificacoes > 9 ? '9+' : $quantidadeNotificacoes }}
                            </span>
                        @endif
                    </span>
                </a>

            @endif
        @endauth

    </nav>

    <div class="client-user-area">

        @auth

            <a
                href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('cliente.perfil') }}"
                class="client-profile"
            >
                <span class="client-avatar-initials">
                    {{ auth()->user()->iniciais }}
                </span>

                <span class="client-profile-info">
                    <strong>{{ auth()->user()->nome }}</strong>
                    @if(auth()->user()->is_admin)
                        <small>Administrador</small>
                    @endif
                </span>
            </a>

            @if(!auth()->user()->is_admin)
                <a href="{{ route('cliente.perfil.editar') }}" class="client-icon-btn" title="Editar perfil">
                    <i class="bi bi-gear"></i>
                </a>
            @endif

            <a href="{{ route('cliente.logout') }}" class="client-icon-btn" title="Sair">
                <i class="bi bi-box-arrow-right"></i>
            </a>

        @else

            <a href="{{ route('cliente.login') }}" class="client-login">Entrar</a>

        @endauth

    </div>

</header>