@extends('layouts.app')


@push('css')

<link
    rel="stylesheet"
    href="{{ asset('css/cliente/editar-perfil.css') }}"
>

@endpush


@section('content')


@include('components.navbar')


<main class="edit-profile-page">


    <div class="edit-profile-heading">

        <h1>
            Editar perfil
        </h1>

        <p>
            Mantenha seus dados atualizados para facilitar seus atendimentos.
        </p>

    </div>


    <section class="edit-profile-card">


        <div class="profile-card-cover"></div>


        <div class="profile-card-content">


            <div class="edit-profile-avatar">

                <i class="bi bi-person-fill"></i>

            </div>


            <div class="profile-identification">

                <h2>
                    {{ $cliente->nome }}
                    {{ $cliente->sobrenome }}
                </h2>

                <span>
                    CLIENTE SANDRA NERYS
                </span>

            </div>


            @if(session('success'))

                <div class="profile-success">

                    <i class="bi bi-check-circle-fill"></i>

                    {{ session('success') }}

                </div>

            @endif


            @if($errors->any())

                <div class="profile-errors">

                    <strong>
                        Verifique os campos abaixo:
                    </strong>

                    <ul>

                        @foreach($errors->all() as $erro)

                            <li>
                                {{ $erro }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('cliente.perfil.update') }}"
                method="POST"
                class="edit-profile-form"
            >

                @csrf
                @method('PUT')


                <div class="form-section-title">

                    <span>
                        DADOS PESSOAIS
                    </span>

                </div>


                <div class="profile-form-grid">


                    <div class="profile-field">

                        <label for="nome">

                            <i class="bi bi-person"></i>

                            NOME

                        </label>

                        <input
                            type="text"
                            name="nome"
                            id="nome"
                            value="{{ old('nome', $cliente->nome) }}"
                            required
                        >

                    </div>


                    <div class="profile-field">

                        <label for="sobrenome">

                            <i class="bi bi-person"></i>

                            SOBRENOME

                        </label>

                        <input
                            type="text"
                            name="sobrenome"
                            id="sobrenome"
                            value="{{ old('sobrenome', $cliente->sobrenome) }}"
                            required
                        >

                    </div>


                    <div class="profile-field">

                        <label for="email">

                            <i class="bi bi-envelope"></i>

                            E-MAIL

                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $cliente->email) }}"
                            placeholder="cliente@email.com"
                        >

                    </div>


                    <div class="profile-field">

                        <label for="telefone">

                            <i class="bi bi-telephone"></i>

                            TELEFONE

                        </label>

                        <input
                            type="text"
                            name="telefone"
                            id="telefone"
                            value="{{ old('telefone', $cliente->telefone) }}"
                            placeholder="(15) 99999-9999"
                        >

                    </div>


                    <div class="profile-field">

                        <label for="data_nascimento">

                            <i class="bi bi-calendar3"></i>

                            DATA DE NASCIMENTO

                        </label>

                        <input
                            type="date"
                            name="data_nascimento"
                            id="data_nascimento"
                            value="{{ old(
                                'data_nascimento',
                                optional($cliente->data_nascimento)->format('Y-m-d')
                            ) }}"
                            required
                        >

                    </div>


                    <div class="profile-field profile-field-readonly">

                        <label>

                            <i class="bi bi-card-text"></i>

                            CPF

                        </label>

                        <input
                            type="text"
                            value="{{ $cliente->cpf }}"
                            readonly
                        >

                    </div>


                </div>


                <div class="form-section-title">

                    <span>
                        ENDEREÇO
                    </span>

                </div>


                <div class="profile-form-grid">


                    <div class="profile-field">

                        <label for="cep">

                            <i class="bi bi-geo-alt"></i>

                            CEP

                        </label>

                        <input
                            type="text"
                            name="cep"
                            id="cep"
                            value="{{ old('cep', $cliente->cep) }}"
                            placeholder="00000-000"
                        >

                    </div>


                    <div class="profile-field">

                        <label for="endereco">

                            <i class="bi bi-house"></i>

                            ENDEREÇO

                        </label>

                        <input
                            type="text"
                            name="endereco"
                            id="endereco"
                            value="{{ old('endereco', $cliente->endereco) }}"
                            placeholder="Rua, número..."
                        >

                    </div>


                </div>


                <div class="profile-form-actions">


                    <a
                        href="{{ route('cliente.perfil') }}"
                        class="btn-profile-cancel"
                    >

                        Cancelar

                    </a>


                    <button
                        type="submit"
                        class="btn-profile-save"
                    >

                        <i class="bi bi-check-lg"></i>

                        Salvar alterações

                    </button>


                </div>


            </form>


        </div>


    </section>


</main>


@include('components.footer')


@endsection