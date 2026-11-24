@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')
<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="dash-page">

            {{-- CABEÇALHO --}}
            <header class="dash-header">

                <div class="dash-header-texto">
                    <span class="breadcrumb-admin">
                        Painel >
                        <strong>Dashboard</strong>
                    </span>

                    <h1>Visão geral</h1>

                    <p>
                        <span id="dashboard-date">Carregando data...</span>
                        <span class="dash-separador">·</span>
                        <span id="dashboard-time">--:--</span>
                    </p>
                </div>

                <div class="dash-header-acoes">

                    <label class="dash-select" for="card-periodo-select">
                        <i class="bi bi-calendar3"></i>
                        <select id="card-periodo-select" aria-label="Período">
                            <option value="dia">Hoje (por hora)</option>
                            <option value="semana" selected>Últimos 7 dias</option>
                            <option value="mes">Últimos 30 dias</option>
                        </select>
                    </label>

                    <a href="{{ route('admin.networth.gerenciar') }}" class="dash-btn dash-btn-escuro">
                        Gerenciar custos
                        <i class="bi bi-plus-lg"></i>
                    </a>

                </div>

            </header>


            {{-- LINHA 1: RESUMO --}}
            <section class="dash-resumo">

                <article class="dash-card dash-hero">

                    <span class="dash-hero-rotulo">Fluxo de caixa (networth)</span>

                    <strong class="dash-hero-valor" id="dashboard-networth">R$ 0,00</strong>

                    <small class="dash-hero-legenda" id="dashboard-networth-label">Ganhos - Custos (Hoje)</small>

                    <div class="dash-hero-rodape">
                        <div class="dash-hero-texto">
                            <span id="hero-progresso-texto">0 de 0 dias no positivo</span>
                        </div>

                        <div class="dash-hero-barra">
                            <div class="dash-barra">
                                <div class="dash-barra-preenchida" id="hero-progresso"></div>
                            </div>
                            <span class="dash-pilula" id="hero-percentual">0%</span>
                        </div>
                    </div>

                </article>


                <article class="dash-card dash-stat">

                    <div class="dash-stat-topo">
                        <span class="dash-stat-icone"><i class="bi bi-graph-up-arrow"></i></span>
                        <span class="dash-stat-rotulo" id="stat-melhor-rotulo">Melhor dia</span>
                    </div>

                    <strong class="dash-stat-valor" id="stat-melhor-valor">R$ 0,00</strong>

                    <small class="dash-stat-legenda" id="stat-melhor-data">—</small>

                </article>


                <article class="dash-card dash-stat dash-stat-destaque">

                    <div class="dash-stat-topo">
                        <span class="dash-stat-icone"><i class="bi bi-bar-chart"></i></span>
                        <span class="dash-stat-rotulo" id="stat-media-rotulo">Média por dia</span>
                    </div>

                    <strong class="dash-stat-valor" id="stat-media-valor">R$ 0,00</strong>

                    <small class="dash-stat-legenda" id="stat-media-legenda">no período</small>

                </article>

            </section>


            {{-- LINHA 2: GRÁFICO + DESTAQUES --}}
            <section class="dash-meio">

                <article class="dash-card dash-grafico">

                    <div class="dash-card-cabecalho">
                        <span class="dash-card-titulo">
                            <i class="bi bi-bar-chart-line"></i>
                            Evolução do fluxo de caixa
                        </span>

                        <span class="dash-chip-periodo" id="chart-periodo">Últimos 7 dias</span>
                    </div>

                    <div class="dash-grafico-total">
                        <strong id="chart-total">R$ 0,00</strong>
                        <small>Desempenho financeiro líquido no período</small>
                    </div>

                    <div class="dash-grafico-area">
                        <canvas id="grafico-faturamento"></canvas>
                    </div>

                </article>


                <article class="dash-card dash-destaques">

                    <div class="dash-card-cabecalho">
                        <span class="dash-card-titulo">
                            <i class="bi bi-exclamation-circle"></i>
                            Atenção ao caixa
                        </span>
                    </div>

                    <div class="dash-destaque-box" id="destaque-box">

                        <div class="dash-destaque-topo">
                            <span class="dash-stat-icone" id="destaque-icone"><i class="bi bi-arrow-down-right"></i></span>

                            <div>
                                <strong id="destaque-titulo">Pior dia do período</strong>
                                <small id="destaque-data">—</small>
                            </div>
                        </div>

                        <strong class="dash-destaque-valor" id="destaque-valor">R$ 0,00</strong>

                        <span class="dash-chip" id="destaque-chip">—</span>

                        <p class="dash-destaque-meta" id="destaque-meta">—</p>

                    </div>

                    <div class="dash-destaque-botoes">
                        <a href="{{ route('admin.networth.gerenciar') }}" class="dash-btn dash-btn-escuro">
                            Gerenciar custos
                        </a>

                        <a href="{{ route('admin.agendamentos') }}" class="dash-btn dash-btn-claro">
                            Ver agendamentos
                        </a>
                    </div>

                </article>

            </section>


            {{-- LINHA 3: TABELA --}}
            <section class="dash-card dash-tabela-card">

                <div class="dash-card-cabecalho">
                    <span class="dash-card-titulo">
                        <i class="bi bi-receipt"></i>
                        Movimentação do período
                    </span>

                    <a href="{{ route('admin.networth.gerenciar') }}" class="dash-btn dash-btn-claro dash-btn-pequeno">
                        Ver custos
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="dash-tabela-scroll">
                    <table class="dash-tabela">
                        <thead>
                            <tr>
                                <th id="tabela-coluna-data">Data</th>
                                <th>Valor líquido</th>
                                <th>Variação</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tabela-movimentacao">
                            <tr>
                                <td colspan="4" class="dash-tabela-vazio">Carregando...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </section>

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/admin/dashboard.js') }}"></script>

@endsection