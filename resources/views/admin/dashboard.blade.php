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

@endpush


@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="dashboard-content">

            <div class="dashboard-header">

                <span class="breadcrumb-admin">
                    Painel >
                    <strong>Dashboard</strong>
                </span>

                <h2 id="dashboard-date"></h2>

                <h1 id="dashboard-time"></h1>

            </div>


            <section class="dashboard-cards">

                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <span>
                            Faturamento
                        </span>

                        <select class="dashboard-filter">

                            <option value="hoje">
                                Hoje
                            </option>

                            <option value="semana">
                                Semana
                            </option>

                            <option value="mes">
                                Mês
                            </option>

                        </select>

                    </div>

                    <strong
                        class="dashboard-card-value"
                        id="faturamento"
                    >
                        R$ {{ number_format(
                            $dashboard['faturamento'],
                            2,
                            ',',
                            '.'
                        ) }}
                    </strong>

                    <small class="positive">

                        ↑

                        <span id="porcentagem-faturamento">
                            {{ $dashboard['porcentagemFaturamento'] }}%
                        </span>

                        <span>
                            em comparação com o período anterior
                        </span>

                    </small>

                </div>


                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <span>
                            Lucro
                        </span>

                        <select class="dashboard-filter">

                            <option value="hoje">
                                Hoje
                            </option>

                            <option value="semana">
                                Semana
                            </option>

                            <option value="mes">
                                Mês
                            </option>

                        </select>

                    </div>

                    <strong
                        class="dashboard-card-value"
                        id="lucro"
                    >
                        R$ {{ number_format(
                            $dashboard['lucro'],
                            2,
                            ',',
                            '.'
                        ) }}
                    </strong>

                    <small class="positive">

                        ↑

                        <span id="porcentagem-lucro">
                            {{ $dashboard['porcentagemLucro'] }}%
                        </span>

                        <span>
                            em comparação com o período anterior
                        </span>

                    </small>

                </div>

            </section>


            <section class="dashboard-charts">

                <div class="chart-card revenue-chart">

                    <div class="chart-header">

                        <div>

                            <div class="chart-title-row">

                                <h3>
                                    Faturamento
                                </h3>

                                <select id="grafico-periodo">

                                    <option value="hoje">
                                        Hoje
                                    </option>

                                    <option value="semana">
                                        Últimos 7 dias
                                    </option>

                                    <option value="mes">
                                        Mês
                                    </option>

                                </select>

                            </div>

                            <p id="grafico-descricao">
                                Hoje
                            </p>

                        </div>


                        <div class="chart-date">

                            <button
                                type="button"
                                id="calendar-button"
                                class="calendar-button"
                            >

                                <span id="selected-date"></span>

                                <i class="bi bi-calendar3"></i>

                            </button>

                            <input
                                type="date"
                                id="dashboard-calendar"
                                class="dashboard-calendar"
                            >

                        </div>

                    </div>


                    <div class="chart-area">

                        <canvas id="faturamentoChart"></canvas>

                    </div>

                </div>

            </section>

        </main>

    </div>

</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.dashboardGrafico =
        @json($dashboard['grafico']);

</script>

<script src="{{ asset('js/admin/dashboard.js') }}"></script>

@endpush