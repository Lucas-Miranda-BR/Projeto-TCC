@extends('layouts.app')

@section('content')
<div class="admin-main">
    <div class="container-networth">
        
        <h1>Gerenciar Fluxo de Caixa (Networth)</h1>
        
        <p>Data atual de registro: <strong>{{ \Carbon\Carbon::parse($hoje)->format('d/m/Y') }}</strong></p>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Resumo do Dia Atual -->
        <div class="networth-resumo">
            
            <div class="resumo-item">
                <small>Ganhos Hoje:</small><br>
                <strong class="text-ganho">
                    R$ {{ number_format($registroHoje->ganho ?? 0, 2, ',', '.') }}
                </strong>
            </div>
            
            <div class="resumo-item">
                <small>Custos Hoje:</small><br>
                <strong class="text-custo">
                    R$ {{ number_format($registroHoje->custo ?? 0, 2, ',', '.') }}
                </strong>
            </div>
            
            <div class="resumo-item">
                <small>Networth Atual:</small><br>
                <strong class="text-networth">
                    R$ {{ number_format($registroHoje->networth ?? 0, 2, ',', '.') }}
                </strong>
            </div>

        </div>

        <div class="networth-formularios">
            
            <!-- FORMULÁRIO 1: ADICIONAR GANHO -->
            <div class="form-card ganho-card">
                <h3>Adicionar Ganho</h3>
                
                <form action="{{ route('admin.networth.ganho.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="valor_ganho">Valor do Ganho (R$):</label><br>
                        <input type="number" name="valor_ganho" id="valor_ganho" step="0.01" min="0.01" required placeholder="Ex: 150.00">
                    </div>
                    
                    <button type="submit" class="btn-submit btn-ganho">
                        Somar Ganho
                    </button>
                    
                </form>
            </div>

            <!-- FORMULÁRIO 2: ADICIONAR CUSTO -->
            <div class="form-card custo-card">
                <h3>Adicionar Custo</h3>
                
                <form action="{{ route('admin.networth.custo.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="valor_custo">Valor do Custo (R$):</label><br>
                        <input type="number" name="valor_custo" id="valor_custo" step="0.01" min="0.01" required placeholder="Ex: 50.00">
                    </div>
                    
                    <button type="submit" class="btn-submit btn-custo">
                        Somar Custo
                    </button>
                    
                </form>
            </div>

        </div>
        
    </div>
</div>
@endsection