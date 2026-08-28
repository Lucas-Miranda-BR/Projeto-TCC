@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/agendamento.css') }}">
@endpush

@section('content')

@include('components.navbar')

<div class="agendamento-container">

    <h1>Agende seu horário</h1>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('agendamento.create') }}" method="POST">

        <input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->cliente_id }}">

        <input type="hidden" name="imagem_gerada_id" id='imagem_gerada_id' value="{{ $imagemGeradaId ?? '' }}">

        @csrf

        <div class="topo">

            <div class="servico">
                <label for="procedimento_id">Selecione o Serviço</label>
                
                <select name="procedimento_id" id="procedimento_id" required>
                    <option value="" disabled {{ empty($procedimentoSelecionado) ? 'selected' : '' }}>
                        Escolha um serviço...
                    </option>
                    
                    @foreach($procedimentos as $procedimento)
                        <option 
                            value="{{ $procedimento->procedimento_id }}" 
                            {{ (isset($procedimentoSelecionado) && $procedimentoSelecionado == $procedimento->procedimento_id) ? 'selected' : '' }}
                        > 
                            {{ $procedimento->nome }} 
                        </option>
                    @endforeach
                </select>
    
                <p id="exibe-tipo">
                    <strong>Tipo de Serviço:</strong> <span></span>
                </p>
            </div>

            <div class="resumo">
                <h3>Resumo do Agendamento</h3>
                
                <p id="resumo-nome"><strong>Serviço:</strong> Selecione um serviço ao lado</p>
                
                <p id="resumo-descricao">
                    <strong>Descrição:</strong> <span></span>
                </p>
                
                <p id="resumo-preco"><strong>Valor:</strong> R$ 0,00</p>
            </div>

        </div>

        <div class="agenda">

            <div class="calendario">

                <h3>Escolha a Data</h3>

                <input
                    type="date"
                    name="data"
                    id="data"
                    required
                >

            </div>

            <div class="horarios">

                <h3>Escolha o Horário</h3>

                <div class="botoes-horario">

                    <label>
                        <input type="radio" name="hora" id='hora' value="09:00" required>
                        <span>09:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" id='hora' value="10:00">
                        <span>10:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" id='hora' value="11:00">
                        <span>11:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" id='hora' value="14:00">
                        <span>14:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" id='hora' value="15:00">
                        <span>15:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" value="16:00">
                        <span>16:00</span>
                    </label>

                </div>

            </div>

        </div>

        <button type="submit" class="confirmar">
            Confirmar Agendamento
        </button>

    </form>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    @isset($agendamentos)

    <div class="lista-agendamentos">

        <h2>Agendamentos Realizados</h2>

        <table>

            <thead>

                <tr>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Hora</th>
                </tr>

            </thead>

            <tbody>

                @foreach($agendamentos as $agendamento)

                <tr>

                    <td>{{ $agendamento->cliente_id }}</td>

                    <td>{{ $agendamento->procedimento_id }}</td>

                    <td>{{ date('d/m/Y', strtotime($agendamento->data)) }}</td>

                    <td>{{ $agendamento->hora }}</td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    @endisset

</div>

@include('components.footer')

<script>
    window.dadosProcedimentos = @json($procedimentos);
</script>

<script src="{{ asset('js/agendamento.js') }}"></script>

@endsection