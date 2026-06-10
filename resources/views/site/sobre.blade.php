@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/sobre.css') }}">
@endpush

@section('content')

@include('components.navbar')

</header>

<section class="galeria">

    <img src="{{ asset('images/trabalho1.png') }}">
    <img src="{{ asset('images/trabalho2.png') }}">
    <img src="{{ asset('images/trabalho3.png') }}">

</section>

<section class="quem-sou">

    <div class="titulo">
        <h2>QUEM SOU?</h2>
    </div>

    <div class="conteudo">

        <div class="nome">
            <h1>
                Sandra<br>
                Nerys
            </h1>
        </div>

        <div class="texto">

            <p>
                Sandra Nerys, 41 anos, é especialista em embelezamento e
                apaixonada por elevar a autoestima de suas clientes.
            </p>

            <p>
                Proprietária do Salão Sempre Diva desde 2015,
                onde oferece um atendimento cuidadoso,
                moderno e personalizado.
            </p>

            <p>
                Com dedicação e sensibilidade,
                Sandra transforma beleza em confiança,
                criando uma experiência única para cada mulher
                que passa pelo seu salão.
            </p>

        </div>

    </div>

</section>
<!-- DIFERENCIAIS -->

<section class="diferenciais">

    <h2>Nossos Diferenciais</h2>

    <div class="cards">

        <div class="card-dif">
            <h3>✨ Atendimento Personalizado</h3>
            <p>
                Cada cliente recebe um atendimento único,
                pensado para valorizar sua beleza natural.
            </p>
        </div>

        <div class="card-dif">
            <h3>💇 Profissional Especializada</h3>
            <p>
                Experiência e dedicação para oferecer
                resultados modernos e de qualidade.
            </p>
        </div>

        <div class="card-dif">
            <h3>❤️ Autoestima e Confiança</h3>
            <p>
                Nosso objetivo é fazer cada mulher se sentir
                bonita, segura e confiante.
            </p>
        </div>

    </div>

</section>

@include('components.footer')

@endsection