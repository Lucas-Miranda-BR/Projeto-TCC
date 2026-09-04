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

                    <article class="carrinho-item">

                        <img
                            src="{{ asset(
                                'storage/' .
                                $linha['item']->foto
                            ) }}"
                            alt="{{ $linha['item']->nome }}"
                        >


                        <div class="carrinho-item-info">

                            <h2>
                                {{ $linha['item']->nome }}
                            </h2>

                            <span>

                                R$
                                {{
                                    number_format(
                                        $linha['item']->preco,
                                        2,
                                        ',',
                                        '.'
                                    )
                                }}

                            </span>

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
                            class="carrinho-quantidade"
                        >

                            @csrf
                            @method('PATCH')

                            <input
                                type="number"
                                name="quantidade"
                                min="1"
                                max="{{ $linha['item']->estoque }}"
                                value="{{ $linha['quantidade'] }}"
                                required
                            >

                            <button type="submit">
                                Atualizar
                            </button>

                        </form>


                        <strong class="carrinho-subtotal">

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

                <div class="resumo-linha">

                    <span>
                        Total
                    </span>

                    <strong>

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


                @if(session('cliente'))

                    <form
                        action="{{ route('carrinho.finalizar') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn-finalizar"
                        >

                            <i class="bi bi-check-circle"></i>

                            Finalizar Compra

                        </button>

                    </form>

                @else

                    <a
                        href="{{ route('cliente.login') }}"
                        class="btn-finalizar"
                    >
                        Entrar para comprar
                    </a>

                @endif


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

@endsection