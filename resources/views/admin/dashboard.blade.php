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

                    <strong>
                        Dashboard
                    </strong>

                </span>


                <h2 id="dashboard-date">
                    Carregando data...
                </h2>


                <h1 id="dashboard-time">
                    --:--
                </h1>

            </div>



            <section class="dashboard-cards">


                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <span>
                            Faturamento
                        </span>

                        <select disabled>

                            <option>
                                Hoje
                            </option>

                        </select>

                    </div>


                    <strong
                        class="dashboard-card-value"
                        id="dashboard-faturamento"
                    >
                        R$ 0,00
                    </strong>


                    <small>
                        Produtos vendidos + serviços concluídos
                    </small>

                </div>



                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <span>
                            Serviços concluídos
                        </span>

                        <select disabled>

                            <option>
                                Hoje
                            </option>

                        </select>

                    </div>


                    <strong
                        class="dashboard-card-value"
                        id="dashboard-servicos"
                    >
                        0
                    </strong>


                    <small>
                        Atendimentos concluídos hoje
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


                                <select disabled>

                                    <option>
                                        Hoje
                                    </option>

                                </select>

                            </div>


                            <p>
                                Produtos vendidos e serviços concluídos
                            </p>

                        </div>


                        <span>

                            {{ now()->format('d/m/Y') }}

                            <i class="bi bi-calendar3"></i>

                        </span>

                    </div>



                    <div class="chart-area">

                        <canvas
                            id="grafico-faturamento"
                        ></canvas>

                    </div>


                </div>


            </section>


        </main>

    </div>

</div>



<script
    src="https://cdn.jsdelivr.net/npm/chart.js"
></script>


<script
    src="{{ asset('js/admin/dashboard.js') }}"
></script>


@endsection