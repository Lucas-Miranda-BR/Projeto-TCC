@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/sobre.css') }}">
@endpush

@section('content')

<nav class="navbar">

    <img src="{{ asset('images/logo.png') }}" class="logo">

    <ul>

        <li><a href="{{ route('site.home') }}">Início</a></li>

        <li><a href="#">Produtos</a></li>

        <li><a href="#">IA</a></li>

        <li><a href="#">Notificações</a></li>

        <li><a href="{{ route('site.servicos') }}">Serviços</a></li>

    </ul>

</nav>

<section class="galeria">

    <img src="{{ asset('images/trabalho1.jpg') }}">

    <img src="{{ asset('images/trabalho2.jpg') }}">

    <img src="{{ asset('images/trabalho3.jpg') }}">

</section>

<section class="sobre">

    <h2>QUEM SOU?</h2>

    <div class="sobre-content">

        <div class="nome">

            Sandra<br>Nerys

        </div>

        <div class="texto">

            <p>
                Sandra Nerys é especialista em embelezamento
                e apaixonada por elevar a autoestima de suas clientes.
            </p>

            <p>
                Proprietária do Salão Sempre Diva desde 2015.
            </p>

            <p>
                Com dedicação e profissionalismo transforma
                beleza em confiança.
            </p>

        </div>

    </div>

</section>

@endsection