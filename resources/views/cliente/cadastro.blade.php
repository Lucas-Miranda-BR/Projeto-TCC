@extends('layouts.app')

@push('css')

<link
    rel="stylesheet"
    href="{{ asset('css/cadastro.css') }}"
>

@endpush


@section('content')


@include('components.navbar')


<div class="cadastro-page">

    <div class="left-panel">

        <div class="overlay"></div>

        <div class="left-content">

            <img
                src="{{ asset('images/logo.png') }}"
                alt="Salão Sempre Diva"
                class="logo-login"
            >

            <h1>
                Sua Jornada de

                <span>
                    Beleza e Poder
                </span>

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

            <h2>
                Crie sua Conta
            </h2>

            <p class="cadastro-subtitulo">
                Preencha seus dados para começar.
            </p>


            <div class="cadastro-aviso">

                <i class="bi bi-info-circle-fill"></i>

                <div>

                    <strong>
                        Importante
                    </strong>

                    <p>
                        O CPF é necessário para identificar sua conta
                        e será solicitado para finalizar compras.
                    </p>

                </div>

            </div>


            @if($errors->any())

                <div class="cadastro-errors">

                    <i class="bi bi-exclamation-circle"></i>

                    <div>

                        @foreach($errors->all() as $error)

                            <p>
                                {{ $error }}
                            </p>

                        @endforeach

                    </div>

                </div>

            @endif


            <form
                action="{{ route('cliente.create') }}"
                method="POST"
            >

                @csrf


                <div class="form-row">

                    <div class="form-group">

                        <label for="nome">
                            Nome
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            value="{{ old('nome') }}"
                            required
                            autocomplete="given-name"
                        >

                    </div>


                    <div class="form-group">

                        <label for="sobrenome">
                            Sobrenome
                        </label>

                        <input
                            type="text"
                            id="sobrenome"
                            name="sobrenome"
                            value="{{ old('sobrenome') }}"
                            required
                            autocomplete="family-name"
                        >

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label for="cpf">
                            CPF
                        </label>

                        <input
                            type="text"
                            id="cpf"
                            name="cpf"
                            value="{{ old('cpf') }}"
                            maxlength="11"
                            minlength="11"
                            pattern="[0-9]{11}"
                            inputmode="numeric"
                            placeholder="Digite os 11 números"
                            required
                            autocomplete="off"
                        >

                    </div>


                    <div class="form-group">

                        <label for="data_nascimento">
                            Data de Nascimento
                        </label>

                        <input
                            type="date"
                            id="data_nascimento"
                            name="data_nascimento"
                            value="{{ old('data_nascimento') }}"
                            required
                            autocomplete="bday"
                        >

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label for="email">
                            E-mail
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            placeholder="Opcional se preencher o telefone"
                        >

                    </div>


                    <div class="form-group">

                        <label for="telefone">
                            Telefone
                        </label>

                        <input
                            type="tel"
                            id="telefone"
                            name="telefone"
                            value="{{ old('telefone') }}"
                            pattern="[0-9]{11}"
                            maxlength="11"
                            minlength="11"
                            inputmode="numeric"
                            autocomplete="tel"
                            placeholder="Opcional se preencher o e-mail"
                        >

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group form-group-full">

                        <label for="senha">
                            Senha
                        </label>

                        <input
                            type="password"
                            id="senha"
                            name="senha"
                            required
                            autocomplete="new-password"
                        >

                    </div>

                </div>


                <button
                    type="submit"
                    class="btn-criar-conta"
                >

                    <i class="bi bi-person-plus"></i>

                    Criar Conta

                </button>

            </form>


            <div class="cadastro-acoes">

                <a
                    href="{{ route('home') }}"
                    class="btn-cadastro-voltar"
                >

                    <i class="bi bi-arrow-left"></i>

                    Voltar

                </a>


                @guest

                    <a
                        href="{{ route('cliente.login') }}"
                        class="btn-cadastro-login"
                    >

                        <i class="bi bi-box-arrow-in-right"></i>

                        Já tenho uma conta

                    </a>

                @endguest


                @auth

                    <a
                        href="{{ route('cliente.logout') }}"
                        class="btn-cadastro-logout"
                    >

                        <i class="bi bi-box-arrow-right"></i>

                        Sair

                    </a>

                @endauth

            </div>

        </div>

    </div>

</div>


@include('components.footer')


@endsection