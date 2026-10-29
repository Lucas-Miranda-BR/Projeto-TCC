@extends('layouts.app')

@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
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

            <form method="post" action="{{ route('cliente.auth') }}">

                @csrf

                <label for="auth">E-mail ou Telefone</label>
                <input
                    type="text"
                    name="auth"
                    id="auth"
                    placeholder="Digite seu e-mail ou telefone"
                    value="{{ old('auth') }}"
                    autocomplete="off"
                    required
                >

                <label for="senha">Senha</label>
                <input
                    type="password"
                    name="senha"
                    id="senha"
                    autocomplete="off"
                    required
                >

                <button type="submit">
                    Entrar
                </button>

            </form>

            @if (session('erro'))
                <div class="alert-error">
                    {{ session('erro') }}
                </div>
            @endif

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