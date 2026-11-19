@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')
@php
    $iaEstaAtiva = isset($iaAtiva)
        ? (bool) $iaAtiva
        : \App\Http\Middleware\VerificarPaginaIaAtiva::estaAtiva();
@endphp

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

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 20px; padding: 12px 16px; border-radius: 8px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

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

                <div class="dashboard-card ia-control-card">

                    <div class="dashboard-card-header">
                        <span>Página Provador de Estilo (IA)</span>
                        <span style="font-weight: 600; color: {{ $iaEstaAtiva ? '#198754' : '#dc3545' }};">
                            <i class="bi {{ $iaEstaAtiva ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                            {{ $iaEstaAtiva ? 'Ativa' : 'Desativada' }}
                        </span>
                    </div>

                    <p style="margin: 10px 0 16px 0; font-size: 0.92rem; opacity: 0.85;">
                        {{ $iaEstaAtiva
                            ? 'A página de IA está aberta para os usuários.'
                            : 'A página de IA está bloqueada para os usuários não administradores.' }}
                    </p>

                    <form action="{{ route('admin.ia.toggle') }}" method="POST">
                        @csrf
                        <button type="submit" class="link-gerenciar" style="border: none; cursor: pointer; background: transparent; padding: 0; font-size: 0.95rem; font-weight: 600;">
                            <i class="bi {{ $iaEstaAtiva ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                            {{ $iaEstaAtiva ? 'Desativar página IA' : 'Ativar página IA' }}
                        </button>
                    </form>

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