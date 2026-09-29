@extends('layouts.app')

@push('css')

<link
    rel="stylesheet"
    href="{{ asset('css/carrinho.css') }}"
>

@endpush


@section('content')

@include('components.navbar')


<main class="carrinho-page">


    <div class="carrinho-header">

        <h1>
            Meu Carrinho
        </h1>

        <p>
            Confira seus produtos antes de finalizar.
        </p>

    </div>


    @if(session('success'))

        <div class="carrinho-alert success">
            {{ session('success') }}
        </div>

    @endif


    @if(session('erro'))

        <div class="carrinho-alert error">
            {{ session('erro') }}
        </div>

    @endif

    @if(session('avisos'))
        <div class="carrinho-alert error">
            @foreach(session('avisos') as $aviso)
                <p>
                    <i class="bi bi-exclamation-triangle"></i>
                    {{ $aviso }}
                </p>
            @endforeach
        </div>
    @endif


    @if($errors->any())

        <div class="carrinho-alert error">

            @foreach($errors->all() as $erro)

                <p>
                    {{ $erro }}
                </p>

            @endforeach

        </div>

    @endif


    @if(count($linhas) > 0)


        <div class="carrinho-layout">


            <section class="carrinho-itens">


                @foreach($linhas as $linha)


                    <article class="carrinho-item" id="item-carrinho-{{ $linha['item']->item_id }}">


                        <img
                            src="{{ asset(
                                'images/produtos/' .
                                $linha['item']->foto
                            ) }}"
                            alt="{{ $linha['item']->nome }}"
                        >


                        <div class="carrinho-item-info">

                            <h2>
                                {{ $linha['item']->nome }}
                            </h2>

                            @if($linha['item']->desconto_ativo)
                                <span style="display: flex; flex-direction: column; gap: 2px;">
                                    <small style="text-decoration: line-through; color: #999; font-size: 0.8em; line-height: 1;">
                                        R$ {{ number_format($linha['item']->preco, 2, ',', '.') }}
                                    </small>
                                    <span style="color: #28a745; font-weight: bold;">
                                        R$ {{ number_format($linha['item']->preco_final, 2, ',', '.') }}
                                    </span>
                                </span>
                            @else
                                <span>
                                    R$ {{ number_format($linha['item']->preco, 2, ',', '.') }}
                                </span>
                            @endif

                            <small>

                                Estoque disponível:

                                {{ $linha['item']->estoque }}

                            </small>

                        </div>


                        <form
                            action="{{ route(
                                'carrinho.atualizar',
                                $linha['item']->item_id
                            ) }}"
                            method="POST"
                            class="carrinho-quantidade-form"
                        >

                            @csrf
                            @method('PATCH')


                            <div class="quantidade-box">


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
                                    min="1"
                                    max="{{ $linha['item']->estoque }}"
                                    value="{{ $linha['quantidade'] }}"
                                    readonly
                                    required
                                >


                                <button
                                    type="button"
                                    class="quantidade-btn quantidade-mais"
                                    title="Aumentar quantidade"
                                >

                                    <i class="bi bi-plus"></i>

                                </button>


                            </div>

                        </form>


                        <strong class="carrinho-subtotal" id="subtotal-{{ $linha['item']->item_id }}">

                            R$
                            {{
                                number_format(
                                    $linha['subtotal'],
                                    2,
                                    ',',
                                    '.'
                                )
                            }}

                        </strong>


                        <form
                            action="{{ route(
                                'carrinho.remover',
                                $linha['item']->item_id
                            ) }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')


                            <button
                                type="submit"
                                class="btn-remover"
                                title="Remover"
                            >

                                <i class="bi bi-trash"></i>

                            </button>


                        </form>


                    </article>


                @endforeach


            </section>


            <aside class="carrinho-resumo">


                <h2>
                    Resumo do pedido
                </h2>

                @if(isset($temDescontoAniversario) && $temDescontoAniversario)
                    <div>
                        <strong>🎉 Parabéns!</strong><br>
                        Hoje é seu aniversário. Aplicamos <strong>{{ $valorDescontoPercentual }}% de desconto</strong> no seu pedido!
                    </div>
                @endif

                <div class="resumo-linha">

                    <span>
                        Total
                    </span>

                    <strong id="valor-total-carrinho">

                        R$
                        {{
                            number_format(
                                $total,
                                2,
                                ',',
                                '.'
                            )
                        }}

                    </strong>

                </div>


                <form action="{{ route('carrinho.finalizar') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-finalizar">
                        <i class="bi bi-check-circle"></i>
                        Finalizar Compra
                    </button>
                </form>


                <a
                    href="{{ route('site.produtos') }}"
                    class="continuar-comprando"
                >

                    Continuar comprando

                </a>


            </aside>


        </div>


    @else


        <div class="carrinho-vazio">


            <i class="bi bi-bag"></i>


            <h2>
                Seu carrinho está vazio
            </h2>


            <p>
                Adicione produtos para continuar.
            </p>


            <a href="{{ route('site.produtos') }}">
                Ver produtos
            </a>


        </div>


    @endif


</main>


@include('components.footer')


<script src="{{ asset('js/carrinho.js') }}"></script>


@endsection