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
    href="{{ asset('css/admin/produtos.css') }}"
>

@endpush


@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="produtos-content">


            <div class="produtos-header">

                <span class="breadcrumb-admin">
                    Painel >
                    <strong>Produtos</strong>
                </span>

                <h1>
                    Gerenciar Produtos
                </h1>

                <p>
                    Cadastre produtos e acompanhe o estoque.
                </p>

            </div>


            @if(session('success'))

                <div class="produto-alert produto-alert-success">

                    {{ session('success') }}

                </div>

            @endif


            @if($errors->any())

                <div class="produto-alert produto-alert-error">

                    @foreach($errors->all() as $erro)

                        <p>
                            {{ $erro }}
                        </p>

                    @endforeach

                </div>

            @endif



            <section class="produtos-topo">


                <div class="produto-form-card produto-form-principal">


                    <div class="produto-form-title">

                        <span class="produto-form-icon">

                            <i class="bi bi-bag-plus"></i>

                        </span>

                        <div>

                            <h2>
                                Novo Produto
                            </h2>

                            <p>
                                Adicione um novo produto ao catálogo.
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route('admin.produtos.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <div class="form-group">

                            <label for="nome">
                                Nome do produto
                            </label>

                            <input
                                type="text"
                                name="nome"
                                id="nome"
                                value="{{ old('nome') }}"
                                placeholder="Ex: Shampoo Hidratante"
                                required
                            >

                        </div>



                        <div class="form-row">


                            <div class="form-group">

                                <label for="marca_id">
                                    Marca
                                </label>

                                <select
                                    name="marca_id"
                                    id="marca_id"
                                >

                                    <option value="">
                                        Sem marca
                                    </option>

                                    @foreach($marcas as $marca)

                                        <option
                                            value="{{ $marca->marca_id }}"
                                            {{ old('marca_id') == $marca->marca_id ? 'selected' : '' }}
                                        >

                                            {{ $marca->nome }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>



                            <div class="form-group">

                                <label for="categoria_id">
                                    Categoria
                                </label>

                                <select
                                    name="categoria_id"
                                    id="categoria_id"
                                >

                                    <option value="">
                                        Sem categoria
                                    </option>

                                    @foreach($categorias as $categoria)

                                        <option
                                            value="{{ $categoria->categoria_id }}"
                                            {{ old('categoria_id') == $categoria->categoria_id ? 'selected' : '' }}
                                        >

                                            {{ $categoria->nome }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                        </div>



                        <div class="form-row">


                            <div class="form-group">

                                <label for="preco">
                                    Preço
                                </label>

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



                            <div class="form-group">

                                <label for="estoque">
                                    Estoque inicial
                                </label>

                                <input
                                    type="number"
                                    name="estoque"
                                    id="estoque"
                                    min="0"
                                    value="{{ old('estoque', 0) }}"
                                    required
                                >

                            </div>


                        </div>



                        <div class="form-group">

                            <label for="foto">
                                Foto do produto
                            </label>

                            <input
                                type="file"
                                name="foto"
                                id="foto"
                                accept="image/jpeg,image/png,image/webp"
                                required
                            >

                        </div>



                        <button
                            type="submit"
                            class="btn-produto-principal"
                        >

                            <i class="bi bi-plus-lg"></i>

                            Cadastrar Produto

                        </button>


                    </form>


                </div>



                <aside class="produto-cadastros-laterais">


                    <div class="cadastro-lateral-card">


                        <div class="cadastro-lateral-header">

                            <span class="cadastro-lateral-icon">

                                <i class="bi bi-tag"></i>

                            </span>

                            <div>

                                <h2>
                                    Nova Marca
                                </h2>

                                <p>
                                    Cadastre uma marca.
                                </p>

                            </div>

                        </div>


                        <form
                            action="{{ route('admin.marcas.store') }}"
                            method="POST"
                        >

                            @csrf


                            <div class="form-group">

                                <label for="marca_nome">
                                    Nome da marca
                                </label>

                                <input
                                    type="text"
                                    name="nome"
                                    id="marca_nome"
                                    placeholder="Ex: Eudora"
                                    required
                                >

                            </div>


                            <button
                                type="submit"
                                class="btn-cadastro-auxiliar"
                            >

                                <i class="bi bi-plus-lg"></i>

                                Adicionar Marca

                            </button>

                        </form>



                        @if($marcas->count() > 0)

                            <div class="auxiliar-cadastrados">

                                <span>
                                    Marcas cadastradas
                                </span>

                                <div class="auxiliar-badges">

                                    @foreach($marcas as $marca)

                                        <span class="auxiliar-badge">
                                            {{ $marca->nome }}
                                        </span>

                                    @endforeach

                                </div>

                            </div>

                        @endif


                    </div>



                    <div class="cadastro-lateral-card">


                        <div class="cadastro-lateral-header">

                            <span class="cadastro-lateral-icon">

                                <i class="bi bi-grid"></i>

                            </span>

                            <div>

                                <h2>
                                    Nova Categoria
                                </h2>

                                <p>
                                    Cadastre uma categoria.
                                </p>

                            </div>

                        </div>



                        <form
                            action="{{ route('admin.categorias.store') }}"
                            method="POST"
                        >

                            @csrf


                            <div class="form-group">

                                <label for="categoria_nome">
                                    Nome da categoria
                                </label>

                                <input
                                    type="text"
                                    name="nome"
                                    id="categoria_nome"
                                    placeholder="Ex: Cabelos"
                                    required
                                >

                            </div>


                            <button
                                type="submit"
                                class="btn-cadastro-auxiliar"
                            >

                                <i class="bi bi-plus-lg"></i>

                                Adicionar Categoria

                            </button>


                        </form>



                        @if($categorias->count() > 0)

                            <div class="auxiliar-cadastrados">

                                <span>
                                    Categorias cadastradas
                                </span>

                                <div class="auxiliar-badges">

                                    @foreach($categorias as $categoria)

                                        <span class="auxiliar-badge">

                                            {{ $categoria->nome }}

                                        </span>

                                    @endforeach

                                </div>

                            </div>

                        @endif


                    </div>


                </aside>


            </section>



            <section class="estoque-resumo estoque-resumo-horizontal">


                <div class="estoque-card">

                    <i class="bi bi-bag"></i>

                    <span>
                        Produtos cadastrados
                    </span>

                    <strong>
                        {{ $produtos->count() }}
                    </strong>

                </div>



                <div class="estoque-card">

                    <i class="bi bi-box-seam"></i>

                    <span>
                        Unidades em estoque
                    </span>

                    <strong>
                        {{ $produtos->sum('estoque') }}
                    </strong>

                </div>



                <div class="estoque-card">

                    <i class="bi bi-exclamation-triangle"></i>

                    <span>
                        Estoque baixo
                    </span>

                    <strong>

                        {{
                            $produtos
                                ->filter(function ($produto) {

                                    return $produto->estoque > 0
                                        && $produto->estoque <= 5;

                                })
                                ->count()
                        }}

                    </strong>

                </div>



                <div class="estoque-card">

                    <i class="bi bi-x-circle"></i>

                    <span>
                        Sem estoque
                    </span>

                    <strong>

                        {{
                            $produtos
                                ->filter(function ($produto) {

                                    return $produto->estoque <= 0;

                                })
                                ->count()
                        }}

                    </strong>

                </div>


            </section>



            <section class="lista-produtos">


                <div class="lista-produtos-header">


                    <div class="lista-produtos-titulo">

                        <h2>
                            Produtos cadastrados
                        </h2>

                        <p>
                            Gerencie produtos, preços e estoque.
                        </p>

                    </div>



                    <div class="produtos-filtros">


                        <div class="produtos-pesquisa">

                            <i class="bi bi-search"></i>

                            <input
                                type="text"
                                id="buscar-produto"
                                placeholder="Buscar produto, marca ou categoria..."
                                autocomplete="off"
                            >

                        </div>



                        <div class="filtros-estoque">


                            <button
                                type="button"
                                class="filtro-produto ativo"
                                data-filtro="todos"
                            >

                                <i class="bi bi-grid"></i>

                                Todos

                                <span>
                                    {{ $produtos->count() }}
                                </span>

                            </button>



                            <button
                                type="button"
                                class="filtro-produto"
                                data-filtro="disponivel"
                            >

                                <i class="bi bi-check-circle"></i>

                                Disponíveis

                                <span>

                                    {{
                                        $produtos
                                            ->filter(function ($produto) {

                                                return $produto->estoque > 5;

                                            })
                                            ->count()
                                    }}

                                </span>

                            </button>



                            <button
                                type="button"
                                class="filtro-produto"
                                data-filtro="baixo"
                            >

                                <i class="bi bi-exclamation-triangle"></i>

                                Estoque baixo

                                <span>

                                    {{
                                        $produtos
                                            ->filter(function ($produto) {

                                                return $produto->estoque > 0
                                                    && $produto->estoque <= 5;

                                            })
                                            ->count()
                                    }}

                                </span>

                            </button>



                            <button
                                type="button"
                                class="filtro-produto"
                                data-filtro="esgotado"
                            >

                                <i class="bi bi-x-circle"></i>

                                Esgotados

                                <span>

                                    {{
                                        $produtos
                                            ->filter(function ($produto) {

                                                return $produto->estoque <= 0;

                                            })
                                            ->count()
                                    }}

                                </span>

                            </button>


                        </div>


                    </div>


                </div>



                <div class="tabela-container">


                    <table class="tabela-produtos">


                        <thead>

                            <tr>

                                <th>Foto</th>

                                <th>Produto</th>

                                <th>Marca</th>

                                <th>Categoria</th>

                                <th>Preço</th>

                                <th>Estoque</th>

                                <th>Status</th>

                                <th>Ações</th>

                            </tr>

                        </thead>



                        <tbody id="tabela-produtos-body">


                            @forelse($produtos as $produto)


                                @php

                                    if ($produto->estoque <= 0) {

                                        $statusFiltro = 'esgotado';

                                    } elseif ($produto->estoque <= 5) {

                                        $statusFiltro = 'baixo';

                                    } else {

                                        $statusFiltro = 'disponivel';

                                    }


                                    $fotoProduto = null;


                                    if ($produto->foto) {

                                        $fotoProduto =
                                            filter_var(
                                                $produto->foto,
                                                FILTER_VALIDATE_URL
                                            )
                                                ? $produto->foto
                                                : asset(
                                                    'storage/' .
                                                    $produto->foto
                                                );

                                    }

                                @endphp



                                <tr
                                    class="produto-linha"
                                    data-status="{{ $statusFiltro }}"
                                    data-busca="{{ $produto->nome }} {{ $produto->marcas->nome ?? '' }} {{ $produto->categorias->nome ?? '' }}"
                                >


                                    <td>

                                        @if($fotoProduto)

                                            <img
                                                src="{{ $fotoProduto }}"
                                                alt="{{ $produto->nome }}"
                                                class="produto-imagem"
                                            >

                                        @else

                                            <div class="produto-sem-foto">

                                                <i class="bi bi-image"></i>

                                            </div>

                                        @endif

                                    </td>



                                    <td>

                                        <strong class="produto-nome">

                                            {{ $produto->nome }}

                                        </strong>

                                    </td>



                                    <td>

                                        {{
                                            $produto->marcas->nome
                                            ?? 'Sem marca'
                                        }}

                                    </td>



                                    <td>

                                        {{
                                            $produto->categorias->nome
                                            ?? 'Sem categoria'
                                        }}

                                    </td>



                                    <td>

                                        <strong class="produto-preco">

                                            R$

                                            {{
                                                number_format(
                                                    $produto->preco,
                                                    2,
                                                    ',',
                                                    '.'
                                                )
                                            }}

                                        </strong>

                                    </td>



                                    <td>

                                        <strong>

                                            {{ $produto->estoque }}

                                        </strong>

                                    </td>



                                    <td>


                                        @if($produto->estoque <= 0)

                                            <span class="status-produto sem-estoque">

                                                Sem estoque

                                            </span>


                                        @elseif($produto->estoque <= 5)

                                            <span class="status-produto estoque-baixo">

                                                Estoque baixo

                                            </span>


                                        @else

                                            <span class="status-produto disponivel">

                                                Disponível

                                            </span>

                                        @endif


                                    </td>



                                    <td>


                                        <div class="acoes-produto">


                                            <a
                                                href="{{ route(
                                                    'admin.produtos.edit',
                                                    $produto->item_id
                                                ) }}"
                                                class="btn-editar-produto"
                                                title="Editar produto"
                                            >

                                                <i class="bi bi-pencil"></i>

                                            </a>



                                            <form
                                                action="{{ route(
                                                    'admin.produtos.destroy',
                                                    $produto->item_id
                                                ) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="btn-excluir-produto"
                                                    title="Excluir produto"
                                                    onclick="return confirm('Deseja excluir este produto?')"
                                                >

                                                    <i class="bi bi-trash"></i>

                                                </button>


                                            </form>


                                        </div>


                                    </td>


                                </tr>


                            @empty


                                <tr>

                                    <td
                                        colspan="8"
                                        class="produtos-vazio"
                                    >

                                        Nenhum produto cadastrado.

                                    </td>

                                </tr>


                            @endforelse


                        </tbody>


                    </table>



                    @if($produtos->count() > 0)

                        <div
                            id="nenhum-produto-filtro"
                            class="nenhum-produto-filtro"
                            style="display: none;"
                        >

                            <div class="nenhum-produto-filtro-icon">

                                <i class="bi bi-search"></i>

                            </div>

                            <h3>
                                Nenhum produto encontrado
                            </h3>

                            <p>
                                Tente alterar a pesquisa ou selecionar outro filtro.
                            </p>

                        </div>

                    @endif


                </div>


            </section>


        </main>


    </div>


