@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/servicos.css') }}">
@endpush

@section('content')

@include('components.navbar')

<section class="banner">

    <img src="{{ asset('images/salao.png') }}">

</section>

<section class="servicos">

    <div class="card">
        <img src="{{ asset('images/depilacao.png') }}">
        <h3>Depilação</h3>
        <p>A partir de R$20</p>
        <a href="{{ route('cliente.agendamentos') }}">Agendar</a>
    </div>

    <div class="card">
        <img src="{{ asset('images/manicure.png') }}">
        <h3>Manicure</h3>
        <p>A partir de R$45</p>
        <a href="{{ route('cliente.agendamentos') }}">Agendar</a>
    </div>

    <div class="card">
        <img src="{{ asset('images/trabalho1.png') }}">
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

@include('components.footer')

@endsection