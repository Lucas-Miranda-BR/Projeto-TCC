@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/produtos.css') }}">
@endpush

@section('content')

@include('components.navbar')


@if (session('success'))

    <div class="toast-carrinho toast-sucesso">

        <div class="toast-icon">
            <i class="bi bi-check-lg"></i>
        </div>

        <div class="toast-info">

            <strong>
                Produto adicionado
            </strong>

            <span>
                {{ session('success') }}
            </span>

        </div>

        <button
            type="button"
            class="toast-close"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>

@elseif (session('erro'))

    <div class="toast-carrinho toast-erro">

        <div class="toast-icon">
            <i class="bi bi-exclamation-lg"></i>
        </div>

        <div class="toast-info">

            <strong>
                Atenção
            </strong>

            <span>
                {{ session('erro') }}
            </span>

        </div>

        <button
            type="button"
            class="toast-close"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>

@elseif ($errors->any())

    <div class="toast-carrinho toast-erro">

        <div class="toast-icon">
            <i class="bi bi-exclamation-lg"></i>
        </div>

        <div class="toast-info">

            <strong>
                Atenção
            </strong>

            <span>
                {{ $errors->first() }}
            </span>

        </div>

        <button
            type="button"
            class="toast-close"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>

@endif


<main class="produtos-page">


    <section class="produtos-hero">

        <div class="produtos-hero-content">

            <span class="produtos-tag">
                SEMPRE DIVA
            </span>

            <h1>
                Nossos Produtos
            </h1>

            <p>
                Encontre produtos selecionados para cuidar
                da sua beleza e fazer parte da sua rotina.
            </p>

        </div>

    </section>


    <section class="produtos-container">


        <div class="produtos-topo">

            <div>

                <span class="catalogo-label">
                    CATÁLOGO
                </span>

                <h2>
                    Encontre seu produto
                </h2>

                <p>

                    {{ $produtos->total() }}

                    @if ($produtos->total() == 1)

                        produto encontrado

                    @else

                        produtos encontrados

                    @endif

                </p>

            </div>


            <a
                href="{{ route('carrinho.index') }}"
                class="btn-carrinho"
            >

                <i class="bi bi-bag"></i>

                Ver Carrinho

            </a>

        </div>


        <form
            action="{{ route('site.produtos') }}"
            method="GET"
            class="produtos-filtros"
        >


            <div class="filtro-grupo filtro-pesquisa">

                <label for="busca">
                    Pesquisar
                </label>

                <div class="campo-pesquisa">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="busca"
                        id="busca"
                        value="{{ request('busca') }}"
                        placeholder="Buscar produto..."
                    >

                </div>

            </div>


            <div class="filtro-grupo">

                <label for="categoria">
                    Categoria
                </label>

                <select
                    name="categoria"
                    id="categoria"
                >

                    <option value="">
                        Todas
                    </option>

                    @foreach ($categorias as $categoria)

                        <option
                            value="{{ $categoria->categoria_id }}"
                            {{ request('categoria') == $categoria->categoria_id ? 'selected' : '' }}
                        >
                            {{ $categoria->nome }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="filtro-grupo">

                <label for="marca">
                    Marca
                </label>

                <select
                    name="marca"
                    id="marca"
                >

                    <option value="">
                        Todas
                    </option>

                    @foreach ($marcas as $marca)

                        <option
                            value="{{ $marca->marca_id }}"
                            {{ request('marca') == $marca->marca_id ? 'selected' : '' }}
                        >
                            {{ $marca->nome }}
                        </option>

                    @endforeach

                </select>

            </div>


            <button
                type="submit"
                class="btn-filtrar"
            >

                <i class="bi bi-sliders"></i>

                Filtrar

            </button>


            @if (
                request()->filled('busca') ||
                request()->filled('categoria') ||
                request()->filled('marca')
            )

                <a
                    href="{{ route('site.produtos') }}"
                    class="btn-limpar"
                >

                    <i class="bi bi-x-lg"></i>

                    Limpar

                </a>

            @endif


        </form>


        @if ($produtos->count() > 0)


            <div class="produtos-grid">


                @foreach ($produtos as $produto)


                    <article class="produto-card">


                        <div class="produto-imagem">


                            @if (!empty($produto->foto))

                                <img
                                    src="{{ asset('storage/' . $produto->foto) }}"
                                    alt="{{ $produto->nome }}"
                                >

                            @else

                                <div class="produto-sem-imagem">

                                    <i class="bi bi-image"></i>

                                    <span>
                                        Sem imagem
                                    </span>

                                </div>

                            @endif


                            @if ($produto->categorias)

                                <span class="produto-categoria">

                                    {{ $produto->categorias->nome }}

                                </span>

                            @endif


                        </div>


                        <div class="produto-info">


                            @if ($produto->marcas)

                                <span class="produto-marca">

                                    {{ $produto->marcas->nome }}

                                </span>

                            @endif


                            <h3>
                                {{ $produto->nome }}
                            </h3>


                            <div
                                class="produto-estoque {{ $produto->estoque <= 0 ? 'produto-esgotado' : '' }}"
                            >

                                @if ($produto->estoque > 0)

                                    <i class="bi bi-check-circle"></i>

                                    {{ $produto->estoque }}

                                    @if ($produto->estoque == 1)

                                        unidade disponível

                                    @else

                                        unidades disponíveis

                                    @endif

                                @else

                                    <i class="bi bi-x-circle"></i>

                                    Produto esgotado

                                @endif

                            </div>


                            <div class="produto-bottom">


                                <div class="produto-preco">

                                    <span>
                                        Por
                                    </span>

                                    <strong>

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

                                </div>


                                @if ($produto->estoque > 0)

                                    <form
                                        action="{{ route(
                                            'carrinho.adicionar',
                                            $produto->item_id
                                        ) }}"
                                        method="POST"
                                        class="produto-compra-form"
                                    >

                                        @csrf


                                        <div class="quantidade-produto">


                                            <button
                                                type="button"
                                                class="quantidade-btn quantidade-menos"
                                                title="Diminuir quantidade"
                                            >

                                                <i class="bi bi-dash"></i>

                                            </button>


                                            <input
                                                type="number"
                                                name="quantidade"
                                                class="quantidade-input"
                                                value="1"
                                                min="1"
                                                max="{{ $produto->estoque }}"
                                                readonly
                                            >


                                            <button
                                                type="button"
                                                class="quantidade-btn quantidade-mais"
                                                title="Aumentar quantidade"
                                            >

                                                <i class="bi bi-plus"></i>

                                            </button>


                                        </div>


                                        <button
                                            type="submit"
                                            class="btn-adicionar"
                                            title="Adicionar ao carrinho"
                                        >

                                            <i class="bi bi-bag-plus"></i>

                                        </button>


                                    </form>

                                @else

                                    <button
                                        type="button"
                                        class="btn-adicionar btn-esgotado"
                                        disabled
                                        title="Produto esgotado"
                                    >

                                        <i class="bi bi-bag-x"></i>

                                    </button>

                                @endif


                            </div>


                        </div>


                    </article>


                @endforeach


            </div>


            @if ($produtos->hasPages())


                <div class="paginacao-container">


                    <div class="paginacao-info">

                        Página

                        <strong>
                            {{ $produtos->currentPage() }}
                        </strong>

                        de

                        <strong>
                            {{ $produtos->lastPage() }}
                        </strong>

                    </div>


                    <nav class="paginacao">


                        @if ($produtos->onFirstPage())

                            <span
                                class="pagina-botao pagina-disabled"
                            >

                                <i class="bi bi-chevron-left"></i>

                            </span>

                        @else

                            <a
                                href="{{ $produtos->previousPageUrl() }}"
                                class="pagina-botao"
                            >

                                <i class="bi bi-chevron-left"></i>

                            </a>

                        @endif


                        @php

                            $inicio = max(
                                1,
                                $produtos->currentPage() - 2
                            );

                            $fim = min(
                                $produtos->lastPage(),
                                $produtos->currentPage() + 2
                            );

                        @endphp


                        @for ($pagina = $inicio; $pagina <= $fim; $pagina++)


                            @if ($pagina == $produtos->currentPage())

                                <span
                                    class="pagina-numero pagina-ativa"
                                >

                                    {{ $pagina }}

                                </span>

                            @else

                                <a
                                    href="{{ $produtos->url($pagina) }}"
                                    class="pagina-numero"
                                >

                                    {{ $pagina }}

                                </a>

                            @endif


                        @endfor


                        @if ($produtos->hasMorePages())

                            <a
                                href="{{ $produtos->nextPageUrl() }}"
                                class="pagina-botao"
                            >

                                <i class="bi bi-chevron-right"></i>

                            </a>

                        @else

                            <span
                                class="pagina-botao pagina-disabled"
                            >

                                <i class="bi bi-chevron-right"></i>

                            </span>

                        @endif


                    </nav>


                </div>


            @endif


        @else


            <div class="produtos-vazio">


                <div class="vazio-icone">

                    <i class="bi bi-bag"></i>

                </div>


                <span>
                    CATÁLOGO
                </span>


                <h2>
                    Nenhum produto encontrado
                </h2>


                @if (
                    request()->filled('busca') ||
                    request()->filled('categoria') ||
                    request()->filled('marca')
                )

                    <p>
                        Nenhum produto corresponde aos filtros selecionados.
                    </p>

                    <a
                        href="{{ route('site.produtos') }}"
                        class="btn-remover-filtros"
                    >

                        Limpar filtros

                    </a>

                @else

                    <p>
                        Ainda não há produtos cadastrados.
                    </p>

                @endif


            </div>


        @endif


    </section>


