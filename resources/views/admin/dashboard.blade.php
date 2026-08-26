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

                <h2 id="dashboard-date">
                 
                </h2>

                <h1 id="dashboard-time">
                    
                </h1>

            </div>

            <section class="dashboard-cards">

                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <span>
                            Faturamento de hoje
                        </span>

                        <select>
                            <option>hoje</option>
                        </select>

                    </div>

                    <strong class="dashboard-card-value">
                        R$ 3.840
                    </strong>

                    <small class="positive">
                        ↑ 4,9%
                        <span>
                            em comparação com o período anterior
                        </span>
                    </small>

                </div>

                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <span>
                            Lucro de hoje
                        </span>

                        <select>
                            <option>hoje</option>
                        </select>

                    </div>

                    <strong class="dashboard-card-value">
                        R$ 3.840
                    </strong>

                    <small class="positive">
                        ↑ 4,9%
                        <span>
                            em comparação com o período anterior
                        </span>
                    </small>

                </div>

                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <span>
                            Atendimentos a realizar hoje
                        </span>

                        <select>
                            <option>hoje</option>
                        </select>

                    </div>

                    <strong class="dashboard-card-value">
                        3
                    </strong>

                </div>

                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <span>
                            Estoque
                        </span>

                        <span class="stock-badge">
                            Baixo
                        </span>

                    </div>

                    <strong class="dashboard-card-value">
                        12
                    </strong>

                    <small class="negative">
                        ↓ 14,1%
                        <span>
                            em comparação com o período anterior
                        </span>
                    </small>

                </div>

                <div class="dashboard-card">

                    <div class="dashboard-card-header">
                        <span>
                            Agendamentos a confirmar
                        </span>
                    </div>

                    <strong class="dashboard-card-value">
                        2
                    </strong>

                </div>

                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <span>
                            Produtos vendidos esta semana
                        </span>

                        <select>
                            <option>semana</option>
                        </select>

                    </div>

                    <strong class="dashboard-card-value">
                        37
                    </strong>

                    <small class="positive">
                        ↑ 4,9%
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

                    <select>
                        <option>Faturamento</option>
                    </select>

                </div>

                <p>
                    Últimos 7 dias
                </p>

            </div>

            <span>

                18/08/2026

                <i class="bi bi-calendar3"></i>

            </span>

        </div>

        <div class="chart-area">

            <canvas id="faturamentoChart"></canvas>

        </div>

    </div>


    <div class="chart-card services-chart">

        <div class="chart-header">

            <div>

                <h3>
                    Serviços mais vendidos
                </h3>

                <p>
                    No mês
                </p>

            </div>

            <select>
                <option>mês</option>
            </select>

        </div>


        <div class="service-bars">

            <div class="service-item">

                <span>Coloração</span>

                <div class="bar">
                    <div style="width: 94%"></div>
                </div>

            </div>


            <div class="service-item">

                <span>Corte feminino</span>

                <div class="bar">
                    <div style="width: 82%"></div>
                </div>

            </div>


            <div class="service-item">

                <span>Mechas</span>

                <div class="bar">
                    <div style="width: 49%"></div>
                </div>

            </div>


            <div class="service-item">

                <span>Manicure</span>

                <div class="bar">
                    <div style="width: 86%"></div>
                </div>

            </div>


            <div class="service-item">

                <span>Maquiagem</span>

                <div class="bar">
                    <div style="width: 35%"></div>
                </div>

            </div>

        </div>

    </div>

</section>

        </main>

    </div>

</div>


@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ asset('js/admin/dashboard.js') }}"></script>

@endpush