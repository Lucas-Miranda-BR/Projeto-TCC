@extends('layouts.app')


@push('css')

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>

<link
    rel="stylesheet"
    href="{{ asset('css/notificacoes.css') }}"
>

@endpush


@section('content')


@include('components.navbar')


<main class="notificacoes-page">


    <section class="notificacoes-hero">

        <span class="notificacoes-etiqueta">

            <i class="bi bi-bell"></i>

            Central de Avisos

        </span>


        <h1>
            Suas Notificações
        </h1>


        <p>
            Confira novidades, promoções e informações importantes
            do Salão Sempre Diva.
        </p>

    </section>



    <div class="notificacoes-container">


        @if(session('success'))

            <div class="notificacoes-alert sucesso">

                <i class="bi bi-check-circle"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif



        <div class="notificacoes-topo">


            <div>

                <h2>
                    Caixa de entrada
                </h2>


                <p>

                    Você possui

                    <strong>
                        {{
                            $notificacoes
                                ->where('visualizada', false)
                                ->count()
                        }}
                    </strong>

                    {{
                        $notificacoes
                            ->where('visualizada', false)
                            ->count() == 1
                            ? 'notificação não visualizada'
                            : 'notificações não visualizadas'
                    }}.

                </p>

            </div>



            @if(
                $notificacoes
                    ->where('visualizada', false)
                    ->count() > 0
            )

                <form
                    action="{{ route(
                        'cliente.notificacoes.visualizar-todas'
                    ) }}"
                    method="POST"
                >

                    @csrf

                    @method('PATCH')


                    <button
                        type="submit"
                        class="btn-visualizar-todas"
                    >

                        <i class="bi bi-check2-all"></i>

                        Marcar todas como lidas

                    </button>

                </form>

            @endif


        </div>



        <div class="notificacoes-lista">


            @forelse($notificacoes as $notificacao)


                <article
                    class="notificacao-card {{
                        !$notificacao->visualizada
                            ? 'nao-visualizada'
                            : ''
                    }}"
                >


                    <div class="notificacao-icone">

                        @if(
                            str_contains(
                                strtolower($notificacao->titulo),
                                'desconto'
                            )
                            ||
                            str_contains(
                                strtolower($notificacao->titulo),
                                'promo'
                            )
                        )

                            <i class="bi bi-gift"></i>

                        @elseif(
                            str_contains(
                                strtolower($notificacao->titulo),
                                'cancel'
                            )
                        )

                            <i class="bi bi-calendar-x"></i>

                        @else

                            <i class="bi bi-bell"></i>

                        @endif

                    </div>



                    <div class="notificacao-conteudo">


                        <div class="notificacao-cabecalho">


                            <div class="notificacao-titulo">


                                <h3>
                                    {{ $notificacao->titulo }}
                                </h3>


                                @if(!$notificacao->visualizada)

                                    <span class="notificacao-nova">
                                        Nova
                                    </span>

                                @endif


                            </div>



                            <span class="notificacao-data">

                                <i class="bi bi-clock"></i>

                                @if($notificacao->data_recebida)

                                    {{
                                        $notificacao
                                            ->data_recebida
                                            ->format('d/m/Y')
                                    }}

                                    às

                                    {{
                                        $notificacao
                                            ->data_recebida
                                            ->format('H:i')
                                    }}

                                @endif

                            </span>


                        </div>



                        <p class="notificacao-texto">

                            {{ $notificacao->conteudo }}

                        </p>



                        @if(!$notificacao->visualizada)

                            <form
                                action="{{ route(
                                    'cliente.notificacoes.visualizar',
                                    $notificacao->notificacao_id
                                ) }}"
                                method="POST"
                                class="form-visualizar"
                            >

                                @csrf

                                @method('PATCH')


                                <button
                                    type="submit"
                                    class="btn-visualizar"
                                >

                                    <i class="bi bi-check2"></i>

                                    Marcar como lida

                                </button>


                            </form>

                        @else

                            <div class="notificacao-lida">

                                <i class="bi bi-check2-all"></i>

                                Visualizada

                            </div>

                        @endif


                    </div>


                </article>


            @empty


                <div class="notificacoes-vazio">


                    <div class="notificacoes-vazio-icone">

                        <i class="bi bi-bell"></i>

                    </div>


                    <h3>
                        Nenhuma notificação por aqui
                    </h3>


                    <p>
                        Quando o salão enviar alguma novidade,
                        promoção ou aviso importante, ele aparecerá
                        nesta página.
                    </p>


                </div>


            @endforelse


        </div>


    </div>


</main>


@include('components.footer')


@endsection