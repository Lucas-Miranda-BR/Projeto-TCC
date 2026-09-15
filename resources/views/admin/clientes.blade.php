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
    href="{{ asset('css/admin/clientes.css') }}"
>

@endpush


@section('content')


<div class="admin-layout">


    @include('components.admin.sidebar')


    <div class="admin-main">


        @include('components.admin.navbar')


        <main class="clientes-content">


            <div class="clientes-header">

                <span class="breadcrumb-admin">

                    Painel >

                    <strong>
                        Clientes
                    </strong>

                </span>


                <h1>
                    Gerenciar Clientes
                </h1>


                <p>
                    Visualize os clientes cadastrados e envie notificações personalizadas.
                </p>

            </div>



            @if(session('success'))

                <div class="cliente-alert cliente-alert-success">

                    <i class="bi bi-check-circle"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif



            @if($errors->any())

                <div class="cliente-alert cliente-alert-error">

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



            <section class="clientes-resumo">


                <div class="cliente-resumo-card">

                    <div class="cliente-resumo-icon">

                        <i class="bi bi-people"></i>

                    </div>


                    <div>

                        <span>
                            Clientes cadastrados
                        </span>

                        <strong>
                            {{
                                $clientes
                                    ->count()
                            }}
                        </strong>

                    </div>

                </div>



                <div class="cliente-resumo-card">

                    <div class="cliente-resumo-icon">

                        <i class="bi bi-bell"></i>

                    </div>


                    <div>

                        <span>
                            Comunicação
                        </span>

                        <strong class="texto-resumo">
                            Notificações
                        </strong>

                    </div>

                </div>


            </section>



            <section class="clientes-card">


                <div class="clientes-card-header">


                    <div>

                        <h2>
                            Clientes
                        </h2>

                        <p>
                            Clientes cadastrados no Salão Sempre Diva.
                        </p>

                    </div>



                    <div class="clientes-pesquisa">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="pesquisa-clientes"
                            placeholder="Pesquisar cliente..."
                            autocomplete="off"
                        >

                    </div>


                </div>



                @if($clientes->count() > 0)


                    <div class="clientes-table-container">


                        <table class="clientes-table">


                            <thead>

                                <tr>

                                    <th>
                                        Cliente
                                    </th>

                                    <th>
                                        Contato
                                    </th>

                                    <th>
                                        CPF
                                    </th>

                                    <th>
                                        Nascimento
                                    </th>

                                    <th>
                                        Tipo
                                    </th>

                                    <th>
                                        Ações
                                    </th>

                                </tr>

                            </thead>



                            <tbody id="clientes-tbody">


                                @foreach($clientes as $cliente)


                                    <tr
                                        class="cliente-linha"

                                        data-busca="{{
                                            strtolower(
                                                ($cliente->nome ?? '') .
                                                ' ' .
                                                ($cliente->sobrenome ?? '') .
                                                ' ' .
                                                ($cliente->email ?? '') .
                                                ' ' .
                                                ($cliente->telefone ?? '') .
                                                ' ' .
                                                ($cliente->cpf ?? '')
                                            )
                                        }}"
                                    >


                                        <td>


                                            <div class="cliente-identidade">


                                                <div class="cliente-avatar">

                                                    <div class="cliente-avatar">
                                                        <span>
                                                            {{ 
                                                                strtoupper(
                                                                    mb_substr($cliente->nome ?? '', 0, 1) . 
                                                                    mb_substr($cliente->sobrenome ?? '', 0, 1)
                                                                ) 
                                                            }}
                                                        </span>
                                                    </div>

                                                </div>



                                                <div class="cliente-nome">

                                                    <strong>

                                                        {{
                                                            $cliente->nome
                                                        }}

                                                        {{
                                                            $cliente->sobrenome
                                                        }}

                                                    </strong>


                                                    <span>

                                                        Cliente #{{ $cliente->cliente_id }}

                                                    </span>

                                                </div>


                                            </div>


                                        </td>



                                        <td>


                                            <div class="cliente-contato">


                                                @if($cliente->email)

                                                    <span>

                                                        <i class="bi bi-envelope"></i>

                                                        {{
                                                            $cliente->email
                                                        }}

                                                    </span>

                                                @endif



                                                @if($cliente->telefone)

                                                    <span>

                                                        <i class="bi bi-telephone"></i>

                                                        {{
                                                            $cliente->telefone
                                                        }}

                                                    </span>

                                                @endif


                                            </div>


                                        </td>



                                        <td>

                                            <span class="cliente-cpf">

                                                {{
                                                    $cliente->cpf
                                                    ?? 'Não informado'
                                                }}

                                            </span>

                                        </td>



                                        <td>


                                            @if($cliente->data_nascimento)

                                                <span class="cliente-data">

                                                    {{
                                                        \Carbon\Carbon::parse(
                                                            $cliente->data_nascimento
                                                        )->format('d/m/Y')
                                                    }}

                                                </span>

                                            @else

                                                <span class="cliente-sem-dado">

                                                    Não informado

                                                </span>

                                            @endif


                                        </td>



                                        <td>


                                            @if($cliente->is_admin)

                                                <span class="cliente-tipo admin">

                                                    <i class="bi bi-shield-check"></i>

                                                    Administrador

                                                </span>

                                            @else

                                                <span class="cliente-tipo cliente">

                                                    <i class="bi bi-person"></i>

                                                    Cliente

                                                </span>

                                            @endif


                                        </td>



                                        <td>


                                            @if(!$cliente->is_admin)


                                                <div class="cliente-acoes">


                                                    <button
                                                        type="button"
                                                        class="
                                                            btn-notificar-cliente
                                                            abrir-modal-notificacao
                                                        "

                                                        data-url="{{
                                                            route(
                                                                'admin.clientes.notificacao.enviar',
                                                                $cliente->cliente_id
                                                            )
                                                        }}"

                                                        data-nome="{{
                                                            $cliente->nome .
                                                            ' ' .
                                                            $cliente->sobrenome
                                                        }}"
                                                    >

                                                        <i class="bi bi-bell"></i>

                                                        Notificar

                                                    </button>


                                                </div>


                                            @else


                                                <span class="sem-acao">

                                                    <i class="bi bi-lock"></i>

                                                    Admin

                                                </span>


                                            @endif


                                        </td>


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>


                    </div>



                    <div
                        class="nenhum-resultado"
                        id="nenhum-resultado"
                    >

                        <i class="bi bi-search"></i>

                        <h3>
                            Nenhum cliente encontrado
                        </h3>

                        <p>
                            Tente pesquisar utilizando outro nome,
                            e-mail, telefone ou CPF.
                        </p>

                    </div>


                @else


                    <div class="clientes-vazio">

                        <div class="clientes-vazio-icon">

                            <i class="bi bi-people"></i>

                        </div>

                        <h3>
                            Nenhum cliente cadastrado
                        </h3>

                        <p>
                            Os clientes cadastrados aparecerão aqui.
                        </p>

                    </div>


                @endif


            </section>


        </main>


    </div>


