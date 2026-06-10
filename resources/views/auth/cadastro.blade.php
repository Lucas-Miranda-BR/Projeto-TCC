@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/cadastro.css') }}">
@endpush

@section('content')

@include('components.navbar')

<div class="cadastro-page">

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
                Crie sua conta para agendar horários,
                acompanhar serviços e receber novidades.
            </p>

        </div>

    </div>

    <div class="right-panel">

        <div class="cadastro-box">

            <h2>Crie sua Conta</h2>

            <form>

                <div class="form-row">

                    <input
                        type="text"
                        placeholder="Nome"
                    >

                    <input
                        type="text"
                        placeholder="Sobrenome"
                    >

                </div>

                <div class="form-row">

                    <input
                        type="email"
                        placeholder="E-mail"
                    >

                    <input
                        type="text"
                        placeholder="Telefone"
                    >

                </div>

                <div class="form-row">

                    <input
                        type="text"
                        placeholder="Cidade"
                    >

                    <input
                        type="text"
                        placeholder="Estado"
                    >

                </div>

                <div class="form-row">

                    <input
                        type="password"
                        placeholder="Senha"
                    >

                    <input
                        type="password"
                        placeholder="Confirmar Senha"
                    >

                </div>

                <button type="submit">
                    Criar Conta
                </button>

            </form>

        </div>

    </div>

</div>

@include('components.footer')

@endsection