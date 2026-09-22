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

        <main class="dashboard-content">

            <div class="dashboard-header">
                <span class="breadcrumb-admin">
                    Painel >
                    <strong>Dashboard</strong>
                </span>
                
                <h2 id="dashboard-date">Carregando data...</h2>
                <h1 id="dashboard-time">--:--</h1>
            </div>

            <section class="dashboard-cards">

                <div class="dashboard-card networth-card">
                    
                    <div class="dashboard-card-header">
                        <span>Fluxo de Caixa (Networth)</span>
                        <select id="card-periodo-select" class="filtro-select">
                            <option value="dia">Hoje (Por Hora)</option>
                            <option value="semana" selected>Últimos 7 dias</option>
                            <option value="mes">Últimos 30 dias</option>
                        </select>
                    </div>
                    
                    <strong class="dashboard-card-value text-networth" id="dashboard-networth">
                        R$ 0,00
                    </strong>
                    
                    <small id="dashboard-networth-label">Ganhos - Custos (Hoje)</small>
                    
                    <a href="{{ route('admin.networth.gerenciar') }}" class="link-gerenciar">
                        Gerenciar Custos
                    </a>
                    
                </div>

            </section>

            <section class="dashboard-charts">

                <div class="chart-card networth-chart">
                    
                    <div class="chart-header">
                        <div>
                            <div class="chart-title-row">
                                <h3>Evolução do Fluxo de Caixa</h3>
                                
                                <select id="filtro-periodo" class="filtro-select">
                                    <option value="dia">Hoje (Por Hora)</option>
                                    <option value="semana" selected>Últimos 7 dias</option>
                                    <option value="mes">Últimos 30 dias</option>
                                </select>
                            </div>
                            
                            <p>Desempenho financeiro líquido</p>
                        </div>
                        
                        <span>
                            {{ now()->format('d/m/Y') }}
                            <i class="bi bi-calendar3"></i>
                        </span>
                    </div>

                    <div class="chart-area">
                        <canvas id="grafico-faturamento"></canvas>
                    </div>
                    
                </div>

            </section>
            
        </main>
        
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/admin/dashboard.js') }}"></script>

@endsection