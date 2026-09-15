@extends('layouts.app')

@push('css')
<link
    rel="stylesheet"
    href="{{ asset('css/perfil.css') }}"
>
@endpush

@section('content')

<div class="perfil-page">

    <section class="perfil-visual">

        <div class="decor decor-1"></div>
        <div class="decor decor-2"></div>

        <div class="perfil-brand">

            <img
                src="{{ asset('images/logo.png') }}"
                alt="Salão Sempre Diva"
                class="perfil-logo"
            >

            <span class="brand-small">
                SALÃO SEMPRE DIVA
            </span>

            <h1>
                Sua Jornada de Beleza e Poder

                <strong>
                    Começa Aqui
                </strong>
            </h1>

            <div class="brand-divider"></div>

            <h2>
                Sandra Nerys
            </h2>

            <p>
                Beleza, cuidado e autoestima.
            </p>

        </div>

    </section>


    <section class="perfil-content">

        <div class="perfil-box">

            <header class="perfil-header">

                <span class="perfil-subtitle">
                    MINHA CONTA
                </span>

                <h2>
                    Meu perfil
                </h2>

                <p>
                    Confira suas informações cadastradas.
                </p>

            </header>


            @if(session('success'))

                <div class="alert-success">

                    {{ session('success') }}

                </div>

            @endif


            <div class="perfil-nome">

                <div class="avatar">

                    {{
                        strtoupper(
                            substr($cliente->nome ?? '', 0, 1) .
                            substr($cliente->sobrenome ?? '', 0, 1)
                        )
                    }}

                </div>

                <div>

                    <h3>
                        {{ $cliente->nome }}
                        {{ $cliente->sobrenome }}
                    </h3>

                    <p>
                        {{
                            $cliente->email
                                ?? $cliente->telefone
                                ?? 'Contato não informado'
                        }}
                    </p>

                </div>

            </div>


            <div class="perfil-divider"></div>


            <div class="dados-grid">


                <div class="dado">

                    <span>
                        Nome
                    </span>

                    <strong>
                        {{ $cliente->nome }}
                    </strong>

                </div>


                <div class="dado">

                    <span>
                        Sobrenome
                    </span>

                    <strong>
                        {{ $cliente->sobrenome }}
                    </strong>

                </div>


                <div class="dado">

                    <span>
                        CPF
                    </span>

                    @if(empty($cliente->cpf))

                        <strong class="dado-pendente">
                            Não informado
                        </strong>

                        <small class="dado-aviso">
                            Informe seu CPF para finalizar compras.
                        </small>

                    @else

                        <strong>
                            {{ $cliente->cpf }}
                        </strong>

                    @endif

                </div>


                <div class="dado">

                    <span>
                        Telefone
                    </span>

                    <strong>
                        {{ $cliente->telefone ?? 'Não informado' }}
                    </strong>

                </div>


                <div class="dado dado-full">

                    <span>
                        E-mail
                    </span>

                    <strong>
                        {{ $cliente->email ?? 'Não informado' }}
                    </strong>

                </div>


                <div class="dado dado-full">

                    <span>
                        Data de nascimento
                    </span>

                    <strong>

                        {{
                            $cliente->data_nascimento
                                ? date(
                                    'd/m/Y',
                                    strtotime($cliente->data_nascimento)
                                )
                                : 'Não informado'
                        }}

                    </strong>

                </div>

            </div>


            <div class="perfil-actions">

                <a
                    href="{{ route('site.sobre') }}"
                    class="btn-voltar"
                >
                    Voltar
                </a>

                <a
                    href="{{ route('cliente.perfil.editar') }}"
                    class="btn-editar"
                >
                    Editar perfil
                </a>

            </div>

        </div>

    </section>

</div>

@endsection