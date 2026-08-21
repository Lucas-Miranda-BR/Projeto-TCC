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

            <form action="{{route('cliente.create')}}" method="post">

            @csrf
                <div class="form-row">
                <label for="nome">Nome</label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="{{ old('nome') }}"
                        required
                        autocomplete="off"  
                    >
                    <label for="sobrenome">Sobrenome</label>
                    <input
                        type="text"
                        id="sobrenome"
                        name="sobrenome"
                        value="{{ old('sobrenome') }}"
                        required
                        autocomplete="off"  
                    >

                </div>

                <div class="form-row">
                <label for="email">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="off"  
                    >
                    <label for="telefone">Telefone</label>
                    <input
                        type="tel"
                        pattern='[0-9]{11}'
                        id="telefone"
                        name="telefone"
                        value="{{ old('telefone') }}"
                        autocomplete="off"  
                    >

                    <label for="cpf">CPF</label>
                    <input
                        type="number"
                        minlenght="11"
                        maxlenght="11"
                        id="cpf"
                        name="cpf"
                        required
                        value="{{ old('cpf') }}"
                        autocomplete="off"     
                    >

                </div>

                <div class="form-row">

                <!-- <label for="endereco">Endereço</label>
                    <input
                        type="text"
                        id="endereco"
                        name="endereco"
                        required
                        value="{{ old('endereco') }}"
                        autocomplete="off"                    
                        >

                        <label for="cep">CEP</label>
                    <input
                        type="number"
                        minlenght="8"
                        maxlenght="8"
                        id="cep"
                        name="cep"
                        required
                        value="{{ old('cep') }}"
                        autocomplete="off"     
                    > -->

                    <label for="data_nascimento">Data de Nascimento</label>
                    <input
                    placeholder="Data Nascimento"
                        type="date"
                        id="data_nascimento"
                        name="data_nascimento"
                        required
                        value="{{ old('data_nascimento') }}"
                        autocomplete="off"
                    >

                </div>

                <div class="form-row">
                <label for="senha">Senha</label>
                    <input
                        type="password"
                        name="senha"
                        id="senha"
                        required
                        value="{{ old('senha') }}"
                        autocomplete="off"
                    >

                </div>

                <button type="submit">
                    Criar Conta
                </button>

            </form>

        </div>

    </div>

</div>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@include('components.footer')

@endsection