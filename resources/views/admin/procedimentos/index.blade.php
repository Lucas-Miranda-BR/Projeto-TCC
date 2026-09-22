@extends('layouts.app')

@push('css')

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

                <div>

                    <span class="breadcrumb-admin">
                        Painel >
                        <strong>Procedimentos</strong>
                    </span>

                    <h1>
                        Gerenciar Procedimentos
                    </h1>

                    <p>
                        Cadastre, edite e organize os procedimentos disponíveis no salão.
                    </p>

                </div>

            </div>


            @if(session('success'))

                <div class="alert-success">

                    <i class="bi bi-check-circle-fill"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            @if($errors->any())

                <div class="alert-errors">

                    <div class="alert-errors-title">

                        <i class="bi bi-exclamation-circle-fill"></i>

                        <strong>
                            Verifique os campos abaixo
                        </strong>

                    </div>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif



            <section class="novo-procedimento">


                <div class="novo-procedimento-header">

                    <div class="novo-procedimento-icon">

                        <i class="bi bi-scissors"></i>

                    </div>


                    <div>

                        <h2>
                            Novo Procedimento
                        </h2>

                        <p>
                            Preencha as informações para cadastrar um novo procedimento.
                        </p>

                    </div>

                </div>



                <form
                    action="{{ route('admin.procedimentos.store') }}"
                    method="POST"
                    class="procedimento-form"
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

                                <option
                                    value=""
                                    selected
                                    disabled
                                >
                                    Selecione o tipo
                                </option>

                       <span id="status-colorivel" style="display: none; margin-top: 8px; font-weight: 500;">Selecione um tipo</span>

                    </div>

                                @foreach($tipos as $tipo)

                                    <option
                                        value="{{ $tipo->tipo_id }}"
                                        data-colorivel="{{ $tipo->colorivel ? '1' : '0' }}"
                                        {{ old('tipo_id') == $tipo->tipo_id ? 'selected' : '' }}
                                    >

                                        {{ $tipo->nome }}

                                    </option>

                                @endforeach

                            </select>

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
                                required
                            >

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
                                placeholder="Descreva o procedimento e os principais detalhes do procedimento"
                                required
                            >{{ old('descricao') }}</textarea>

                        </div>



                        <div class="form-group preco-group">

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
                                    step="0.01"
                                    min="0"
                                    value="{{ old('preco') }}"
                                    placeholder="0,00"
                                    required
                                >

                            </div>

                        </div>


                    </div>



                    <div class="form-actions">

                        <button
                            type="submit"
                            class="btn-salvar"
                        >

                            <i class="bi bi-plus-lg"></i>

                            Cadastrar Procedimento

                        </button>

                    </div>


                </form>


            </section>

            <h1>Gerenciar Tipo de Procedimento</h1>
            <button> <a href="{{ route('admin.tipos.index') }}">Gerencie Aqui</a></button>

            <br>

            <h1>Gerenciar Cores Disponíveis de Procedimento</h1>
            <button> <a href="{{ route('admin.cores.index') }}">Gerencie Aqui</a></button>




            <section class="lista-procedimentos">


                <div class="lista-header">


                    <div class="lista-header-title">

                        <div class="lista-header-icon">

                            <i class="bi bi-list-check"></i>

                        </div>


                        <div>

                            <h2>
                                Procedimentos Cadastrados
                            </h2>

                            <p>

                                <strong id="contador-procedimentos">

                                    {{ $procedimentos->count() }}

                                </strong>

                                procedimento(s) encontrado(s)

                            </p>

                        </div>

                    </div>



                    <div class="lista-header-search">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="buscar-procedimento"
                            placeholder="Buscar procedimento..."
                            autocomplete="off"
                        >

                    </div>


                </div>



                @if($procedimentos->count() > 0)


                    <div class="table-responsive">


                        <table class="tabela-procedimentos">


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

                                    <th class="coluna-acoes">
                                        Ações
                                    </th>

                                </tr>

                            </thead>



                            <tbody id="procedimentos-tbody">


                                @foreach($procedimentos as $procedimento)


                                    <tr class="procedimento-row">


                                        <td>

                                            <span class="tipo-badge">

                                                {{
                                                    $procedimento->tipos->nome
                                                    ?? 'Sem tipo'
                                                }}

                                            </span>

                                        </td>



                                        <td>

                                            <div class="procedimento-info">

                                                <strong class="procedimento-nome">

                                                    {{ $procedimento->nome }}

                                                </strong>


                                                @if(optional($procedimento->tipos)->colorivel)

                                                    <span class="status-colorivel sim">

                                                        <span class="status-dot"></span>

                                                        Colorível

                                                    </span>

                                                @else

                                                    <span class="status-colorivel nao">

                                                        <span class="status-dot"></span>

                                                        Não colorível

                                                    </span>

                                                @endif

                                            </div>

                                        </td>



                                        <td>

                                            <p class="procedimento-descricao">

                                                {{ $procedimento->descricao }}

                                            </p>

                                        </td>



                                        <td>

                                            <span class="procedimento-preco">

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


                                            <div class="acoes-procedimento">


                                                <a
                                                    href="{{ route(
                                                        'admin.procedimentos.edit',
                                                        $procedimento->getKey()
                                                    ) }}"
                                                    class="btn-editar"
                                                    title="Editar procedimento"
                                                >

                                                    <i class="bi bi-pencil"></i>

                                                    <span>
                                                        Editar
                                                    </span>

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
                                                        title="Excluir procedimento"
                                                        onclick="return confirm('Deseja realmente excluir este procedimento?')"
                                                    >

                                                        <i class="bi bi-trash"></i>

                                                        <span>
                                                            Excluir
                                                        </span>

                                                    </button>

                                                </form>


                                            </div>


                                        </td>


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>


                        <div
                            id="busca-vazia"
                            class="busca-vazia"
                            style="display: none;"
                        >

                            <div class="busca-vazia-icon">

                                <i class="bi bi-search"></i>

                            </div>

                            <h3>
                                Nenhum procedimento encontrado
                            </h3>

                            <p>
                                Tente pesquisar por outro nome, tipo ou descrição.
                            </p>

                        </div>


                    </div>


                @else


                    <div class="nenhum-procedimento">

                        <div class="nenhum-procedimento-icon">

                            <i class="bi bi-scissors"></i>

                        </div>

                        <h3>
                            Nenhum procedimento cadastrado
                        </h3>

                        <p>
                            Cadastre seu primeiro procedimento utilizando o formulário acima.
                        </p>

                    </div>


                @endif


            </section>


        </main>


    </div>


</div>

@endsection



@push('scripts')
<script src="{{ asset('js/admin/procedimento.js') }}"></script>
@endpush