</div>

@endsection



@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const botoesFiltro =
        document.querySelectorAll('.filtro-produto');

    const linhas =
        document.querySelectorAll('.produto-linha');

    const campoBusca =
        document.getElementById('buscar-produto');

    const mensagemVazia =
        document.getElementById('nenhum-produto-filtro');


    let filtroAtual = 'todos';


    function removerAcentos(texto) {

        return texto
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();

    }


    function aplicarFiltros() {

        const termoBusca =
            campoBusca
                ? removerAcentos(campoBusca.value.trim())
                : '';


        let encontrados = 0;


        linhas.forEach(function (linha) {

            const status =
                linha.dataset.status;


            const texto =
                removerAcentos(
                    linha.dataset.busca || ''
                );


            const correspondeStatus =
                filtroAtual === 'todos'
                || status === filtroAtual;


            const correspondeBusca =
                termoBusca === ''
                || texto.includes(termoBusca);


            if (
                correspondeStatus
                && correspondeBusca
            ) {

                linha.style.display = '';

                encontrados++;

            } else {

                linha.style.display = 'none';

            }

        });


        if (mensagemVazia) {

            mensagemVazia.style.display =
                encontrados === 0
                    ? 'flex'
                    : 'none';

        }

    }


    botoesFiltro.forEach(function (botao) {

        botao.addEventListener('click', function () {

            botoesFiltro.forEach(function (item) {

                item.classList.remove('ativo');

            });


            this.classList.add('ativo');


            filtroAtual =
                this.dataset.filtro;


            aplicarFiltros();

        });

    });


    if (campoBusca) {

        campoBusca.addEventListener(
            'input',
            aplicarFiltros
        );

    }

});

</script>

@endpush