@extends('layouts.app')

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Jost:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/servicos.css') }}">
@endpush

@section('content')

    @include('components.navbar')

   
    <section class="banner-servicos">
        <div class="banner-conteudo">

            <div class="banner-imagem">
                <img src="{{ asset('images/ChatGPT Image 20 de ago. de 2026, 01_13_21.png') }}" alt="Salão Sempre Diva - Sandra Nerys">
            </div>

            <div class="banner-texto">
                <h1 class="banner-titulo">
                    Beleza que<br>realça sua essência.
                </h1>

                <p class="banner-descricao">
                    Serviços de beleza com excelência, cuidado e autoestima.
                </p>

                <div class="banner-acoes">
                    <a href="{{ route('site.produtos') }}" class="btn-banner btn-banner-solido">
                        Confira nossos produtos
                    </a>

                    <a href="{{ route('agendamento.agendar') }}" class="btn-banner btn-banner-outline">
                        Agendar agora
                    </a>
                </div>
            </div>

        </div>
    </section>

    <section class="servicos-section">

        <h2 class="titulo-servicos">Serviços</h2>

        <div class="servicos">

            <div class="card">
                <div class="imagem-container">
                    <img src="{{ asset('images/depilacao.png') }}" alt="Depilação">
                </div>

                <div class="card-conteudo">
                    <p class="categoria">Depilação</p>
                    <h3>Depilação</h3>
                    <p class="descricao">Depilação com cera quente para pele lisa e duradoura.</p>

                    <div class="rodape-card">
                        <div>
                            <p class="preco-principal">A partir de R$20</p>
                            <p class="tempo-principal">40 min</p>
                        </div>


                    </div>
                </div>
            </div>

            <div class="card">
                <div class="imagem-container">
                    <img src="{{ asset('images/manicure.png') }}" alt="Manicure">
                </div>

                <div class="card-conteudo">
                    <p class="categoria">Manicure &amp; Pedicure</p>
                    <h3>Manicure</h3>
                    <p class="descricao">Cutilagem cuidadosa e esmaltação tradicional ou em gel.</p>

                    <div class="rodape-card">
                        <div>
                            <p class="preco-principal">A partir de R$45</p>
                            <p class="tempo-principal">45 min</p>
                        </div>


                    </div>
                </div>
            </div>

            <div class="card">
                <div class="imagem-container">
                    <img src="{{ asset('images/trabalho1.png') }}" alt="Corte">
                </div>

                <div class="card-conteudo">
                    <p class="categoria">Corte de cabelo</p>
                    <h3>Corte</h3>
                    <p class="descricao">Corte personalizado para valorizar seu estilo.</p>

                    <div class="rodape-card">
                        <div>
                            <p class="preco-principal">A partir de R$150</p>
                            <p class="tempo-principal">60 min</p>
                        </div>


                    </div>
                </div>
            </div>

        </div>

        <section class="cta-final">
            <h2>Em dúvida sobre o visual?</h2>

            <p class="cta-descricao">
                Simule seu corte, cor ou unha com nossa IA e depois marque seu horário.
            </p>

            <div class="cta-acoes">
                <a href="{{ route('site.ia') }}" class="btn-ghost-brand">
                    Simular meu look
                </a>

                <a href="{{ route('agendamento.agendar') }}" class="btn-ghost-brand">
                    Agendar agora
                </a>
            </div>
        </section>

    </section>

    @include('components.footer')

@endsection