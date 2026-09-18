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
    href="{{ asset('css/admin/notificacoes.css') }}"
>

@endpush


@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')


    <div class="admin-main">

        @include('components.admin.navbar')


        <main class="notificacoes-admin-content">

            <div class="notificacoes-admin-header">

                <div>

                    <span class="breadcrumb-admin">
                        Painel >
                        <strong>Notificações</strong>
                    </span>


                    <h1>
                        Gerenciar Notificações
                    </h1>


                    <p>
                        Visualize e gerencie as notificações enviadas aos clientes.
                    </p>

                </div>


                <a
                    href="{{ route('admin.clientes') }}"
                    class="btn-nova-notificacao"
                >

                    <i class="bi bi-send"></i>

                    Enviar notificação

                </a>

            </div>


            @if(session('success'))

                <div class="notificacao-alert-success">

                    <i class="bi bi-check-circle"></i>

                    {{ session('success') }}

                </div>

            @endif


            <section class="notificacoes-resumo">

                <div class="notificacao-resumo-card">

                    <i class="bi bi-bell"></i>

                    <div>

                        <span>
                            Total
                        </span>

                        <strong>
                            {{ $notificacoes->count() }}
                        </strong>

                    </div>

                </div>


                <div class="notificacao-resumo-card">

                    <i class="bi bi-envelope"></i>

                    <div>

                        <span>
                            Não visualizadas
                        </span>

                        <strong>
                            {{
                                $notificacoes
                                    ->where('visualizada', false)
                                    ->count()
                            }}
                        </strong>

                    </div>

                </div>


                <div class="notificacao-resumo-card">

                    <i class="bi bi-envelope-check"></i>

                    <div>

                        <span>
                            Visualizadas
                        </span>

                        <strong>
                            {{
                                $notificacoes
                                    ->where('visualizada', true)
                                    ->count()
                            }}
                        </strong>

                    </div>

                </div>

            </section>


            <section class="notificacoes-card">

                <div class="notificacoes-card-header">

                    <div>

                        <h2>
                            Notificações enviadas
                        </h2>

                        <p>
                            Histórico das mensagens enviadas aos clientes.
                        </p>

                    </div>


                    <div class="notificacoes-pesquisa">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="pesquisa-notificacoes"
                            placeholder="Pesquisar notificação..."
                        >

                    </div>

                </div>


                @if($notificacoes->count() > 0)

                    <div class="notificacoes-lista">

                        @foreach($notificacoes as $notificacao)

                            <div
                                class="notificacao-item"
                                data-busca="{{
                                    strtolower(
                                        ($notificacao->titulo ?? '') .
                                        ' ' .
                                        ($notificacao->conteudo ?? '') .
                                        ' ' .
                                        ($notificacao->clientes->nome ?? '') .
                                        ' ' .
                                        ($notificacao->clientes->sobrenome ?? '')
                                    )
                                }}"
                            >

                                <div class="notificacao-item-icon">

                                    @if($notificacao->visualizada)

                                        <i class="bi bi-bell"></i>

                                    @else

                                        <i class="bi bi-bell-fill"></i>

                                    @endif

                                </div>


                                <div class="notificacao-item-conteudo">

                                    <div class="notificacao-item-topo">

                                        <div>

                                            <h3>
                                                {{ $notificacao->titulo }}
                                            </h3>


                                            <span class="notificacao-cliente">

                                                <i class="bi bi-person"></i>

                                                @if($notificacao->clientes)

                                                    {{
                                                        $notificacao->clientes->nome
                                                    }}

                                                    {{
                                                        $notificacao->clientes->sobrenome
                                                    }}

                                                @else

                                                    Cliente não encontrado

                                                @endif

                                            </span>

                                        </div>


                                        @if($notificacao->visualizada)

                                            <span class="status visualizada">

                                                <i class="bi bi-check-circle"></i>

                                                Visualizada

                                            </span>

                                        @else

                                            <span class="status nao-visualizada">

                                                <i class="bi bi-clock"></i>

                                                Não visualizada

                                            </span>

                                        @endif

                                    </div>


                                    <p>
                                        {{ $notificacao->conteudo }}
                                    </p>


                                    <div class="notificacao-item-rodape">

                                        <span>

                                            <i class="bi bi-calendar3"></i>

                                            {{
                                                $notificacao->data_recebida
                                                    ? $notificacao
                                                        ->data_recebida
                                                        ->format('d/m/Y H:i')
                                                    : ''
                                            }}

                                        </span>


                                        <form
                                            action="{{
                                                route(
                                                    'admin.notificacoes.destroy',
                                                    $notificacao->notificacao_id
                                                )
                                            }}"
                                            method="POST"
                                            onsubmit="
                                                return confirm(
                                                    'Deseja realmente excluir esta notificação?'
                                                );
                                            "
                                        >

                                            @csrf
                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="btn-excluir-notificacao"
                                            >

                                                <i class="bi bi-trash"></i>

                                                Excluir

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    <div
                        class="nenhuma-notificacao-pesquisa"
                        id="nenhuma-notificacao-pesquisa"
                    >

                        <i class="bi bi-search"></i>

                        <h3>
                            Nenhuma notificação encontrada
                        </h3>

                    </div>


                @else

                    <div class="notificacoes-vazio">

                        <i class="bi bi-bell-slash"></i>

                        <h2>
                            Nenhuma notificação enviada
                        </h2>

                        <p>
                            As notificações enviadas aos clientes aparecerão aqui.
                        </p>


                        <a href="{{ route('admin.clientes') }}">

                            Enviar primeira notificação

                        </a>

                    </div>

                @endif

            </section>

        </main>

    </div>

</div>


<script src="{{ asset('js/admin/notificacoes.js') }}"></script>

@endsection