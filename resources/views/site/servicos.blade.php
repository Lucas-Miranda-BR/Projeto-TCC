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
    </div>

    <div class="card">
        <img src="{{ asset('images/manicure.png') }}">
        <h3>Manicure</h3>
        <p>A partir de R$45</p>
    </div>

    <div class="card">
        <img src="{{ asset('images/trabalho1.png') }}">
        <h3>Corte</h3>
        <p>A partir de R$150</p>
    </div>

</section>

<section class="agendar">

    <h2>AGENDE AGORA</h2>

    <a href="{{ route('agendamento.agendar') }}" class="btn-agendar">
        AGENDAR
    </a>

</section>

@include('components.footer')

@endsection