@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/produtos.css') }}">
@endpush

@section('content')

@include('components.navbar')


<section class="banner-produtos">

    <img
        src="{{ asset('images/banner-produtos.png') }}"
        alt="Produtos Sempre Diva"
    >

</section>


@if(session('success'))

    <div class="produto-alert sucesso">
        {{ session('success') }}
    </div>

@endif


@if($errors->any())

    <div class="produto-alert erro">

        @foreach($errors->all() as $erro)

            <p>
                {{ $erro }}
            </p>

        @endforeach

    </div>

@endif


<div class="produtos-acoes">

    <span>
        {{ $produtos->count() }} produto(s)
    </span>

    <a
        href="{{ route('carrinho.index') }}"
        class="btn-ver-carrinho"
    >
        <i class="bi bi-bag"></i>

        Ver Carrinho
    </a>

</div>


<section class="produtos-container">

    @forelse($produtos as $produto)

        <div class="produto-card">


            <div class="produto-imagem-container">

                @if($produto->foto)

                    <img
                        src="{{ asset('storage/' . $produto->foto) }}"
                        alt="{{ $produto->nome }}"
                    >

                @else

                    <img
                        src="{{ asset('images/produto.png') }}"
                        alt="{{ $produto->nome }}"
                    >

                @endif


                @if($produto->estoque <= 0)

                    <span class="produto-esgotado">
                        Esgotado
                    </span>

                @endif

            </div>


            @if($produto->categorias)

                <span class="produto-categoria">
                    {{ $produto->categorias->nome }}
                </span>

            @endif


            <h3>
                {{ $produto->nome }}
            </h3>


            @if($produto->marcas)

                <span class="produto-marca">
                    {{ $produto->marcas->nome }}
                </span>

            @endif


            <p class="produto-preco">

                R$
                {{
                    number_format(
                        $produto->preco,
                        2,
                        ',',
                        '.'
                    )
                }}

            </p>


            @if($produto->estoque > 0)

                <span class="produto-estoque">
                    {{ $produto->estoque }} em estoque
                </span>


                <form
                    action="{{ route(
                        'carrinho.adicionar',
                        $produto->item_id
                    ) }}"
                    method="POST"
                    class="produto-form-compra"
                >

                    @csrf


                    <div class="produto-quantidade">

                        <label for="quantidade-{{ $produto->item_id }}">
                            Quantidade
                        </label>

                        <input
                            type="number"
                            id="quantidade-{{ $produto->item_id }}"
                            name="quantidade"
                            value="1"
                            min="1"
                            max="{{ $produto->estoque }}"
                            required
                        >

                    </div>


                    <button type="submit">

                        <i class="bi bi-bag-plus"></i>

                        Adicionar ao carrinho

                    </button>

                </form>

            @else

                <span class="produto-estoque sem-estoque">
                    Sem estoque
                </span>

                <button
                    type="button"
                    disabled
                    class="btn-indisponivel"
                >
                    Produto indisponível
                </button>

            @endif


        </div>

    @empty

        <div class="nenhum-produto">

            <i class="bi bi-bag-x"></i>

            <h2>
                Nenhum produto disponível
            </h2>

            <p>
                Ainda não há produtos cadastrados.
            </p>

        </div>

    @endforelse

</section>


@include('components.footer')

@endsection