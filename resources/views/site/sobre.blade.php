@extends('layouts.app')

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    {{-- baixa a foto da hero o quanto antes --}}
    <link rel="preload" as="image" href="{{ asset('images/12cf2d08-6d57-4785-9777-65d46319b2a1.jpg') }}" fetchpriority="high">
    <link rel="stylesheet" href="{{ asset('css/sobre.css') }}">
@endpush

@section('content')

    @include('components.navbar')

    {{-- INTRODUÇÃO --}}
    <section class="about-hero">
        <div class="about-hero-inner">

            <div class="about-hero-text">
                <h1 class="about-name">
                    Sandra<br><span class="last">Nerys</span>
                </h1>

                <p class="about-desc">
                    Sandra Nerys tem 41 anos e é especialista em embelezamento. Desde 2015 é proprietária do
                    Salão Sempre Diva, onde faz um atendimento cuidadoso, moderno e personalizado.
                </p>

                <p class="about-desc">
                    Para ela, o trabalho vai além do cabelo: é ajudar cada mulher que passa pelo salão a se
                    sentir mais confiante.
                </p>

                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-num">20</div>
                        <div class="stat-label">anos de carreira</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">4 mil</div>
                        <div class="stat-label">atendimentos</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">6</div>
                        <div class="stat-label">certificados</div>
                    </div>
                </div>
            </div>

            <div class="about-hero-media">
                <div class="about-photo-wrap">
                    <img
                        class="about-photo"
                        src="{{ asset('images/12cf2d08-6d57-4785-9777-65d46319b2a1.jpg') }}"
                        alt="Sandra Nerys, proprietária do Salão Sempre Diva"
                    >
                </div>
            </div>

        </div>
    </section>

    {{-- Segura a animação da introdução até a foto estar carregada, para texto e foto
         entrarem juntos mesmo com internet lenta. Sem JS, a animação roda normalmente. --}}
    <script>
        (function () {
            var hero = document.querySelector('.about-hero');
            var photo = document.querySelector('.about-photo');
            if (!hero || !photo) return;

            var started = false;

            function start() {
                if (started) return;
                started = true;

                requestAnimationFrame(function () {
                    hero.classList.remove('is-waiting');
                });
            }

            hero.classList.add('is-waiting');

            if (photo.decode) {
                photo.decode().then(start, start);
            } else if (photo.complete) {
                start();
            } else {
                photo.onload = photo.onerror = start;
            }

            // internet muito lenta: não deixa o texto esperando para sempre
            setTimeout(start, 2500);
        })();
    </script>

    {{-- CITAÇÃO --}}
    <section class="quote-section">
        <figure class="quote-inner">
            <blockquote class="quote-text">
                “Cada cabelo conta uma história. Meu trabalho é fazer com que essa história seja contada com orgulho.”
            </blockquote>
            <figcaption class="quote-author">Sandra Nerys</figcaption>
        </figure>
    </section>

    {{-- TRAJETÓRIA --}}
    <section class="trajetoria-section section-wrap">
        <h2 class="section-title">Trajetória</h2>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-year">2005</div>
                <div class="timeline-title">O primeiro corte</div>
                <p class="timeline-desc">
                    Começou como assistente em um salão de bairro, aprendendo lavagem e escova e a ouvir cada
                    cliente.
                </p>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2010</div>
                <div class="timeline-title">Especialização em coloração</div>
                <p class="timeline-desc">
                    Estudou colorimetria: correção de cor, loiros e vermelhos.
                </p>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2015</div>
                <div class="timeline-title">Abre o Salão Sempre Diva</div>
                <p class="timeline-desc">
                    Abriu o próprio salão, com atendimento cuidadoso e personalizado.
                </p>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2020</div>
                <div class="timeline-title">Cortes e visagismo</div>
                <p class="timeline-desc">
                    Fez formação em visagismo para criar cortes que combinam com o rosto e a personalidade de
                    cada cliente.
                </p>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">Hoje</div>
                <div class="timeline-title">Mais de 4 mil atendimentos</div>
                <p class="timeline-desc">
                    Segue atendendo no Salão Sempre Diva.
                </p>
            </div>
        </div>
    </section>

    {{-- CERTIFICAÇÕES --}}
    <section class="certifications">
        <div class="section-wrap">
            <h2 class="section-title">Certificados e especializações</h2>

            <div class="cert-grid">
                @for ($i = 1; $i <= 6; $i++)
                    <div class="cert-card">
                        <img src="{{ asset('images/certificado-' . $i . '.jpg') }}" alt="Certificado de especialização {{ $i }}" loading="lazy">
                    </div>
                @endfor
            </div>
        </div>
    </section>

    {{-- CONTATO --}}
    <section class="cta-section">
        <div class="cta-banner">
            <div>
                <h2>Vamos cuidar do seu cabelo?</h2>
                <p>Agende seu horário pelo telefone ou pelo Instagram.</p>
            </div>

            <div class="cta-actions">
                <a class="btn-cta" href="tel:+5515981807270">
                    <svg class="icon icon-sm" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.362 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                    </svg>
                    (15) 98180-7270
                </a>

                <a class="btn-cta" href="https://www.instagram.com/salaosemprediva" target="_blank" rel="noopener">
                    <svg class="icon icon-sm" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="2" y="2" width="20" height="20" rx="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                    @salaosemprediva
                </a>
            </div>
        </div>
    </section>

    @include('components.footer')

@endsection