</div>



<div
    class="notificacao-modal-overlay"
    id="notificacao-modal"
>


    <div class="notificacao-modal">


        <div class="notificacao-modal-header">


            <div class="notificacao-modal-icon">

                <i class="bi bi-bell"></i>

            </div>


            <button
                type="button"
                id="fechar-modal-notificacao"
                class="notificacao-modal-fechar"
            >

                <i class="bi bi-x-lg"></i>

            </button>


        </div>



        <div class="notificacao-modal-body">


            <span class="notificacao-modal-etiqueta">
                Comunicação com cliente
            </span>


            <h2>
                Enviar notificação
            </h2>


            <p class="notificacao-destinatario">

                Para:

                <strong id="nome-cliente-notificacao">
                    Cliente
                </strong>

            </p>



            <form
    action=""
    method="POST"
    id="form-enviar-notificacao"
>

    @csrf

    <div class="notificacao-form-group">

        <label for="tipo-notificacao">

            <i class="bi bi-bell"></i>

            Tipo da notificação

        </label>

        <select
            id="tipo-notificacao"
            class="notificacao-select"
        >

            <option value="aviso">
                Aviso
            </option>

            <option value="promocao">
                Promoção / Desconto
            </option>

            <option value="lembrete">
                Lembrete
            </option>

            <option value="cancelamento">
                Cancelamento
            </option>

            <option value="comunicado">
                Comunicado
            </option>

        </select>

    </div>


    <div class="notificacao-form-group">

        <label for="titulo-notificacao">

            <i class="bi bi-type"></i>

            Título

        </label>

        <input
            type="text"
            name="titulo"
            id="titulo-notificacao"
            maxlength="255"
            placeholder="Ex: Aviso importante sobre seu atendimento"
            required
        >

        <div class="campo-contador">

            <span>
                Título da notificação
            </span>

            <strong id="contador-titulo">
                0/255
            </strong>

        </div>

    </div>


    <div class="notificacao-form-group">

        <label for="mensagem-notificacao">

            <i class="bi bi-chat-left-text"></i>

            Mensagem

        </label>

        <textarea
            name="conteudo"
            id="mensagem-notificacao"
            maxlength="255"
            placeholder="Ex: Informamos que o salão não terá atendimento nesta sexta-feira."
            required
        ></textarea>

        <div class="notificacao-contador">

            <span>
                Envie avisos, promoções, lembretes ou comunicados.
            </span>

            <strong id="contador-notificacao">
                0/255
            </strong>

        </div>

    </div>


    <div class="notificacao-preview">

        <div
            class="notificacao-preview-icon"
            id="preview-icone"
        >

            <i class="bi bi-bell"></i>

        </div>

        <div class="notificacao-preview-conteudo">

            <span>
                Pré-visualização
            </span>

            <strong id="preview-titulo">
                Título da notificação
            </strong>

            <p id="preview-mensagem">
                Sua mensagem aparecerá aqui.
            </p>

        </div>

    </div>


    <div class="notificacao-modal-acoes">

        <button
            type="button"
            id="voltar-modal-notificacao"
            class="btn-modal-voltar"
        >
            Voltar
        </button>

        <button
            type="submit"
            class="btn-enviar-notificacao"
        >

            <i class="bi bi-send"></i>

            Enviar notificação

        </button>

    </div>

</form>

        </div>


    </div>


</div>



<script src="{{ asset('js/admin/clientes.js') }}"></script>


@endsection