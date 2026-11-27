@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/agendamento.css') }}">
@endpush

@section('content')

@php
    $listaAgendamentos = isset($agendamentos) ? $agendamentos : collect();
    $totalAgendamentos = $listaAgendamentos->count();
    $hojeIso = date('Y-m-d');
    $qtdHoje = 0;
    $qtdPendentes = 0;
    $qtdConcluidos = 0;

    foreach ($listaAgendamentos as $item) {
        if (date('Y-m-d', strtotime($item->data)) === $hojeIso) { $qtdHoje++; }
        if ($item->status == 1) { $qtdConcluidos++; } else { $qtdPendentes++; }
    }
@endphp

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="agendamentos-content">

            <div class="agendamentos-topo">

                <div class="agendamentos-header">
                    <span class="breadcrumb-admin">
                        Painel >
                        <strong>Agendamentos</strong>
                    </span>

                    <h1>Agendamentos</h1>

                    <p>Gerencie os horários e atendimentos dos clientes.</p>
                </div>

                <div class="agendamentos-acoes">
                    <a href="{{ route('admin.procedimentos.index') }}" class="btn-procedimentos">
                        <i class="bi bi-scissors"></i>
                        Gerenciar Procedimentos
                    </a>
                </div>

            </div>

            @if(session('success'))
                <div class="ag-alerta ag-alerta-sucesso">
                    <i class="bi bi-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <section class="ag-resumo">

                <article class="ag-resumo-card ag-resumo-destaque">
                    <span>Total de agendamentos</span>
                    <strong>{{ $totalAgendamentos }}</strong>
                </article>

                <article class="ag-resumo-card">
                    <span>Hoje</span>
                    <strong>{{ $qtdHoje }}</strong>
                </article>

                <article class="ag-resumo-card">
                    <span>Não concluídos</span>
                    <strong>{{ $qtdPendentes }}</strong>
                </article>

                <article class="ag-resumo-card">
                    <span>Concluídos</span>
                    <strong>{{ $qtdConcluidos }}</strong>
                </article>

            </section>

            <section class="ag-agenda">

                {{-- CALENDÁRIO --}}
                <div class="ag-calendario" id="ag-calendario">

                    <div class="ag-cal-topo">

                        <h2 id="ag-cal-titulo">Mês</h2>

                        <div class="ag-cal-nav">
                            <button type="button" class="ag-cal-btn" id="ag-cal-hoje">Hoje</button>
                            <button type="button" class="ag-cal-btn ag-cal-seta" id="ag-cal-anterior" aria-label="Mês anterior">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="ag-cal-btn ag-cal-seta" id="ag-cal-proximo" aria-label="Próximo mês">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>

                    </div>

                    <div class="ag-cal-semana">
                        <span>Dom</span><span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sáb</span>
                    </div>

                    <div class="ag-cal-grade" id="ag-cal-grade"></div>

                    <div class="ag-legenda">
                        <span><i class="ag-ponto ag-ponto-pendente"></i> Não concluído</span>
                        <span><i class="ag-ponto ag-ponto-atrasado"></i> Atrasado</span>
                        <span><i class="ag-ponto ag-ponto-concluido"></i> Concluído</span>
                    </div>

                </div>

                {{-- AGENDA DO DIA --}}
                <aside class="ag-dia">

                    <div class="ag-dia-topo">
                        <span class="ag-dia-rotulo" id="ag-dia-semana">—</span>
                        <h2 id="ag-dia-titulo">—</h2>
                        <small id="ag-dia-contagem">—</small>
                    </div>

                    <div class="ag-dia-lista" id="ag-dia-lista"></div>

                    <div class="ag-dia-vazio" id="ag-dia-vazio">
                        <i class="bi bi-calendar2-check"></i>
                        <p>Nenhum agendamento neste dia.</p>
                    </div>

                </aside>

            </section>

            {{-- Fonte dos dados: cada agendamento é renderizado uma vez (com os formulários originais)
                 e o JS apenas o exibe no dia correspondente. --}}
            <div class="ag-fonte" id="ag-fonte" hidden>

                @foreach($listaAgendamentos as $agendamento)

                    <article
                        class="ag-item"
                        data-data="{{ date('Y-m-d', strtotime($agendamento->data)) }}"
                        data-hora="{{ substr($agendamento->hora, 0, 5) }}"
                        data-status="{{ $agendamento->status == 1 ? 1 : ($agendamento->status == 2 ? 2 : 0) }}"
                        data-cliente="{{ $agendamento->clientes->nome ?? 'Cliente' }}"
                    >

                        <div class="ag-item-hora">{{ substr($agendamento->hora, 0, 5) }}</div>

                        <div class="ag-item-info">
                            <strong>{{ $agendamento->clientes->nome ?? 'Cliente' }}</strong>
                            <span>{{ $agendamento->procedimentos->nome ?? 'Serviço' }}</span>

                            @if ($agendamento->status == 1)
                                <em class="ag-chip ag-chip-concluido">Concluído</em>
                            @elseif ($agendamento->status == 2)
                                <em class="ag-chip ag-chip-atrasado">Atrasado</em>
                            @else
                                <em class="ag-chip ag-chip-pendente">Não Concluído</em>
                            @endif
                        </div>

                        <div class="ag-item-acoes">
                            @if ($agendamento->status != 1)

                                <form action="{{ route('admin.agendamentos.concluir', $agendamento->agendamento_id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="ag-btn ag-btn-concluir" title="Concluir Agendamento">
                                        <i class="bi bi-check-lg"></i> Concluir
                                    </button>
                                </form>

                                <a href="{{ route('admin.agendamentos.edit', $agendamento->agendamento_id) }}" class="ag-btn ag-btn-icone" title="Reagendar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('admin.agendamentos.cancelar', $agendamento->agendamento_id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="ag-btn ag-btn-icone ag-btn-cancelar" title="Cancelar Agendamento" onclick="return confirm('Deseja realmente cancelar este agendamento? O cliente será notificado.')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            @else
                                <button disabled class="ag-btn ag-btn-finalizado">Finalizado</button>
                            @endif
                        </div>

                    </article>

                @endforeach

            </div>

        </main>

    </div>

</div>

<script src="{{ asset('js/admin/agendamentos.js') }}"></script>

@endsection
