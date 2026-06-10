@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/agendamento.css') }}">
@endpush

@section('content')



<div class="agendamento">

    <h1>Agende seu horário</h1>

    <div class="conteudo">

        <div class="servico">

            <h3>Serviço Selecionado</h3>

            <div class="item">

                <img src="{{ asset('images/corte.jpg') }}">

                <span>Corte</span>

                <strong>R$150,00</strong>

            </div>

        </div>

        <div class="calendario">

            <h3>Data</h3>

            <input type="date">

            <h3>Horário</h3>

            <select>
                <option>09:00</option>
                <option>10:00</option>
                <option>11:00</option>
            </select>

        </div>

        <div class="resumo">

            <h3>Resumo</h3>

            <p>Serviço: Corte</p>

            <p>Total: R$150</p>

            <button>
                Confirmar
            </button>

        </div>

    </div>

</div>

@endsection