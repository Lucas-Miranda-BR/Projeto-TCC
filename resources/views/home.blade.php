@extends('layouts.app')

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

@include('components.navbar')

<section class="hero">

    <div class="overlay"></div>

    <div class="hero-content">

        <h1>Salão Sempre Diva</h1>

        <p>Salão de beleza de Sandra Nerys</p>

        <a href="{{ route('site.sobre') }}" class="btn-main">
            Ver mais
        </a>

    </div>

</section>

@include('components.footer')

@endsection