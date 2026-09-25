@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/produtos.css') }}"> 
<style>
    .input-bloqueado {
        background-color: #f5f5f5;
        color: #777;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="produtos-content">

            <div class="produtos-header">
                <span class="breadcrumb-admin">
                    Painel > Agendamentos > <strong>Reagendar</strong>
                </span>

                <h1>Reagendar Horário</h1>
                <p>Ajuste a data ou o horário deste atendimento.</p>
            </div>

            @if(session('success'))
                <div class="produto-alert produto-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="produto-alert produto-alert-error">
                    @foreach($errors->all() as $erro)
                        <p>{{ $erro }}</p>
                    @endforeach
                </div>
            @endif

            <section class="produtos-topo">
                <div class="produto-form-card produto-form-principal" style="max-width: 700px;">
                    
                    <div class="produto-form-title">
                        <span class="produto-form-icon">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                        <div>
                            <h2>Detalhes do Agendamento</h2>
                            <p>O cliente será notificado automaticamente da mudança.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.agendamentos.update', $agendamento->agendamento_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <div class="form-group">
                                <label>Cliente</label>
                                <input type="text" value="{{ $agendamento->clientes->nome ?? 'Cliente não encontrado' }}" class="input-bloqueado" readonly>
                            </div>

                            <div class="form-group">
                                <label>Procedimento</label>
                                <input type="text" value="{{ $agendamento->procedimentos->nome ?? 'Serviço não encontrado' }}" class="input-bloqueado" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="data">Nova Data <span style="color: red;">*</span></label>
                                <input 
                                    type="date" 
                                    name="data" 
                                    id="data" 
                                    value="{{ old('data', $agendamento->data) }}" 
                                    min="{{ now()->format('Y-m-d') }}"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="hora">Novo Horário <span style="color: red;">*</span></label>
                                <select name="hora" id="hora" required>
                                    <option value="">Selecione...</option>
                                    @php
                                        $horarios = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];
                                    @endphp

                                    @foreach($horarios as $h)
                                        <option value="{{ $h }}" {{ old('hora', $agendamento->hora) == $h ? 'selected' : '' }}>
                                            {{ $h }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div style="display: flex; gap: 15px; margin-top: 20px;">
                            <button type="submit" class="btn-produto-principal">
                                <i class="bi bi-save"></i> Salvar Alteração
                            </button>

                            <a href="{{ route('admin.agendamentos') }}" class="btn-cadastro-auxiliar" style="text-decoration: none; text-align: center;">
                                Cancelar
                            </a>
                        </div>

                    </form>
                </div>
            </section>

        </main>
    </div>
</div>

@endsection