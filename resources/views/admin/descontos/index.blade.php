@extends('layouts.app')

@push('css')

<link
    rel="stylesheet"
    href="{{ asset('css/admin/dashboard.css') }}"
>

<link
    rel="stylesheet"
    href="{{ asset('css/admin/descontos.css') }}"
>

@endpush


@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')


        <main class="descontos-content">

            <div class="descontos-header">

                <div>

                    <span class="breadcrumb-admin">
                        Painel >
                        <strong>Descontos</strong>
                    </span>

                    <h1>
                        Gerenciar Descontos
                    </h1>

                    <p>
                        Crie, acompanhe e gerencie as promoções do salão.
                    </p>

                </div>


                <a
                    href="{{ route('admin.descontos.create') }}"
                    class="btn-novo-desconto"
                >
                    <span>+</span>
                    Novo desconto
                </a>

            </div>


            @if(session('success'))

                <div class="desconto-alert desconto-alert-success">
                    {{ session('success') }}
                </div>

            @endif


            @php

                $totalDescontos = $descontos->count();

                $totalFixos = 0;

                $totalPersonalizados = 0;

                foreach ($descontos as $desconto) {

                    $isAniversario =
                        stripos(
                            $desconto->nome,
                            'aniversário'
                        ) !== false;

                    if ($isAniversario) {

                        $totalFixos++;

                    } else {

                        $totalPersonalizados++;

                    }

                }

            @endphp


            <section class="descontos-resumo">


                <div class="desconto-resumo-card">

                    <div class="desconto-resumo-icon">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>

                    <div>

                        <span>
                            Descontos cadastrados
                        </span>

                        <strong>
                            {{ $totalDescontos }}
                        </strong>

                    </div>

                </div>


                <div class="desconto-resumo-card">

                    <div class="desconto-resumo-icon">
                        <i class="bi bi-lock"></i>
                    </div>

                    <div>

                        <span>
                            Descontos fixos
                        </span>

                        <strong>
                            {{ $totalFixos }}
                        </strong>

                    </div>

                </div>


                <div class="desconto-resumo-card">

                    <div class="desconto-resumo-icon">
                        <i class="bi bi-sliders"></i>
                    </div>

                    <div>

                        <span>
                            Personalizados
                        </span>

                        <strong>
                            {{ $totalPersonalizados }}
                        </strong>

                    </div>

                </div>


            </section>


            <section class="descontos-lista-card">

                <div class="descontos-lista-header">

                    <div>

                        <h2>
                            Descontos cadastrados
                        </h2>

                        <p>
                            Consulte e gerencie as regras de desconto.
                        </p>

                    </div>

                </div>


                <div class="descontos-tabela-wrapper">

                    <table class="descontos-tabela">

                        <thead>

                            <tr>

                                <th>
                                    Nome da Regra
                                </th>

                                <th>
                                    Valor (%)
                                </th>

                                <th>
                                    Expira Em
                                </th>

                                <th>
                                    Tipo
                                </th>

                                <th>
                                    Ações
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($descontos as $desconto)

                                @php

                                    $isAniversario =
                                        stripos(
                                            $desconto->nome,
                                            'aniversário'
                                        ) !== false;

                                @endphp


                                <tr>

                                    <td>

                                        <div class="desconto-nome">

                                            <div class="desconto-nome-icon">

                                                @if($isAniversario)

                                                    <i class="bi bi-gift"></i>

                                                @else

                                                    <i class="bi bi-tag"></i>

                                                @endif

                                            </div>


                                            <span>
                                                {{ $desconto->nome }}
                                            </span>

                                        </div>

                                    </td>


                                    <td>

                                        <strong class="desconto-valor">
                                            {{ $desconto->valor }}%
                                        </strong>

                                    </td>


                                    <td>

                                        <span class="desconto-validade">

                                            @if($isAniversario)

                                                Permanente

                                            @else

                                                {{ $desconto->quando_terminar
                                                    ? \Carbon\Carbon::parse(
                                                        $desconto->quando_terminar
                                                    )->format('d/m/Y')
                                                    : 'Permanente'
                                                }}

                                            @endif

                                        </span>

                                    </td>


                                    <td>

                                        @if($isAniversario)

                                            <span class="badge-desconto badge-fixo">

                                                <i class="bi bi-lock"></i>

                                                Fixo

                                            </span>

                                        @else

                                            <span class="badge-desconto badge-personalizado">

                                                <i class="bi bi-sliders"></i>

                                                Personalizado

                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        <div class="desconto-acoes">

                                            <a
                                                href="{{ route(
                                                    'admin.descontos.edit',
                                                    $desconto->desconto_id
                                                ) }}"
                                                class="btn-desconto-editar"
                                                title="Editar"
                                            >

                                                <i class="bi bi-pencil"></i>

                                            </a>


                                            @if(!$isAniversario)

                                                <form
                                                    action="{{ route(
                                                        'admin.descontos.destroy',
                                                        $desconto->desconto_id
                                                    ) }}"
                                                    method="POST"
                                                >

                                                    @csrf

                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        class="btn-desconto-excluir"
                                                        title="Excluir"
                                                        onclick="return confirm('Tem certeza que deseja excluir?');"
                                                    >

                                                        <i class="bi bi-trash"></i>

                                                    </button>

                                                </form>

                                            @endif

                                        </div>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="descontos-vazio"
                                    >

                                        <i class="bi bi-ticket-perforated"></i>

                                        <strong>
                                            Nenhum desconto cadastrado.
                                        </strong>

                                        <span>
                                            Crie seu primeiro desconto para começar.
                                        </span>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>


                    <div class="descontos-paginacao">

                        {{ $descontos->links() }}

                    </div>


                </div>

            </section>

        </main>

    </div>

</div>

@endsection