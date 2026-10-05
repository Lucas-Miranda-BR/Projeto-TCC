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
                            Editar
                        </strong>

                    </span>


                    <h1>
                        Editar Desconto
                    </h1>


                    <p>
                        Atualize as informações da regra de desconto.
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


            @php

                $isAniversario =
                    stripos(
                        $desconto->nome,
                        'aniversário'
                    ) !== false;

            @endphp


            <form
                action="{{ route(
                    'admin.descontos.update',
                    $desconto->desconto_id
                ) }}"
                method="POST"
                class="desconto-form"
            >

                @csrf

                @method('PUT')


                @if($isAniversario)

                    <div class="desconto-tipo-alerta">

                        <div class="desconto-tipo-icon">

                            <i class="bi bi-lock"></i>

                        </div>

                        <div>

                            <strong>
                                Desconto fixo do sistema
                            </strong>

                            <p>
                                Esta regra é definida pelo sistema e não pode ser alterada.
                            </p>

                        </div>

                        <span class="badge-desconto badge-fixo">

                            <i class="bi bi-lock"></i>

                            Fixo

                        </span>

                    </div>

                @else

                    <div class="desconto-tipo-alerta desconto-tipo-personalizado">

                        <div class="desconto-tipo-icon">

                            <i class="bi bi-sliders"></i>

                        </div>

                        <div>

                            <strong>
                                Desconto personalizado
                            </strong>

                            <p>
                                Esta regra pode ser gerenciada pelo administrador.
                            </p>

                        </div>

                        <span class="badge-desconto badge-personalizado">

                            <i class="bi bi-sliders"></i>

                            Personalizado

                        </span>

                    </div>

                @endif


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
                                Configure os dados principais desta regra.
                            </p>

                        </div>

                    </div>


                    <div class="desconto-form-grid">


                        <div class="form-group-desconto form-group-full">

                            <label for="nome">
                                Nome do Desconto
                            </label>


                            @if($isAniversario)

                                <input
                                    type="text"
                                    value="{{ $desconto->nome }}"
                                    disabled
                                >

                                <input
                                    type="hidden"
                                    name="nome"
                                    value="{{ $desconto->nome }}"
                                >

                            @else

                                <input
                                    type="text"
                                    name="nome"
                                    id="nome"
                                    value="{{ old(
                                        'nome',
                                        $desconto->nome
                                    ) }}"
                                    required
                                >

                            @endif

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
                                    value="{{ old(
                                        'valor',
                                        $desconto->valor
                                    ) }}"
                                    required
                                >

                                <span>
                                    %
                                </span>

                            </div>

                        </div>


                        @if(!$isAniversario)

                            <div class="form-group-desconto">

                                <label for="quando_terminar">
                                    Termina em
                                </label>

                                <input
                                    type="date"
                                    name="quando_terminar"
                                    id="quando_terminar"
                                    min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                    value="{{ old(
                                        'quando_terminar',
                                        $desconto->quando_terminar
                                            ? \Carbon\Carbon::parse(
                                                $desconto->quando_terminar
                                            )->format('Y-m-d')
                                            : ''
                                    ) }}"
                                >

                                <small>
                                    Deixe em branco se for permanente.
                                </small>

                            </div>

                        @endif


                    </div>

                </section>


                @if(!$isAniversario)

                    @php

                        $itensSelecionados =
                            $desconto->itens
                                ->pluck('item_id')
                                ->toArray();

                    @endphp


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
                                    Defina quais itens receberão este desconto.
                                </p>

                            </div>

                        </div>


                        <div class="desconto-selecao-grid">


                            <div class="desconto-selecao">

                                <label for="itens">
                                    Itens com esse desconto
                                </label>

                                <span class="desconto-ajuda">
                                    Desmarque um item para removê-lo.
                                </span>

                                <select
                                    name="itens[]"
                                    id="itens"
                                    multiple
                                    size="8"
                                >

                                    @foreach($itens as $item)

                                        <option
                                            value="{{ $item->item_id }}"
                                            {{ in_array(
                                                $item->item_id,
                                                old(
                                                    'itens',
                                                    $itensSelecionados
                                                )
                                            ) ? 'selected' : '' }}
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
                                    Itens que não receberão este desconto.
                                </p>

                            </div>

                        </div>


                        <div class="desconto-selecao">

                            <label for="excecoes">
                                Itens que NÃO receberão este desconto
                            </label>

                            <span class="desconto-ajuda">
                                Anula a seleção por marca ou categoria.
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

                @endif


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

                        Atualizar Desconto

                    </button>

                </div>


            </form>

        </main>

    </div>

</div>

@endsection