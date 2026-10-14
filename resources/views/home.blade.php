@extends('layouts.app')

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Montserrat:wght@400;500;600&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

@include('components.navbar')

<main class="home-page">

    {{-- HERO --}}
    <section class="home-hero">

        <div class="home-hero-inner">

            <p class="home-hero-kicker">Salão de beleza de Sandra Nerys</p>

            <h1>Salão Sempre Diva</h1>

            <p class="home-hero-text">
                Cabelo e unhas com atendimento individual e produtos de qualidade.
                Escolha seu serviço e marque o horário pelo site.
            </p>

            <div class="home-hero-actions">
                <a href="{{ route('agendamento.agendar') }}" class="home-btn home-btn-light">Agendar horário</a>
                <a href="{{ route('site.servicos') }}" class="home-btn home-btn-outline">Ver serviços</a>
            </div>

        </div>

    </section>

    {{-- ATALHOS --}}
    <section class="home-container home-section">

        <div class="home-cards">

            <a href="{{ route('site.servicos') }}" class="home-card">
                <h2>Serviços</h2>
                <p>Cortes, coloração, tratamentos, manicure e nail art.</p>
                <span class="home-card-link">Ver serviços</span>
            </a>

            <a href="{{ route('site.produtos') }}" class="home-card">
                <h2>Produtos</h2>
                <p>Os produtos que a Sandra usa e indica para manter o resultado em casa.</p>
                <span class="home-card-link">Ver produtos</span>
            </a>

            <a href="{{ route('agendamento.agendar') }}" class="home-card">
                <h2>Agendamento</h2>
                <p>Escolha o serviço, o dia e o horário em poucos passos.</p>
                <span class="home-card-link">Agendar horário</span>
            </a>

        </div>

    </section>

    {{-- SOBRE --}}
    <section class="home-about">

        <div class="home-container home-about-grid">

            <div>

                <h2>Um espaço feito para o seu tempo</h2>

                <p class="home-about-text">
                    Há mais de dez anos a Sandra cuida de cabelos e unhas com atendimento
                    individual, biossegurança e produtos de boa performance. Cada visita
                    começa com uma conversa: entender a sua rotina faz parte do resultado.
                </p>

                <ul class="home-list">
                    <li>Biossegurança garantida</li>
                    <li>Produtos de alta qualidade</li>
                    <li>Profissionalismo e pontualidade</li>
                </ul>

            </div>

            <div class="home-gallery">
                <img src="{{ asset('images/prod-1-BPQ7Wc6b.jpg') }}" alt="Produto profissional do Salão Sempre Diva" loading="lazy">
                <img src="{{ asset('images/prod-2-DD_EaWGG.jpg') }}" alt="Produto profissional do Salão Sempre Diva" loading="lazy">
                <img src="{{ asset('images/prod-3-DirrTLqy.jpg') }}" alt="Produto profissional do Salão Sempre Diva" loading="lazy">
            </div>

        </div>

    </section>

    {{-- IA --}}
    <section class="home-cta-band">

        <div class="home-cta">

            <div>
                <h2>Provador de Estilo</h2>
                <p>Escolha o procedimento e a cor e veja uma prévia do resultado antes de agendar.</p>
            </div>

            <a href="{{ route('site.ia') }}" class="home-btn home-btn-light">Experimentar</a>

        </div>

    </section>

</main>

@include('components.footer')

@endsection