</main>


@include('components.footer')


<script>

document.addEventListener('DOMContentLoaded', function () {

    const toast =
        document.querySelector('.toast-carrinho');

    if (toast) {

        const botaoFechar =
            toast.querySelector('.toast-close');

        function fecharToast() {

            toast.classList.add(
                'toast-saindo'
            );

            setTimeout(function () {

                toast.remove();

            }, 300);

        }

        if (botaoFechar) {

            botaoFechar.addEventListener(
                'click',
                fecharToast
            );

        }

        setTimeout(function () {

            if (
                document.body.contains(
                    toast
                )
            ) {

                fecharToast();

            }

        }, 3500);

    }


    document
        .querySelectorAll(
            '.produto-compra-form'
        )
        .forEach(function (form) {

            const input =
                form.querySelector(
                    '.quantidade-input'
                );

            const botaoMenos =
                form.querySelector(
                    '.quantidade-menos'
                );

            const botaoMais =
                form.querySelector(
                    '.quantidade-mais'
                );


            if (
                !input ||
                !botaoMenos ||
                !botaoMais
            ) {
                return;
            }


            function atualizarBotoes() {

                const quantidade =
                    parseInt(input.value);

                const minimo =
                    parseInt(input.min);

                const maximo =
                    parseInt(input.max);

                botaoMenos.disabled =
                    quantidade <= minimo;

                botaoMais.disabled =
                    quantidade >= maximo;

            }


            botaoMais.addEventListener(
                'click',
                function () {

                    let quantidade =
                        parseInt(input.value);

                    const maximo =
                        parseInt(input.max);

                    if (
                        quantidade <
                        maximo
                    ) {

                        quantidade++;

                        input.value =
                            quantidade;

                    }

                    atualizarBotoes();

                }
            );


            botaoMenos.addEventListener(
                'click',
                function () {

                    let quantidade =
                        parseInt(input.value);

                    const minimo =
                        parseInt(input.min);

                    if (
                        quantidade >
                        minimo
                    ) {

                        quantidade--;

                        input.value =
                            quantidade;

                    }

                    atualizarBotoes();

                }
            );


            atualizarBotoes();

        });

});

</script>


@endsection