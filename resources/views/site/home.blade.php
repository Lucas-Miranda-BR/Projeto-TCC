@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

@include('components.navbar')
<section class="hero">

    <div class="overlay"></div>

    

    <div class="hero-content">

        <h1>Salão Sempre Diva</h1>

        <p>Salão de beleza de Sandra Nerys</p>

        <a href="{{ route('auth.login') }}" class="btn-main">
            Ver mais
        </a>

    </div>

</section>

@include('components.footer')

@endsection