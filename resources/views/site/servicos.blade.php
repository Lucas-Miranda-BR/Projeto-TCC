@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/servicos.css') }}">
@endpush

@section('content')

<nav class="navbar">

    <img src="{{ asset('images/logo.png') }}" class="logo">

    <ul>
        <li><a href="{{ route('site.home') }}">Início</a></li>
        <li><a href="{{ route('site.sobre') }}">Sobre Mim</a></li>
        <li><a href="#">Produtos</a></li>
        <li><a href="#">IA</a></li>
        <li><a href="#">Notificações</a></li>
    </ul>

</nav>

<section class="banner">

    <img src="{{ asset('images/banner.jpg') }}">

</section>

<section class="servicos">

    <div class="card">
        <img src="{{ asset('images/depilacao.jpg') }}">
        <h3>Depilação</h3>
        <p>A partir de R$20</p>
        <a href="{{ route('cliente.agendamentos') }}">Agendar</a>
    </div>

    <div class="card">
        <img src="{{ asset('images/manicure.jpg') }}">
        <h3>Manicure</h3>
        <p>A partir de R$45</p>
        <a href="{{ route('cliente.agendamentos') }}">Agendar</a>
    </div>

    <div class="card">
        <img src="{{ asset('images/corte.jpg') }}">
        <h3>Corte</h3>
        <p>A partir de R$150</p>
        <a href="{{ route('cliente.agendamentos') }}">Agendar</a>
    </div>

</section>

<section class="agendar">

    <h2>FAÇA SEU AGENDAMENTO AGORA</h2>

    <a href="{{ route('cliente.agendamentos') }}" class="btn-agendar">
        AGENDAR
    </a>

</section>

@endsection