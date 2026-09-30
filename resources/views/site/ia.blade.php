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
                        <input type="hidden" name="cor_id" id="cor_id">

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
                                        /* Só mostra as cores quando o tipo do procedimento é colorível
                                           (coluna tipo.colorivel, via ProcedimentoModel::tipos) */
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

                                @php
                                    $temAdesivo = collect($procedimentos)->contains(function ($p) {
                                        return stripos($p->nome, 'adesiv') !== false;
                                    });
                                @endphp

                                @unless($temAdesivo)
                                    {{-- Só visual: mostra "Adesivo de unha" mesmo sem esse procedimento no banco --}}
                                    <button
                                        type="button"
                                        class="dropdown-option"
                                        role="option"
                                        aria-selected="false"
                                        data-value="adesivo-unha"
                                        data-usa-cor="1"
                                    >
                                        Adesivo de unha
                                    </button>
                                @endunless

                            </div>

                        </div>

                    </div>


                    <!-- COR (aparece só nos procedimentos que permitem cor) -->
                    <div class="option-group" id="grupo-cor" hidden>

                        <span class="option-label">Selecione o visual</span>

                        <div class="option-list" id="listaCores">

                            <button type="button" class="option-row option-color" data-value="Não altere">
                                <span class="option-name">Não altere</span>
                                <i class="bi bi-chevron-right"></i>
                            </button>

                            @foreach ($cores as $cor)
                                @php
                                    /* A tabela cor não tem código de cor: a bolinha é deduzida pelo nome. */
                                    $hex = null;
                                    $mapaCores = [
                                        'vinho' => '#5e0f1e', 'bord' => '#5e0f1e', 'vermelh' => '#a81c2e',
                                        'nude' => '#d4a5a0', 'rosa' => '#e8a0b4', 'pink' => '#e0508a',
                                        'francesinha' => '#f3e2e2', 'branc' => '#f4f1f1', 'off' => '#f1ece6',
                                        'azul' => '#1f5078', 'verde' => '#3f7a4f', 'roxo' => '#6b3f86',
                                        'lil' => '#a98bc7', 'laranja' => '#e0772b', 'amarel' => '#e6c229',
                                        'dourad' => '#c9a227', 'prat' => '#b8bcc2', 'cinza' => '#8a8a8a',
                                        'marrom' => '#6b4a3a', 'castanh' => '#3b2418', 'ruiv' => '#b85c3c',
                                        'cobre' => '#b8693d', 'loir' => '#d8b48a', 'mel' => '#d8b48a',
                                        'platinad' => '#e0dbd0', 'pret' => '#1c1c1c',
                                    ];
                                    $nomeCor = \Illuminate\Support\Str::ascii(mb_strtolower($cor->nome));
                                    foreach ($mapaCores as $trecho => $codigo) {
                                        if (str_contains($nomeCor, $trecho)) { $hex = $codigo; break; }
                                    }
                                @endphp

                                <button type="button" class="option-row option-color" data-value="{{ $cor->cor_id }}">
                                    <span
                                        class="option-dot"
                                        @if($hex) style="background: {{ $hex }};" @endif
                                    ></span>
                                    <span class="option-name">{{ $cor->nome }}</span>
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            @endforeach

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

<script>
    /* Apenas interface: a integração com a IA ainda não foi feita.
       Quando for, basta enviar o formulário (procedimento_id, cor_id, imagem_prompt). */

    var inputFoto   = document.getElementById('imagem_prompt');
    var areaUpload  = document.getElementById('uploadArea');
    var previewBox  = document.getElementById('previewContainer');
    var previewImg  = document.getElementById('previewImagem');
    var resultado   = document.getElementById('resultado');

    inputFoto.addEventListener('change', function () {
        var arquivo = inputFoto.files[0];
        if (!arquivo) return;

        previewImg.src = URL.createObjectURL(arquivo);
        previewBox.classList.add('active');
        areaUpload.style.display = 'none';
    });

    document.getElementById('removerImagem').addEventListener('click', function () {
        inputFoto.value = '';
        previewImg.src = '';
        previewBox.classList.remove('active');
        areaUpload.style.display = '';
        resultado.classList.remove('active');
        document.querySelector('.ia-page').classList.remove('has-result');
    });


    /* Procedimento: dropdown único */
    var dropdown     = document.getElementById('dropdownProcedimento');
    var gatilho      = dropdown.querySelector('.dropdown-trigger');
    var opcoes       = dropdown.querySelectorAll('.dropdown-option');
    var grupoCor     = document.getElementById('grupo-cor');
    var cores        = document.querySelectorAll('#listaCores .option-color');

    function fecharDropdown() {
        dropdown.classList.remove('open');
        gatilho.setAttribute('aria-expanded', 'false');
    }

    gatilho.addEventListener('click', function () {
        var aberto = dropdown.classList.toggle('open');
        gatilho.setAttribute('aria-expanded', aberto ? 'true' : 'false');
    });

    document.addEventListener('click', function (e) {
        if (!dropdown.contains(e.target)) fecharDropdown();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') fecharDropdown();
    });

    opcoes.forEach(function (opcao) {
        opcao.addEventListener('click', function () {

            opcoes.forEach(function (o) {
                o.classList.remove('selected');
                o.setAttribute('aria-selected', 'false');
            });

            opcao.classList.add('selected');
            opcao.setAttribute('aria-selected', 'true');

            document.getElementById('procedimento_id').value = opcao.dataset.value;
            document.getElementById('procedimentoSelecionado').textContent = opcao.textContent.trim();
            gatilho.classList.add('selected');

            /* troca de procedimento limpa a cor */
            document.getElementById('cor_id').value = '';
            cores.forEach(function (c) { c.classList.remove('selected'); });

            grupoCor.hidden = opcao.dataset.usaCor !== '1';

            fecharDropdown();
        });
    });

    cores.forEach(function (cor) {
        cor.addEventListener('click', function () {
            cores.forEach(function (c) { c.classList.remove('selected'); });
            cor.classList.add('selected');
            document.getElementById('cor_id').value = cor.dataset.value;
        });
    });


    /* Botão: só mostra o layout do resultado (sem chamar IA) */
    document.querySelector('.ia-form').addEventListener('submit', function (evento) {
        evento.preventDefault();

        if (!inputFoto.files[0]) {
            inputFoto.click();
            return;
        }

        document.getElementById('imagemAntes').src = previewImg.src;
        resultado.classList.add('active');
        document.querySelector('.ia-page').classList.add('has-result');
    });

    document.getElementById('btnNova').addEventListener('click', function () {
        resultado.classList.remove('active');
        document.querySelector('.ia-page').classList.remove('has-result');
    });
</script>

@endpush