@extends('layouts.app')

@push('css')

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


            @php

                $produtosBastante = $produtos
                    ->filter(function ($produto) {
                        return $produto->estoque > 5;
                    })
                    ->count();

                $produtosAtencao = $produtos
                    ->filter(function ($produto) {
                        return $produto->estoque > 0
                            && $produto->estoque <= 5;
                    })
                    ->count();

                $produtosEsgotados = $produtos
                    ->filter(function ($produto) {
                        return $produto->estoque <= 0;
                    })
                    ->count();

            @endphp


            <div class="produtos-header">

                <span class="breadcrumb-produtos">
                    Painel > Produtos
                </span>

                <h1>
                    Produtos e Estoque
                </h1>

            </div>


            @if(session('success'))

                <div class="produto-alert produto-alert-success">

                    <i class="bi bi-check-circle"></i>

                    {{ session('success') }}

                </div>

            @endif


            @if($errors->any())

                <div class="produto-alert produto-alert-error">

                    <i class="bi bi-exclamation-circle"></i>

                    <div>

                        @foreach($errors->all() as $erro)

                            <p>
                                {{ $erro }}
                            </p>

                        @endforeach

                    </div>

                </div>

            @endif


            <section class="estoque-resumo">

                <div class="estoque-card estoque-bastante">

                    <span class="estoque-titulo">
                        BASTANTE
                    </span>

                    <strong>
                        {{ $produtosBastante }}

                        <span>
                            produtos
                        </span>
                    </strong>

                                <select
                                    name="marca_id"
                                    id="marca_id"
                                    required
                                >


                <div class="estoque-card estoque-atencao">

                    <span class="estoque-titulo">
                        ATENÇÃO
                    </span>

                    <strong>
                        {{ $produtosAtencao }}

                        <span>
                            produtos
                        </span>
                    </strong>

                </div>


                <div class="estoque-card estoque-esgotado">

                    <span class="estoque-titulo">
                        ESGOTADOS
                    </span>

                    <strong>
                        {{ $produtosEsgotados }}

                        <span>
                            produtos
                        </span>
                    </strong>

                </div>

                                <select
                                    name="categoria_id"
                                    id="categoria_id"
                                    required
                                >


            <section class="produtos-area">


                <div class="catalogo-card">


                    <div class="catalogo-header">

                        <div>

                            <h2>
                                Catálogo de produtos
                            </h2>

                            <p>
                                {{ $categorias->count() }} categorias ·
                                {{ $marcas->count() }} marcas ·
                                {{ $produtos->count() }} produtos
                            </p>

                        </div>


                        <details class="novo-produto">

                            <summary>

                                <i class="bi bi-plus-lg"></i>

                                Novo produto

                            </summary>


                                <input
                                    type="number"
                                    name="estoque"
                                    id="estoque"
                                    placeholder="0,00"
                                    min="0"
                                    value="{{ old('estoque') }}"
                                    required
                                >

                                <div class="novo-produto-cabecalho">

                                    <h3>
                                        Cadastrar Produto
                                    </h3>

                                    <p>
                                        Adicione um novo produto ao estoque.
                                    </p>

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
                                                value="{{ old('estoque') }}"
                                                placeholder="Ex. 0"
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
                                        class="btn-salvar-produto"
                                    >

                                        <i class="bi bi-plus-lg"></i>

                                        Cadastrar produto

                                    </button>

                                </form>

                            </div>

                        </details>

                    </div>


                    <div class="catalogo-pesquisa">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="pesquisa-produtos"
                            placeholder="Buscar marca, categoria, produto..."
                            autocomplete="off"
                        >

                    </div>


                    <div class="tabela-produtos-wrapper">

                        <table class="tabela-produtos">

                            <thead>

                                <tr>

                                    <th>
                                        Produto
                                    </th>

                                    <th>
                                        Categoria
                                    </th>

                                    <th>
                                        Marca
                                    </th>

                                    <th>
                                        Preço
                                    </th>

                                    <th>
                                        Estoque
                                    </th>

                                    <th>
                                        Status do estoque
                                    </th>

                                    <th>
                                        Ações
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="produtos-tbody">

                                @forelse($produtos as $produto)

                                    <tr
                                        class="produto-linha"
                                        data-pesquisa="{{
                                            mb_strtolower(
                                                ($produto->nome ?? '') .
                                                ' ' .
                                                ($produto->categorias->nome ?? '') .
                                                ' ' .
                                                ($produto->marcas->nome ?? '')
                                            )
                                        }}"
                                    >

                                        <td>

                                            <strong class="produto-nome">
                                                {{ $produto->nome }}
                                            </strong>

                                        </td>


                                        <td>
                                            {{
                                                $produto->categorias->nome
                                                ?? 'Sem categoria'
                                            }}
                                        </td>


                                        <td>
                                            {{
                                                $produto->marcas->nome
                                                ?? 'Sem marca'
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


                                        <td class="produto-estoque">

                                            {{ $produto->estoque }} un

                                        </td>


                                        <td>

                                            @if($produto->estoque <= 0)

                                                <span class="status-produto sem-estoque">

                                                    <span class="status-bolinha"></span>

                                                    Esgotado

                                                </span>

                                            @elseif($produto->estoque <= 5)

                                                <span class="status-produto estoque-baixo">

                                                    <span class="status-bolinha"></span>

                                                    Baixo Estoque

                                                </span>

                                            @else

                                                <span class="status-produto disponivel">

                                                    <span class="status-bolinha"></span>

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

                                                    <i class="bi bi-pencil-square"></i>

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
                                            colspan="7"
                                            class="produtos-vazio"
                                        >
                                            Nenhum produto cadastrado.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    <div
                        id="nenhum-produto-pesquisa"
                        class="nenhum-produto-pesquisa"
                    >

                        <i class="bi bi-search"></i>

                        <span>
                            Nenhum produto encontrado.
                        </span>

                    </div>


                    <div class="catalogo-footer">

                        <span id="contador-produtos">
                            Exibindo 0 produtos
                        </span>


                        <nav
                            class="produtos-pagination"
                            id="produtos-pagination"
                        >

                            <button
                                type="button"
                                class="pagination-btn"
                                id="pagination-anterior"
                            >
                                Anterior
                            </button>


                            <div
                                class="pagination-numeros"
                                id="pagination-numeros"
                            >
                            </div>


                            <button
                                type="button"
                                class="pagination-btn"
                                id="pagination-proximo"
                            >
                                Próximo
                            </button>

                        </nav>

                    </div>

                </div>


                <aside class="produtos-lateral">


                    <div class="lateral-card">

                        <div class="lateral-card-header">

                            <h3>
                                Categorias
                            </h3>


                            <details class="adicionar-lateral">

                                <summary title="Nova categoria">
                                    +
                                </summary>


                                <div class="adicionar-lateral-form">

                                    <form
                                        action="{{ route('admin.categorias.store') }}"
                                        method="POST"
                                    >

                                        @csrf


                                        <label for="categoria_nome">
                                            Nova categoria
                                        </label>

                                        <input
                                            type="text"
                                            name="nome"
                                            id="categoria_nome"
                                            placeholder="Nome da categoria"
                                            required
                                        >

                                        <button type="submit">
                                            Adicionar
                                        </button>

                                    </form>

                                </div>

                            </details>

                        </div>


                        <div class="lateral-lista">

                            @forelse($categorias as $categoria)

                                <div class="lateral-item">

                                    <div class="lateral-item-nome">

                                        <span class="categoria-bolinha"></span>

                                        <span>
                                            {{ $categoria->nome }}
                                        </span>

                                    </div>


                                    <span class="lateral-quantidade">

                                        {{
                                            $produtos
                                                ->where(
                                                    'categoria_id',
                                                    $categoria->categoria_id
                                                )
                                                ->count()
                                        }}

                                        itens

                                    </span>

                                </div>

                            @empty

                                <p class="lateral-vazio">
                                    Nenhuma categoria cadastrada.
                                </p>

                            @endforelse

                        </div>

                    </div>


                    <div class="lateral-card">

                        <div class="lateral-card-header">

                            <h3>
                                Marcas
                            </h3>


                            <details class="adicionar-lateral">

                                <summary title="Nova marca">
                                    +
                                </summary>


                                <div class="adicionar-lateral-form">

                                    <form
                                        action="{{ route('admin.marcas.store') }}"
                                        method="POST"
                                    >

                                        @csrf


                                        <label for="marca_nome">
                                            Nova marca
                                        </label>

                                        <input
                                            type="text"
                                            name="nome"
                                            id="marca_nome"
                                            placeholder="Nome da marca"
                                            required
                                        >

                                        <button type="submit">
                                            Adicionar
                                        </button>

                                    </form>

                                </div>

                            </details>

                        </div>


                        <div class="lateral-lista">

                            @forelse($marcas as $marca)

                                <div class="lateral-item">

                                    <div class="lateral-item-nome">

                                        <span class="marca-bolinha"></span>

                                        <span>
                                            {{ $marca->nome }}
                                        </span>

                                    </div>


                                    <span class="lateral-quantidade">

                                        {{
                                            $produtos
                                                ->where(
                                                    'marca_id',
                                                    $marca->marca_id
                                                )
                                                ->count()
                                        }}

                                        itens

                                    </span>

                                </div>

                            @empty

                                <p class="lateral-vazio">
                                    Nenhuma marca cadastrada.
                                </p>

                            @endforelse

                        </div>

                    </div>

                </aside>

            </section>

        </main>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const pesquisa =
        document.getElementById('pesquisa-produtos');

    const todasLinhas =
        Array.from(
            document.querySelectorAll('.produto-linha')
        );

    const contador =
        document.getElementById('contador-produtos');

    const pagination =
        document.getElementById('produtos-pagination');

    const numeros =
        document.getElementById('pagination-numeros');

    const anterior =
        document.getElementById('pagination-anterior');

    const proximo =
        document.getElementById('pagination-proximo');

    const nenhumProduto =
        document.getElementById('nenhum-produto-pesquisa');


    const produtosPorPagina = 5;

    let paginaAtual = 1;

    let linhasFiltradas = [...todasLinhas];


    function normalizarTexto(texto) {

        return texto
            .toLowerCase()
            .normalize('NFD')
            .replace(
                /[\u0300-\u036f]/g,
                ''
            );

    }


    function filtrarProdutos() {

        const termo =
            normalizarTexto(
                pesquisa.value.trim()
            );


        linhasFiltradas =
            todasLinhas.filter(
                function (linha) {

                    const dados =
                        normalizarTexto(
                            linha.dataset.pesquisa || ''
                        );

                    return dados.includes(termo);

                }
            );


        paginaAtual = 1;

        renderizarPagina();

    }


    function renderizarPagina() {

        todasLinhas.forEach(
            function (linha) {

                linha.style.display = 'none';

            }
        );


        const totalProdutos =
            linhasFiltradas.length;

        const totalPaginas =
            Math.ceil(
                totalProdutos /
                produtosPorPagina
            );


        if (
            paginaAtual > totalPaginas &&
            totalPaginas > 0
        ) {

            paginaAtual = totalPaginas;

        }


        const inicio =
            (paginaAtual - 1) *
            produtosPorPagina;

        const fim =
            inicio +
            produtosPorPagina;


        const produtosPagina =
            linhasFiltradas.slice(
                inicio,
                fim
            );


        produtosPagina.forEach(
            function (linha) {

                linha.style.display = '';

            }
        );


        atualizarContador(
            inicio,
            produtosPagina.length,
            totalProdutos
        );


        criarPaginacao(
            totalPaginas
        );


        if (totalProdutos === 0) {

            nenhumProduto.style.display =
                'flex';

            pagination.style.display =
                'none';

        } else {

            nenhumProduto.style.display =
                'none';

            pagination.style.display =
                totalPaginas > 1
                    ? 'flex'
                    : 'none';

        }

    }


    function atualizarContador(
        inicio,
        quantidadePagina,
        total
    ) {

        if (total === 0) {

            contador.textContent =
                'Nenhum produto encontrado';

            return;

        }


        const primeiro =
            inicio + 1;

        const ultimo =
            inicio + quantidadePagina;


        contador.textContent =
            'Exibindo ' +
            primeiro +
            '-' +
            ultimo +
            ' de ' +
            total +
            ' produtos';

    }


    function criarPaginacao(
        totalPaginas
    ) {

        numeros.innerHTML = '';


        anterior.disabled =
            paginaAtual === 1;


        proximo.disabled =
            paginaAtual === totalPaginas ||
            totalPaginas === 0;


        for (
            let pagina = 1;
            pagina <= totalPaginas;
            pagina++
        ) {

            const botao =
                document.createElement(
                    'button'
                );


            botao.type =
                'button';

            botao.textContent =
                pagina;

            botao.className =
                'pagination-num';


            if (
                pagina === paginaAtual
            ) {

                botao.classList.add(
                    'active'
                );

            }


            botao.addEventListener(
                'click',
                function () {

                    paginaAtual =
                        pagina;

                    renderizarPagina();

                }
            );


            numeros.appendChild(
                botao
            );

        }

    }


    anterior.addEventListener(
        'click',
        function () {

            if (paginaAtual > 1) {

                paginaAtual--;

                renderizarPagina();

            }

        }
    );


    proximo.addEventListener(
        'click',
        function () {

            const totalPaginas =
                Math.ceil(
                    linhasFiltradas.length /
                    produtosPorPagina
                );


            if (
                paginaAtual <
                totalPaginas
            ) {

                paginaAtual++;

                renderizarPagina();

            }

        }
    );


    pesquisa.addEventListener(
        'input',
        filtrarProdutos
    );


    renderizarPagina();

});

</script>


@endsection