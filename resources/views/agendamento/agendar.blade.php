@extends('layouts.app')


@push('css')

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>

<link
    rel="stylesheet"
    href="{{ asset('css/agendamento.css') }}"
>

@endpush


@section('content')


@include('components.navbar')


<main class="agendamento-page">


    <section class="agendamento-hero">

        <span class="agendamento-etiqueta">

            <i class="bi bi-calendar-heart"></i>

            Agendamento Online

        </span>

        <h1>
            Agende seu horário
        </h1>

        <p>
            Escolha o procedimento, a data e o melhor horário para cuidar de você.
        </p>

    </section>



    <div class="agendamento-container">


        @if(session('success'))

            <div class="agendamento-alert alert-success">

                <i class="bi bi-check-circle-fill"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif



        @if($errors->any())

            <div class="agendamento-alert alert-error">

                <i class="bi bi-exclamation-circle-fill"></i>

                <div>

                    <strong>
                        Não foi possível concluir o agendamento.
                    </strong>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif



        <form
            action="{{ route('agendamento.create') }}"
            method="POST"
            class="agendamento-form"
        >

            @csrf


            <input
                type="hidden"
                name="cliente_id"
                id="cliente_id"
                value="{{ $cliente->cliente_id }}"
            >


            <input
                type="hidden"
                name="imagem_gerada_id"
                id="imagem_gerada_id"
                value="{{ $imagemGeradaId ?? '' }}"
            >



            <div class="agendamento-layout">


                <div class="agendamento-principal">


                    <section class="agendamento-card">


                        <div class="agendamento-card-header">

                            <div class="passo-numero">
                                1
                            </div>

                            <div>

                                <h2>
                                    Escolha o procedimento
                                </h2>

                                <p>
                                    Selecione o serviço que deseja realizar.
                                </p>

                            </div>

                        </div>



                        <div class="servico">

                            <label for="procedimento_id">

                                <i class="bi bi-scissors"></i>

                                Procedimento

                            </label>


                            <div class="select-wrapper">

                                <select
                                    name="procedimento_id"
                                    id="procedimento_id"
                                    required
                                >

                                    <option
                                        value=""
                                        disabled
                                        {{ empty($procedimentoSelecionado) ? 'selected' : '' }}
                                    >
                                        Escolha um procedimento...
                                    </option>


                                    @foreach($procedimentos as $procedimento)

                                        <option
                                            value="{{ $procedimento->procedimento_id }}"
                                            {{ isset($procedimentoSelecionado) && $procedimentoSelecionado == $procedimento->procedimento_id ? 'selected' : '' }}
                                        >

                                            {{ $procedimento->nome }}

                                        </option>

                                    @endforeach

                                </select>

                                <i class="bi bi-chevron-down"></i>

                            </div>

                        </div>


                    </section>



                    <section class="agendamento-card">


                        <div class="agendamento-card-header">

                            <div class="passo-numero">
                                2
                            </div>

                            <div>

                                <h2>
                                    Escolha a data
                                </h2>

                                <p>
                                    Selecione o dia em que deseja ser atendido.
                                </p>

                            </div>

                        </div>



                        <div class="calendario">

                            <label for="data">

                                <i class="bi bi-calendar3"></i>

                                Data do atendimento

                            </label>


                            <input
                                type="date"
                                name="data"
                                id="data"
                                min="{{ now()->format('Y-m-d') }}"
                                value="{{ old('data') }}"
                                required
                            >

                        </div>


                    </section>



                    <section class="agendamento-card">


                        <div class="agendamento-card-header">

                            <div class="passo-numero">
                                3
                            </div>

                            <div>

                                <h2>
                                    Escolha o horário
                                </h2>

                                <p>
                                    Selecione um dos horários disponíveis.
                                </p>

                            </div>

                        </div>



                        <div class="horarios">


                            <div class="botoes-horario">


                                <label class="horario-option">

                                    <input
                                        type="radio"
                                        name="hora"
                                        id="hora-09"
                                        value="09:00"
                                        {{ old('hora') == '09:00' ? 'checked' : '' }}
                                        required
                                    >

                                    <span>

                                        <i class="bi bi-clock"></i>

                                        09:00

                                    </span>

                                </label>



                                <label class="horario-option">

                                    <input
                                        type="radio"
                                        name="hora"
                                        id="hora-10"
                                        value="10:00"
                                        {{ old('hora') == '10:00' ? 'checked' : '' }}
                                    >

                                    <span>

                                        <i class="bi bi-clock"></i>

                                        10:00

                                    </span>

                                </label>



                                <label class="horario-option">

                                    <input
                                        type="radio"
                                        name="hora"
                                        id="hora-11"
                                        value="11:00"
                                        {{ old('hora') == '11:00' ? 'checked' : '' }}
                                    >

                                    <span>

                                        <i class="bi bi-clock"></i>

                                        11:00

                                    </span>

                                </label>



                                <label class="horario-option">

                                    <input
                                        type="radio"
                                        name="hora"
                                        id="hora-14"
                                        value="14:00"
                                        {{ old('hora') == '14:00' ? 'checked' : '' }}
                                    >

                                    <span>

                                        <i class="bi bi-clock"></i>

                                        14:00

                                    </span>

                                </label>



                                <label class="horario-option">

                                    <input
                                        type="radio"
                                        name="hora"
                                        id="hora-15"
                                        value="15:00"
                                        {{ old('hora') == '15:00' ? 'checked' : '' }}
                                    >

                                    <span>

                                        <i class="bi bi-clock"></i>

                                        15:00

                                    </span>

                                </label>



                                <label class="horario-option">

                                    <input
                                        type="radio"
                                        name="hora"
                                        id="hora-16"
                                        value="16:00"
                                        {{ old('hora') == '16:00' ? 'checked' : '' }}
                                    >

                                    <span>

                                        <i class="bi bi-clock"></i>

                                        16:00

                                    </span>

                                </label>


                            </div>


                        </div>


                    </section>


                </div>



                <aside class="resumo">


                    <div class="resumo-header">

                        <div class="resumo-icon">

                            <i class="bi bi-calendar-check"></i>

                        </div>

                        <div>

                            <span>
                                Seu agendamento
                            </span>

                            <h2>
                                Resumo
                            </h2>

                        </div>

                    </div>



                    <div class="resumo-conteudo">


                        <div class="resumo-item">

                            <span class="resumo-item-icon">

                                <i class="bi bi-grid"></i>

                            </span>

                            <div>

                                <small>
                                    Tipo
                                </small>

                                <p id="exibe-tipo">

                                    <span>
                                        Selecione um procedimento
                                    </span>

                                </p>

                            </div>

                        </div>



                        <div class="resumo-item">

                            <span class="resumo-item-icon">

                                <i class="bi bi-scissors"></i>

                            </span>

                            <div>

                                <small>
                                    Serviço
                                </small>

                                <p id="resumo-nome">
                                    Nenhum serviço selecionado
                                </p>

                            </div>

                        </div>



                        <div class="resumo-item">

                            <span class="resumo-item-icon">

                                <i class="bi bi-card-text"></i>

                            </span>

                            <div>

                                <small>
                                    Descrição
                                </small>

                                <p id="resumo-descricao">

                                    <span>
                                        Selecione um procedimento para visualizar.
                                    </span>

                                </p>

                            </div>

                        </div>


                    </div>



                    <div class="resumo-total">

                        <span>
                            Valor do serviço
                            @if(!empty($temTaxaFalta))
                                <small style="display: block; color: #b42318; font-weight: 600; margin-top: 2px;">
                                    (+10% taxa de atraso inclusa)
                                </small>
                            @endif
                        </span>

                        <strong id="resumo-preco">
                            R$ 0,00
                        </strong>

                    </div>



                    @if(!empty($temTaxaFalta))
                        <div class="resumo-aviso" style="background: #fef3f2; border: 1px solid #fecdca; color: #b42318;">

                            <i class="bi bi-exclamation-triangle-fill" style="color: #d92d20;"></i>

                            <span>
                                <strong>Agendamento em atraso:</strong> devido ao não comparecimento no horário anterior, foi aplicado um acréscimo de <strong>10%</strong> no valor deste serviço.
                            </span>

                        </div>
                    @endif



                    <div class="resumo-aviso">

                        <i class="bi bi-info-circle"></i>

                        <span>
                            Confira os dados antes de confirmar seu horário.
                        </span>

                    </div>



                    <button
                        type="submit"
                        class="confirmar"
                    >

                        <i class="bi bi-calendar-check"></i>

                        Confirmar Agendamento

                    </button>


                </aside>


            </div>


        </form>


    </div>


</main>


@include('components.footer')



<script>

    window.dadosProcedimentos =
        @json($procedimentos);

</script>


<script src="{{ asset('js/agendamento.js') }}"></script>


@endsection