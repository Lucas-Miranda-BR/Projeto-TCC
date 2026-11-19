@extends('layouts.app')

@php
    // versão pelo horário de modificação: a cada alteração o navegador baixa o CSS novo (sem depender de cache)
    $versaoCss = file_exists(public_path('css/inicio.css')) ? filemtime(public_path('css/inicio.css')) : time();
@endphp

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}?v={{ $versaoCss }}">
@endpush

@section('content')

{{-- Navbar (mesmo código de components/navbar.blade.php) --}}
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

        <a href="{{ route('home') }}" @class(['active' => $ativa('home')])>Início</a>
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

{{-- Tela inicial do site: sem footer. O botão leva para a página home. --}}
<main class="inicio-page">

    <h1 class="inicio-title">
        <span class="inicio-line ini-anim" style="--d: 0ms">Um salão que cuida</span>
        <span class="inicio-line inicio-line--red ini-anim" style="--d: 120ms">de cada detalhe,</span>
        <span class="inicio-line ini-anim" style="--d: 240ms">não só do corte</span>
    </h1>

    <div class="inicio-intro">

        <p class="ini-anim" style="--d: 360ms">
            Cabelo, unhas e depilação com atendimento individual e produtos de
            qualidade, para realçar a sua essência.
        </p>

    </div>

    <img
        class="inicio-butterfly ini-anim"
        style="--d: 200ms"
        src="{{ asset('images/logo-borboleta-4k.png') }}"
        alt="Borboleta do logo do Salão Sempre Diva"
    >

    <div class="inicio-card-wrap ini-anim ini-float-b" style="--d: 600ms">
        <a href="{{ route('site.servicos') }}" class="inicio-card">
            <img src="{{ asset('images/trabalho1.png') }}" alt="Corte de cabelo feito no salão">
            <strong>Nossos trabalhos</strong>
            <span>Veja exemplos do resultado dos nossos atendimentos</span>
        </a>
    </div>

    <div class="inicio-pill-wrap ini-anim ini-float-c" style="--d: 720ms">
        <a href="{{ route('site.servicos') }}" class="inicio-pill">Nossos serviços</a>
    </div>

    <div class="inicio-stats ini-anim" style="--d: 840ms">

        <div class="inicio-stats-title"><span>20</span> anos</div>

        <p>de carreira em Tatuí<br>para todas as clientes</p>

        <div class="inicio-avatars">
            <img src="{{ asset('images/trabalho1.png') }}" alt="">
            <img src="{{ asset('images/manicure.png') }}" alt="">
            <img src="{{ asset('images/depilacao.png') }}" alt="">
        </div>

    </div>

</main>


@endsection