@extends('layouts.app')

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ia.css') }}">
@endpush

@section('content')

@include('components.navbar')

<main class="ia-page">

    <!-- CABEÇALHO -->
    <header class="ia-header">

        <div class="ia-header-title">
            <span class="ia-eyebrow">Salão Sandra Nerys / Experiência de beleza</span>
            <h1>Provador de Estilo</h1>
        </div>

        <p>
            Imagine seu próximo visual. Escolha uma das opções
            abaixo e veja a transformação antes de agendar seu
            momento especial.
        </p>

    </header>


    <form action="{{ route('ia.gerar') }}" method="POST" enctype="multipart/form-data" class="ia-form">

        @csrf

        <input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->cliente_id }}">

        <section class="ia-container">

            <!-- 01 / SUA FOTO -->
            <div class="ia-column ia-upload">

                <h2 class="ia-column-title">01 / Sua foto</h2>

                <div class="photo-stage">

                    <div class="upload-area" id="uploadArea">

                        <i class="bi bi-image upload-icon"></i>

                        <h3>Seu ponto de partida</h3>

                        <p>
                            Adicione uma foto sua para ver o novo
                            visual em você de forma realista.
                        </p>

                    </div>

                    <div class="preview-container" id="previewContainer">

                        <img
                            id="previewImagem"
                            src=""
                            alt="Pré-visualização da imagem"
                        >

                        <button
                            type="button"
                            id="removerImagem"
                            class="btn-remover"
                        >
                            <i class="bi bi-x-lg"></i>
                            Remover foto
                        </button>

                    </div>

                </div>

                <label for="imagem_prompt" class="btn-upload">
                    <i class="bi bi-upload"></i>
                    Enviar minha foto
                </label>

                <input
                    type="file"
                    id="imagem_prompt"
                    name="imagem_prompt"
                    accept="image/png,image/jpeg"
                    hidden
                >

                <small class="ia-note">Obs: Imagem meramente ilustrativa</small>

            </div>


            <!-- 02 / PERSONALIZE -->
            <div class="ia-column ia-options">

                <h2 class="ia-column-title">
                    02 / Personalize
                    <i class="bi bi-stars"></i>
                </h2>

                <div class="options-card">

                    <!-- PROCEDIMENTO (dropdown único) -->
                    <div class="option-group" id="grupo-procedimento">

                        <span class="option-label">Procedimento</span>

                        <input type="hidden" name="procedimento_id" id="procedimento_id">

                        <div class="dropdown" id="dropdownProcedimento">

                            <button
                                type="button"
                                class="option-row dropdown-trigger"
                                aria-haspopup="listbox"
                                aria-expanded="false"
                            >
                                <span class="option-name" id="procedimentoSelecionado">
                                    Selecione um procedimento
                                </span>
                                <i class="bi bi-chevron-down"></i>
                            </button>

                            <div class="dropdown-menu" role="listbox" aria-label="Procedimento">

                                @foreach ($procedimentos as $procedimento)
                                    @php
                                        $usaCor = (bool) optional($procedimento->tipos)->colorivel;
                                    @endphp

                                    <button
                                        type="button"
                                        class="dropdown-option"
                                        role="option"
                                        aria-selected="false"
                                        data-value="{{ $procedimento->procedimento_id }}"
                                        data-usa-cor="{{ $usaCor ? 1 : 0 }}"
                                    >
                                        {{ $procedimento->nome }}
                                    </button>
                                @endforeach

                            </div>

                        </div>

                    </div>


                    <!-- COR (dropdown com todas as cores do banco; valor = ID da cor) -->
                    <div class="option-group" id="grupo-cor" hidden>

                        <span class="option-label">Selecione o visual</span>

                        <input type="hidden" name="cor_id" id="cor_id">

                        <div class="dropdown" id="dropdownCor">

                            <button
                                type="button"
                                class="option-row dropdown-trigger"
                                aria-haspopup="listbox"
                                aria-expanded="false"
                            >
                                <span class="option-name" id="corSelecionada">
                                    Selecione uma cor
                                </span>
                                <i class="bi bi-chevron-down"></i>
                            </button>

                            <div class="dropdown-menu" role="listbox" aria-label="Cor">

                                <button
                                    type="button"
                                    class="dropdown-option dropdown-cor-option"
                                    role="option"
                                    aria-selected="false"
                                    data-value=""
                                >
                                    Não altere
                                </button>

                                @foreach ($cores as $cor)
                                    <button
                                        type="button"
                                        class="dropdown-option dropdown-cor-option"
                                        role="option"
                                        aria-selected="false"
                                        data-value="{{ $cor->cor_id }}"
                                    >
                                        {{ $cor->nome }}
                                    </button>
                                @endforeach

                            </div>

                        </div>

                    </div>


                    <div class="ia-description">

                        <i class="bi bi-stars"></i>

                        <p>
                            Nossa inteligência artificial irá criar
                            uma simulação baseada nas opções escolhidas.
                        </p>

                    </div>


                    <button
                        type="submit"
                        id="btnGerar"
                        class="btn-gerar"
                    >
                        <i class="bi bi-stars"></i>
                        Simular meu visual
                    </button>

                </div>

            </div>

        </section>
    </form>


    <!-- RESULTADO -->
    <section class="ia-result" id="resultado">

        <div class="result-header">

            <h2>Sua transformação</h2>

            <p>
                Veja uma prévia do visual escolhido.
            </p>

        </div>


        <div class="before-after">

            <div class="result-image">

                <span>Antes</span>

                <div class="image-box">

                    <img
                        id="imagemAntes"
                        src=""
                        alt="Imagem antes da transformação"
                    >

                </div>

            </div>


            <div class="result-arrow">
                <i class="bi bi-arrow-right"></i>
            </div>


            <div class="result-image">

                <span>Depois</span>

                <div class="image-box generated">

                    <div class="placeholder-ia">
                        <i class="bi bi-stars"></i>
                        <p>A simulação com IA estará disponível em breve.</p>
                    </div>

                </div>

            </div>

        </div>


        <div class="result-actions">

            <p>
                Gostou do resultado?
            </p>

            <div class="result-buttons">

                <button type="button" id="btnNova" class="btn-nova">
                    Nova simulação
                </button>

                <a
                   href="{{ route('agendamento.agendar') }}"
                    class="btn-agendar"
                >
                    Agendar meu horário
                </a>

            </div>

        </div>


        <small class="ia-disclaimer">

            O resultado apresentado é uma simulação criada por
            inteligência artificial e serve apenas como referência visual.

            !API NÃO ADICIONADA!

        </small>

    </section>

</main>


@include('components.footer')

@endsection


@push('scripts')
<script src="{{ asset('js/ia.js') }}"></script>
@endpush