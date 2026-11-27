@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/networth.css') }}">
@endpush

@section('content')
<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="dash-page nw-page">

            {{-- CABEÇALHO --}}
            <header class="dash-header">

                <div class="dash-header-texto">
                    <span class="breadcrumb-admin">
                        Painel >
                        <strong>Fluxo de caixa</strong>
                    </span>

                    <h1>Gerenciar fluxo de caixa</h1>

                    <p>
                        Data atual de registro:
                        <strong>{{ \Carbon\Carbon::parse($hoje)->format('d/m/Y') }}</strong>
                    </p>
                </div>

                <div class="dash-header-acoes">
                    <a href="{{ route('admin.dashboard') }}" class="dash-btn dash-btn-claro">
                        <i class="bi bi-arrow-left"></i>
                        Voltar ao dashboard
                    </a>
                </div>

            </header>

            @if(session('success'))
                <div class="nw-alerta nw-alerta-sucesso alert-success">
                    <i class="bi bi-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="nw-alerta nw-alerta-erro alert-error">
                    <i class="bi bi-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- RESUMO DO DIA --}}
            <section class="dash-resumo networth-resumo">

                <article class="dash-card dash-hero">
                    <span class="dash-hero-rotulo">Networth atual</span>

                    <strong class="dash-hero-valor text-networth">
                        R$ {{ number_format($registroHoje->networth ?? 0, 2, ',', '.') }}
                    </strong>

                    <small class="dash-hero-legenda">Ganhos - Custos (Hoje)</small>
                </article>

                <article class="dash-card dash-stat">
                    <div class="dash-stat-topo">
                        <span class="dash-stat-icone"><i class="bi bi-graph-up-arrow"></i></span>
                        <span class="dash-stat-rotulo">Ganhos hoje</span>
                    </div>

                    <strong class="dash-stat-valor text-ganho">
                        R$ {{ number_format($registroHoje->ganho ?? 0, 2, ',', '.') }}
                    </strong>

                    <small class="dash-stat-legenda">entradas do dia</small>
                </article>

                <article class="dash-card dash-stat dash-stat-destaque">
                    <div class="dash-stat-topo">
                        <span class="dash-stat-icone"><i class="bi bi-graph-down-arrow"></i></span>
                        <span class="dash-stat-rotulo">Custos hoje</span>
                    </div>

                    <strong class="dash-stat-valor text-custo">
                        R$ {{ number_format($registroHoje->custo ?? 0, 2, ',', '.') }}
                    </strong>

                    <small class="dash-stat-legenda">saídas do dia</small>
                </article>

            </section>

            {{-- FORMULÁRIOS --}}
            <section class="nw-formularios networth-formularios">

                <!-- FORMULÁRIO 1: ADICIONAR GANHO -->
                <article class="dash-card nw-form-card ganho-card">

                    <div class="dash-card-cabecalho">
                        <span class="dash-card-titulo">
                            <i class="bi bi-plus-circle"></i>
                            Adicionar ganho
                        </span>
                    </div>

                    <form action="{{ route('admin.networth.ganho.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="valor_ganho">Valor do ganho (R$)</label>

                            <div class="nw-input">
                                <span>R$</span>
                                <input type="number" name="valor_ganho" id="valor_ganho" step="0.01" min="0.01" required placeholder="Ex: 150.00">
                            </div>
                        </div>

                        <button type="submit" class="btn-submit btn-ganho">
                            <i class="bi bi-plus-lg"></i>
                            Somar ganho
                        </button>
                    </form>

                </article>

                <!-- FORMULÁRIO 2: ADICIONAR CUSTO -->
                <article class="dash-card nw-form-card custo-card">

                    <div class="dash-card-cabecalho">
                        <span class="dash-card-titulo">
                            <i class="bi bi-dash-circle"></i>
                            Adicionar custo
                        </span>
                    </div>

                    <form action="{{ route('admin.networth.custo.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="valor_custo">Valor do custo (R$)</label>

                            <div class="nw-input">
                                <span>R$</span>
                                <input type="number" name="valor_custo" id="valor_custo" step="0.01" min="0.01" required placeholder="Ex: 50.00">
                            </div>
                        </div>

                        <button type="submit" class="btn-submit btn-custo">
                            <i class="bi bi-dash-lg"></i>
                            Somar custo
                        </button>
                    </form>

                </article>

            </section>

        </main>

    </div>

</div>
@endsection
