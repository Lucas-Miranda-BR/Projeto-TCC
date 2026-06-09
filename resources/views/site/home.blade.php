@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

<section class="hero">

    <div class="overlay"></div>

    <nav class="navbar">

        <div></div>

        <div class="menu-right">

            <a href="{{ route('site.sobre') }}" class="btn-about">
                Sobre Mim
            </a>

            <a href="{{ route('auth.login') }}" class="btn-profile">

                <img src="{{ asset('images/perfil.png') }}" alt="Perfil">

            </a>

        </div>

    </nav>

    <div class="hero-content">

        <h1>Salão Sempre Diva</h1>

        <p>Salão de beleza de Sandra Nerys</p>

        <a href="{{ route('site.sobre') }}" class="btn-main">
            Ver mais
        </a>

    </div>

</section>

@endsection