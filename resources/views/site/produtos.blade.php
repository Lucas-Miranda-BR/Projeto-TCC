@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/produtos.css') }}">
@endpush

@section('content')

@include('components.navbar')

<section class="banner-produtos">

    <img src="{{ asset('images/banner-produtos.png') }}">

</section>

<section class="produtos-container">

    @for($i = 1; $i <= 20; $i++)

    <div class="produto-card">

        <img src="{{ asset('images/produto.png') }}">

        <h3>Produto {{ $i }}</h3>

        <p>R$ 49,90</p>

        <button>Comprar</button>

    </div>

    @endfor

</section>

@include('components.footer')

@endsection