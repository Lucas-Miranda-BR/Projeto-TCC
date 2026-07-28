@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')

@include('components.navbar')

<div class="login-page">

    <div class="left-panel">

        <div class="overlay"></div>

        <div class="left-content">

            <img src="{{ asset('images/logo.png') }}" class="logo-login">

            <h1>
                Sua Jornada de
                <span>Beleza e Poder</span>
                Começa Aqui
            </h1>

            <p>
                Acesse sua conta e agende seus serviços
                com praticidade e segurança.
            </p>

        </div>

    </div>

    <div class="right-panel">

        <div class="login-box">

            <h2>Faça seu Login</h2>

            @if(session('sucesso'))
                <div class="alert alert-success">
                    {{ session('sucesso') }}
                </div>
            @endif

            @if(session('erro'))
                <div class="alert alert-danger">
                    {{ session('erro') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:18px;">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cliente.entrar') }}" method="POST">

                @csrf

                <input
                    type="email"
                    name="email"
                    placeholder="Digite seu e-mail"
                    value="{{ old('email') }}"
                    required
                >

                <input
                    type="password"
                    name="senha"
                    placeholder="Digite sua senha"
                    required
                >

                <button type="submit">
                    Entrar
                </button>

            </form>

            <div class="divider">
                ou
            </div>

            <a href="{{ route('cliente.cadastro') }}" class="btn-secondary">
                Criar Conta
            </a>

        </div>

    </div>

</div>

@include('components.footer')

@endsection