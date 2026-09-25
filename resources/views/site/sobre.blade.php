@extends('layouts.app')

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@400;500;600;700&family=Inria+Serif:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sobre.css') }}">
@endpush

@section('content')

    @include('components.navbar')

    
    <section class="about-hero">
        <div class="about-hero-inner">

            <div class="about-hero-text">
                <h1 class="about-name mb-3">
                    Sandra<br><span class="last">Nerys</span>
                </h1>

                <p class="about-desc">
                    Sandra Nerys, 41 anos, é especialista em embelezamento e apaixonada por elevar a autoestima de
                    seus clientes. Desde 2015, é proprietária do Salão Sempre Diva, onde oferece atendimento
                    cuidadoso, moderno e personalizado. Com dedicação e sensibilidade, Sandra transforma beleza em
                    confiança, criando uma experiência única para cada mulher que passa pelo seu salão.
                </p>

                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-num">20</div>
                        <div class="stat-label">anos de carreira</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">4K</div>
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
                        src="{{ asset('images/sandra-portrait-DG3g3Jq0.jpg') }}"
                        alt="Sandra Nerys, proprietária do Salão Sempre Diva"
                    >
                </div>
            </div>

        </div>
    </section>

    <hr class="section-divider">

    
    <section class="quote-section">
        <div class="quote-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="6" cy="6" r="3"/>
                <circle cx="6" cy="18" r="3"/>
                <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                <line x1="14.47" y1="14.48" x2="20" y2="20"/>
                <line x1="8.12" y1="8.12" x2="12" y2="12"/>
            </svg>
        </div>

        <p class="quote-text">
            "Cada cabelo conta uma história. Meu trabalho é fazer com que essa história seja contada com orgulho."
        </p>
    </section>

    
    <section class="trajetoria-section section-wrap">
        <div class="eyebrow">Trajetória</div>
        <h2 class="section-title">Uma carreira construída fio a fio</h2>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-year">2005</div>
                <div class="timeline-title">O primeiro corte</div>
                <p class="timeline-desc">
                    Começou como assistente em um salão de bairro, aprendendo lavagem, escova e o valor de ouvir
                    cada cliente.
                </p>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2010</div>
                <div class="timeline-title">Especialização em coloração</div>
                <p class="timeline-desc">
                    Mergulhou no universo da colorimetria: correção de cor, loiros complexos e vermelhos vibrantes.
                </p>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2015</div>
                <div class="timeline-title">Nasce o Sempre Diva</div>
                <p class="timeline-desc">
                    Abriu seu próprio salão, com atendimento cuidadoso, moderno e totalmente personalizado.
                </p>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2020</div>
                <div class="timeline-title">Cortes e visagismo</div>
                <p class="timeline-desc">
                    Formação em visagismo para desenhar cortes que conversam com o rosto e a personalidade de cada
                    mulher.
                </p>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">Hoje</div>
                <div class="timeline-title">Referência em autoestima</div>
                <p class="timeline-desc">
                    Mais de 4 mil atendimentos e uma missão simples: transformar beleza em confiança.
                </p>
            </div>
        </div>
    </section>

   
    <section class="certifications">
        <div class="section-wrap">
            <div class="eyebrow">Certificações</div>
            <h2 class="section-title mb-4">Certificados &amp; especializações</h2>

            <div class="cert-grid">
                <div class="cert-card">
                    <img src="{{ asset('images/certificado-1.jpg') }}" alt="Certificado de especialização 1">
                </div>
                <div class="cert-card">
                    <img src="{{ asset('images/certificado-2.jpg') }}" alt="Certificado de especialização 2">
                </div>
                <div class="cert-card">
                    <img src="{{ asset('images/certificado-3.jpg') }}" alt="Certificado de especialização 3">
                </div>
                <div class="cert-card">
                    <img src="{{ asset('images/certificado-4.jpg') }}" alt="Certificado de especialização 4">
                </div>
                <div class="cert-card">
                    <img src="{{ asset('images/certificado-5.jpg') }}" alt="Certificado de especialização 5">
                </div>
                <div class="cert-card">
                    <img src="{{ asset('images/certificado-6.jpg') }}" alt="Certificado de especialização 6">
                </div>
            </div>
        </div>
    </section>

    
    <section class="cta-section section-wrap">
        <div class="cta-banner">
            <h2>Vamos cuidar do seu cabelo?</h2>
            <p>Agende um horário no Salão Sempre Diva e viva uma experiência feita sob medida para você.</p>

            <div class="cta-actions">
                <button class="btn-cta" type="button">
                    <svg class="icon icon-sm" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.362 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                    </svg>
                    (15) 98180-7270
                </button>

                <button class="btn-cta" type="button">
                    <svg class="icon icon-sm" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="2" y="2" width="20" height="20" rx="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                    @salaosemprediva
                </button>
            </div>
        </div>
    </section>

    @include('components.footer')

@endsection