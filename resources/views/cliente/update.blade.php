@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/update-cliente.css') }}">
@endpush

@section('content')

@include('components.navbar')

<div class="update-page">

    <section class="update-left">

        <div class="update-overlay"></div>

        <div class="update-left-content">

            <img
                src="{{ asset('images/logo.png') }}"
                alt="Salão Sempre Diva"
                class="update-logo"
            >

            <h1>
                Seu Estilo,
                <span>Seus Detalhes</span>
                Sempre em Você
            </h1>

            <p>
                Atualize suas informações e mantenha
                seu perfil sempre do seu jeito.
            </p>

        </div>

    </section>


    <section class="update-right">

        <div class="update-card">

            <div class="update-header">

                <span>MINHA CONTA</span>

                <h2>Editar Perfil</h2>

                <p>
                    Atualize suas informações pessoais abaixo.
                </p>

            </div>


            @if ($errors->any())

                <div class="update-errors">

                    @foreach ($errors->all() as $erro)

                        <p>{{ $erro }}</p>

                    @endforeach

                </div>

            @endif


            <form
                action="{{ route('cliente.perfil.update') }}"
                method="POST"
            >

                @csrf
                @method('PUT')


                <div class="update-grid">

                    <div class="update-field">

                        <label for="nome">
                            Nome
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            value="{{ old('nome', $cliente->nome) }}"
                            required
                        >

                    </div>


                    <div class="update-field">

                        <label for="sobrenome">
                            Sobrenome
                        </label>

                        <input
                            type="text"
                            id="sobrenome"
                            name="sobrenome"
                            value="{{ old('sobrenome', $cliente->sobrenome) }}"
                            required
                        >

                    </div>

                </div>


                <div class="update-field">

                    <label for="cpf">
                        CPF
                    </label>

                    <input
                        type="text"
                        id="cpf"
                        name="cpf"
                        maxlength="11"
                        value="{{ old('cpf', $cliente->cpf) }}"
                    >

                </div>


                <div class="update-grid">

                    <div class="update-field">

                        <label for="telefone">
                            Telefone
                        </label>

                        <input
                            type="text"
                            id="telefone"
                            name="telefone"
                            maxlength="11"
                            value="{{ old('telefone', $cliente->telefone) }}"
                        >

                    </div>


                    <div class="update-field">

                        <label for="data_nascimento">
                            Data de nascimento
                        </label>

                        <input
                            type="date"
                            id="data_nascimento"
                            name="data_nascimento"
                            value="{{ old(
                                'data_nascimento',
                                $cliente->data_nascimento
                                    ? $cliente->data_nascimento->format('Y-m-d')
                                    : ''
                            ) }}"
                            required
                        >

                    </div>

                </div>


                <div class="update-field">

                    <label for="email">
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $cliente->email) }}"
                    >

                </div>


                <div class="update-security">

                    <div>

                        <span>
                            SEGURANÇA
                        </span>

                        <h3>
                            Alterar senha
                        </h3>

                    </div>

                    <small>
                        Opcional
                    </small>

                </div>


                <div class="update-field">

                    <label for="senha">
                        Nova senha
                    </label>

                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        placeholder="Deixe em branco para manter a senha atual"
                    >

                </div>


                <div class="update-actions">

                    <a
                        href="{{ route('cliente.perfil') }}"
                        class="update-back"
                    >
                        Voltar
                    </a>

                    <button
                        type="submit"
                        class="update-save"
                    >
                        Salvar alterações
                    </button>

                </div>

            </form>

        </div>

    </section>

</div>

@include('components.footer')

@endsection