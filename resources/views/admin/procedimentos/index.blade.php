@extends('layouts.app')

@push('css')

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>

<link
    rel="stylesheet"
    href="{{ asset('css/admin/dashboard.css') }}"
>

<link
    rel="stylesheet"
    href="{{ asset('css/admin/procedimentos.css') }}"
>

@endpush


@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')


    <div class="admin-main">

        @include('components.admin.navbar')


        <main class="procedimentos-content">


            <div class="procedimentos-header">

                <span class="breadcrumb-admin">
                    Painel >
                    <strong>Procedimentos</strong>
                </span>

                <h1>
                    Gerenciar Procedimentos
                </h1>

                <p>
                    Cadastre, edite ou remova os procedimentos disponíveis.
                </p>

            </div>


            @if(session('success'))

                <div class="alert-success">

                    <i class="bi bi-check-circle"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            @if(session('error'))

                <div class="alert-errors">

                    <i class="bi bi-exclamation-circle"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            @if($errors->any())

                <div class="alert-errors">

                    <i class="bi bi-exclamation-circle"></i>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif



            <section class="procedimentos-topo">


                <div class="novo-procedimento">


                    <div class="section-header">

                        <span class="section-header-icon">

                            <i class="bi bi-scissors"></i>

                        </span>


                        <div>

                            <h2>
                                Novo Procedimento
                            </h2>

                            <p>
                                Preencha as informações para cadastrar
                                um novo procedimento.
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route('admin.procedimentos.store') }}"
                        method="POST"
                    >

                        @csrf


                        <div class="form-row">


                            <div class="form-group">

                                <label for="tipo_id">

                                    <i class="bi bi-grid"></i>

                                    Tipo

                                </label>


                                <select
                                    name="tipo_id"
                                    id="tipo_id"
                                    required
                                >

                                    <option value="">
                                        Selecione o tipo
                                    </option>


                                    @foreach($tipos as $tipo)

                                        <option
                                            value="{{ $tipo->tipo_id }}"
                                            data-colorivel="{{
                                                !empty($tipo->is_colorivel)
                                                    ? '1'
                                                    : '0'
                                            }}"
                                            {{
                                                old('tipo_id') == $tipo->tipo_id
                                                    ? 'selected'
                                                    : ''
                                            }}
                                        >

                                            {{ $tipo->nome }}

                                        </option>

                                    @endforeach

                                </select>


                                <small
                                    id="status-colorivel"
                                    class="status-colorivel"
                                ></small>


                                @error('tipo_id')

                                    <small class="form-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            <div class="form-group">

                                <label for="nome">

                                    <i class="bi bi-scissors"></i>

                                    Nome do procedimento

                                </label>


                                <input
                                    type="text"
                                    name="nome"
                                    id="nome"
                                    value="{{ old('nome') }}"
                                    placeholder="Ex: Corte feminino"
                                    maxlength="255"
                                    required
                                >


                                @error('nome')

                                    <small class="form-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>


                        <div class="form-row form-row-descricao">


                            <div class="form-group">

                                <label for="descricao">

                                    <i class="bi bi-card-text"></i>

                                    Descrição

                                </label>


                                <textarea
                                    name="descricao"
                                    id="descricao"
                                    placeholder="Descreva o procedimento e os principais detalhes"
                                    required
                                >{{ old('descricao') }}</textarea>


                                @error('descricao')

                                    <small class="form-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            <div class="form-group">

                                <label for="preco">

                                    <i class="bi bi-currency-dollar"></i>

                                    Preço

                                </label>


                                <div class="preco-input">

                                    <span>
                                        R$
                                    </span>


                                    <input
                                        type="number"
                                        name="preco"
                                        id="preco"
                                        min="0"
                                        step="0.01"
                                        value="{{ old('preco') }}"
                                        placeholder="0,00"
                                        required
                                    >

                                </div>


                                @error('preco')

                                    <small class="form-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>


                        <div class="procedimento-form-footer">

                            <button
                                type="submit"
                                class="btn-salvar"
                            >

                                <i class="bi bi-plus-lg"></i>

                                Cadastrar Procedimento

                            </button>

                        </div>

                    </form>

                </div>



                <aside class="procedimento-cadastros-laterais">


                    <div class="cadastro-lateral-card">


                        <div class="cadastro-lateral-header">

                            <span class="cadastro-lateral-icon">

                                <i class="bi bi-grid"></i>

                            </span>


                            <div>

                                <h2>
                                    Novo Tipo
                                </h2>

                                <p>
                                    Cadastre um tipo.
                                </p>

                            </div>

                        </div>


                        <form
                            action="{{ route('admin.tipos.store') }}"
                            method="POST"
                        >

                            @csrf


                            <div class="form-group">

                                <label for="tipo_nome">
                                    Nome do tipo
                                </label>


                                <input
                                    type="text"
                                    name="nome"
                                    id="tipo_nome"
                                    placeholder="Ex: Cabelo"
                                    required
                                >

                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="checkbox" name="colorivel" value="1">
                                    Permite selecionar cor
                                </label>
                            </div>


                            <button
                                type="submit"
                                class="btn-cadastro-auxiliar"
                            >

                                <i class="bi bi-plus-lg"></i>

                                Adicionar Tipo

                            </button>

                        </form>


                        <a
                            href="{{ route('admin.tipos.index') }}"
                            class="btn-gerenciar-auxiliar"
                        >

                            <i class="bi bi-gear"></i>

                            Gerenciar Tipos

                        </a>

                    </div>



                    <div class="cadastro-lateral-card">


                        <div class="cadastro-lateral-header">

                            <span class="cadastro-lateral-icon">

                                <i class="bi bi-palette"></i>

                            </span>


                            <div>

                                <h2>
                                    Nova Cor
                                </h2>

                                <p>
                                    Cadastre uma cor disponível.
                                </p>

                            </div>

                        </div>


                        <form
                            action="{{ route('admin.cores.store') }}"
                            method="POST"
                        >

                            @csrf


                            <div class="form-group">

                                <label for="cor_nome">
                                    Nome da cor
                                </label>


                                <input
                                    type="text"
                                    name="nome"
                                    id="cor_nome"
                                    placeholder="Ex: Loiro"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label for="cor_estoque">
                                    Estoque
                                </label>


                                <input
                                    type="number"
                                    name="estoque"
                                    id="cor_estoque"
                                    min="0"
                                    placeholder="Ex. 0"
                                    required
                                >

                            </div>


                            <button
                                type="submit"
                                class="btn-cadastro-auxiliar"
                            >

                                <i class="bi bi-plus-lg"></i>

                                Adicionar Cor

                            </button>

                        </form>


                        <a
                            href="{{ route('admin.cores.index') }}"
                            class="btn-gerenciar-auxiliar"
                        >

                            <i class="bi bi-gear"></i>

                            Gerenciar Cores

                        </a>

                    </div>


                </aside>


            </section>



            <section
                class="lista-procedimentos"
                id="lista-procedimentos"
            >


                <div class="lista-header">

                    <div>

                        <h2>
                            Procedimentos Cadastrados
                        </h2>

                        <p>
                            Procedimentos disponíveis para os clientes.
                        </p>

                    </div>


                    <span class="contador-servicos">

                        {{ $procedimentos->count() }}

                        {{
                            $procedimentos->count() === 1
                                ? 'procedimento'
                                : 'procedimentos'
                        }}

                    </span>

                </div>


                @if($procedimentos->count() > 0)


                    <div class="table-responsive">


                        <table
                            class="procedimentos-table"
                            id="tabela-procedimentos"
                        >


                            <thead>

                                <tr>

                                    <th>
                                        Tipo
                                    </th>

                                    <th>
                                        Procedimento
                                    </th>

                                    <th>
                                        Descrição
                                    </th>

                                    <th>
                                        Preço
                                    </th>

                                    <th>
                                        Ações
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="procedimentos-tbody">


                                @foreach($procedimentos as $procedimento)

                                    <tr class="procedimento-linha">


                                        <td>

                                            <span class="tipo-badge">

                                                {{
                                                    $procedimento->tipos->nome
                                                    ?? 'Sem tipo'
                                                }}

                                            </span>

                                        </td>


                                        <td>

                                            <strong class="procedimento-nome">

                                                {{ $procedimento->nome }}

                                            </strong>

                                        </td>


                                        <td>

                                            <span class="procedimento-descricao">

                                                {{ $procedimento->descricao }}

                                            </span>

                                        </td>


                                        <td>

                                            <span class="preco-procedimento">

                                                R$

                                                {{
                                                    number_format(
                                                        $procedimento->preco,
                                                        2,
                                                        ',',
                                                        '.'
                                                    )
                                                }}

                                            </span>

                                        </td>


                                        <td>

                                            <div class="acoes">

                                                <a
                                                    href="{{ route(
                                                        'admin.procedimentos.edit',
                                                        $procedimento->getKey()
                                                    ) }}"
                                                    class="btn-editar"
                                                >

                                                    <i class="bi bi-pencil"></i>

                                                    Editar

                                                </a>


                                                <form
                                                    action="{{ route(
                                                        'admin.procedimentos.destroy',
                                                        $procedimento->getKey()
                                                    ) }}"
                                                    method="POST"
                                                >

                                                    @csrf
                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        class="btn-excluir"
                                                        onclick="return confirm('Deseja realmente excluir este procedimento?')"
                                                    >

                                                        <i class="bi bi-trash"></i>

                                                        Excluir

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach


                            </tbody>

                        </table>

                    </div>


                    <div
                        class="procedimentos-pagination-footer"
                        id="procedimentos-pagination-footer"
                    >

                        <span
                            class="procedimentos-pagination-info"
                            id="procedimentos-pagination-info"
                        >
                            Carregando...
                        </span>


                        <nav
                            class="procedimentos-pagination"
                            id="procedimentos-pagination"
                        >

                            <button
                                type="button"
                                class="procedimentos-pagination-btn"
                                id="procedimentos-anterior"
                            >

                                <i class="bi bi-chevron-left"></i>

                                Anterior

                            </button>


                            <div
                                class="procedimentos-pagination-numeros"
                                id="procedimentos-pagination-numeros"
                            ></div>


                            <button
                                type="button"
                                class="procedimentos-pagination-btn"
                                id="procedimentos-proximo"
                            >

                                Próximo

                                <i class="bi bi-chevron-right"></i>

                            </button>

                        </nav>

                    </div>


                @else


                    <div class="nenhum-procedimento">

                        <i class="bi bi-scissors"></i>

                        <h3>
                            Nenhum procedimento cadastrado
                        </h3>

                        <p>
                            Cadastre seu primeiro procedimento.
                        </p>

                    </div>


                @endif


            </section>


        </main>

    </div>

</div>

@endsection


@push('scripts')

<script
    src="{{ asset('js/admin/procedimento.js') }}"
></script>

@endpush