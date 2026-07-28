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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:18px;">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cliente.salvarCadastro') }}" method="POST">

                @csrf

                <div class="form-row">

                    <input
                        type="text"
                        name="nome"
                        placeholder="Nome"
                        value="{{ old('nome') }}"
                        required
                    >

                    <input
                        type="text"
                        name="sobrenome"
                        placeholder="Sobrenome"
                        value="{{ old('sobrenome') }}"
                        required
                    >

                </div>

                <div class="form-row">

                    <input
                        type="email"
                        name="email"
                        placeholder="E-mail"
                        value="{{ old('email') }}"
                        required
                    >

                    <input
                        type="tel"
                        name="telefone"
                        placeholder="Telefone"
                        value="{{ old('telefone') }}"
                        required
                    >

                    <input
                        type="text"
                        name="cpf"
                        placeholder="CPF"
                        value="{{ old('cpf') }}"
                        required
                    >

                </div>

                <div class="form-row">

                    <input
                        type="text"
                        name="endereco"
                        placeholder="Endereço"
                        value="{{ old('endereco') }}"
                        required
                    >

                    <label for="data_nascimento">
                        Data de Nascimento
                    </label>

                    <input
                        type="date"
                        id="data_nascimento"
                        name="data_nascimento"
                        value="{{ old('data_nascimento') }}"
                        required
                    >

                </div>

                {{-- Ajuste os IDs conforme existirem no seu banco --}}
                <input type="hidden" name="estado_id" value="1">
                <input type="hidden" name="cidade_id" value="1">

                <div class="form-row">

                    <input
                        type="password"
                        name="senha"
                        placeholder="Senha"
                        required
                    >

                    <input
                        type="password"
                        name="senha_confirmation"
                        placeholder="Confirmar Senha"
                        required
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