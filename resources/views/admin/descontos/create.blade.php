@extends('layouts.app')

@push('css')

<link
    rel="stylesheet"
    href="{{ asset('css/admin/dashboard.css') }}"
>

<link
    rel="stylesheet"
    href="{{ asset('css/admin/descontos.css') }}"
>

@endpush

@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')


        <main class="descontos-content">


            <div class="descontos-header">

                <div>

                    <span class="breadcrumb-admin">

                        Painel >

                        Descontos >

                        <strong>
                            Novo desconto
                        </strong>

                    </span>


                    <h1>
                        Criar Novo Desconto
                    </h1>


                    <p>
                        Configure uma nova regra de desconto.
                    </p>

                </div>


                <a
                    href="{{ route('admin.descontos.index') }}"
                    class="btn-voltar-descontos"
                >

                    <i class="bi bi-arrow-left"></i>

                    Voltar para descontos

                </a>

            </div>


            @if($errors->any())

                <div class="desconto-alert desconto-alert-error">

                    <div class="desconto-alert-title">

                        <i class="bi bi-exclamation-circle"></i>

                        Verifique os dados informados.

                    </div>


                    <ul>

                        @foreach($errors->all() as $erro)

                            <li>
                                {{ $erro }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            @if(session('erro'))

                <div class="desconto-alert desconto-alert-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ session('erro') }}

                </div>

            @endif


            <form
                action="{{ route('admin.descontos.store') }}"
                method="POST"
                class="desconto-form"
            >

                @csrf


                <section class="desconto-form-card">

                    <div class="desconto-form-card-header">

                        <div class="desconto-section-icon">
                            <i class="bi bi-tag"></i>
                        </div>

                        <div>

                            <h2>
                                Informações do desconto
                            </h2>

                            <p>
                                Defina o nome, valor e período da promoção.
                            </p>

                        </div>

                    </div>


                    <div class="desconto-form-grid">


                        <div class="form-group-desconto form-group-full">

                            <label for="nome">
                                Nome do Desconto
                            </label>

                            <input
                                type="text"
                                name="nome"
                                id="nome"
                                value="{{ old('nome') }}"
                                placeholder="Ex.: Black Friday"
                                required
                            >

                        </div>


                        <div class="form-group-desconto">

                            <label for="valor">
                                Valor do Desconto (%)
                            </label>

                            <div class="input-percentual">

                                <input
                                    type="number"
                                    step="0.01"
                                    name="valor"
                                    id="valor"
                                    value="{{ old('valor') }}"
                                    placeholder="10"
                                    required
                                >

                                <span>
                                    %
                                </span>

                            </div>

                        </div>


                        <div class="form-group-desconto">

                            <label for="quando_terminar">
                                Termina em
                            </label>

                            <input
                                type="date"
                                name="quando_terminar"
                                id="quando_terminar"
                                min="{{ \Carbon\Carbon::today()->toDateString() }}"
                                value="{{ old('quando_terminar', '') }}"
                            >

                            <small>
                                Deixe em branco se o desconto for permanente (sem data de expiração).
                            </small>

                        </div>


                    </div>

                </section>


                <section class="desconto-form-card">

                    <div class="desconto-form-card-header">

                        <div class="desconto-section-icon">
                            <i class="bi bi-diagram-3"></i>
                        </div>

                        <div>

                            <h2>
                                Agrupamentos
                            </h2>

                            <p>
                                Escolha onde o desconto será aplicado.
                            </p>

                        </div>

                    </div>


                    <div class="desconto-selecao-grid">


                        <div class="desconto-selecao">

                            <label for="itens">
                                Aplicar a Itens Específicos
                            </label>

                            <span class="desconto-ajuda">
                                Segure CTRL para selecionar vários.
                            </span>

                            <select
                                name="itens[]"
                                id="itens"
                                multiple
                                size="5"
                            >

                                @foreach($itens as $item)

                                    <option
                                        value="{{ $item->item_id }}"
                                    >
                                        {{ $item->nome }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="desconto-selecao">

                            <label for="marcas">
                                Adicionar Itens por Marcas
                            </label>

                            <span class="desconto-ajuda">
                                Selecione uma ou mais marcas.
                            </span>

                            <select
                                name="marcas[]"
                                id="marcas"
                                multiple
                                size="5"
                            >

                                @foreach($marcas as $marca)

                                    <option
                                        value="{{ $marca->marca_id ?? $marca->id }}"
                                    >
                                        {{ $marca->nome }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="desconto-selecao">

                            <label for="categorias">
                                Adicionar Itens por Categorias
                            </label>

                            <span class="desconto-ajuda">
                                Selecione uma ou mais categorias.
                            </span>

                            <select
                                name="categorias[]"
                                id="categorias"
                                multiple
                                size="5"
                            >

                                @foreach($categorias as $categoria)

                                    <option
                                        value="{{ $categoria->categoria_id ?? $categoria->id }}"
                                    >
                                        {{ $categoria->nome }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                    </div>

                </section>


                <section class="desconto-form-card desconto-excecoes-card">

                    <div class="desconto-form-card-header">

                        <div class="desconto-section-icon desconto-section-icon-danger">
                            <i class="bi bi-shield-exclamation"></i>
                        </div>

                        <div>

                            <h2>
                                Exceções
                            </h2>

                            <p>
                                Defina os itens que não receberão este desconto.
                            </p>

                        </div>

                    </div>


                    <div class="desconto-selecao">

                        <label for="excecoes">
                            Itens que NÃO receberão este desconto
                        </label>

                        <span class="desconto-ajuda">
                            Esta seleção anula descontos aplicados por marca ou categoria.
                        </span>

                        <select
                            name="excecoes[]"
                            id="excecoes"
                            multiple
                            size="5"
                        >

                            @foreach($itens as $item)

                                <option
                                    value="{{ $item->item_id }}"
                                >
                                    {{ $item->nome }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </section>


                <div class="desconto-form-actions">

                    <a
                        href="{{ route('admin.descontos.index') }}"
                        class="btn-desconto-cancelar"
                    >
                        Cancelar
                    </a>


                    <button
                        type="submit"
                        class="btn-desconto-principal"
                    >

                        <i class="bi bi-check-lg"></i>

                        Salvar Desconto

                    </button>

                </div>


            </form>

        </main>

    </div>

</div>

@endsection