@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/ia.css') }}">
@endpush

@section('content')

@include('components.navbar')

<main class="ia-page">

    <!-- CABEÇALHO -->
    <section class="ia-header">

        <h1>Experimente seu novo visual</h1>

        <p>
            Use nossa inteligência artificial para visualizar
            uma transformação antes de agendar seu atendimento.
        </p>

    </section>


    <!-- ÁREA PRINCIPAL -->
    <section class="ia-container">

        <!-- ENVIO DA FOTO -->
        <div class="ia-upload">

            <h2>Envie sua foto</h2>

            <p>
                Escolha uma foto sua para começar a simulação.
            </p>

            <div class="upload-area" id="uploadArea">

                <div class="upload-icon">
                    📷
                </div>

                <h3>Adicione sua foto</h3>

                <p>
                    JPG, JPEG ou PNG
                </p>

                <label for="imagem" class="btn-upload">
                    Escolher foto
                </label>

                <input
                    type="file"
                    id="imagem"
                    name="imagem"
                    accept="image/png,image/jpeg"
                    hidden
                >

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
                    Remover foto
                </button>

            </div>

        </div>


        <!-- CONFIGURAÇÃO DA TRANSFORMAÇÃO -->
        <div class="ia-options">

            <h2>Escolha sua transformação</h2>

            <p>
                Selecione o que você deseja experimentar.
            </p>


            <div class="option-group">

                <label>Procedimento</label>

                <select id="procedimento">

                    <option value="">
                        Selecione um procedimento
                    </option>

                    <option value="corte">
                        Corte de cabelo
                    </option>

                    <option value="cor">
                        Cor de cabelo
                    </option>

                    <option value="mechas">
                        Mechas
                    </option>

                    <option value="penteado">
                        Penteado
                    </option>

                    <option value="maquiagem">
                        Maquiagem
                    </option>

                </select>

            </div>


            <div class="option-group">

                <label>Estilo</label>

                <select id="estilo">

                    <option value="">
                        Selecione um estilo
                    </option>

                    <option value="loiro">
                        Loiro
                    </option>

                    <option value="morena">
                        Morena iluminada
                    </option>

                    <option value="ruivo">
                        Ruivo
                    </option>

                    <option value="preto">
                        Preto
                    </option>

                    <option value="cacheado">
                        Cacheado
                    </option>

                    <option value="liso">
                        Liso
                    </option>

                </select>

            </div>


            <div class="ia-description">

                <span>✨</span>

                <p>
                    Nossa inteligência artificial irá criar
                    uma simulação baseada nas opções escolhidas.
                </p>

            </div>


            <button
                type="button"
                id="btnGerar"
                class="btn-gerar"
            >
                ✨ Simular meu visual
            </button>

        </div>

    </section>


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

                <span>ANTES</span>

                <div class="image-box">

                    <img
                        id="imagemAntes"
                        src=""
                        alt="Imagem antes da transformação"
                    >

                </div>

            </div>


            <div class="result-arrow">
                →
            </div>


            <div class="result-image">

                <span>DEPOIS</span>

                <div class="image-box generated">

                    <div id="loading">

                        <div class="loader"></div>

                        <p>Preparando sua simulação...</p>

                    </div>

                    <img
                        id="imagemDepois"
                        src=""
                        alt="Resultado da inteligência artificial"
                    >

                </div>

            </div>

        </div>


        <div class="result-actions">

            <p>
                Gostou do resultado?
            </p>

            <a
               href="{{ route('agendamento.agendar') }}"
                class="btn-agendar"
            >
                Agendar meu horário
            </a>

        </div>


        <small class="ia-disclaimer">

            O resultado apresentado é uma simulação criada por
            inteligência artificial e serve apenas como referência visual.

        </small>

    </section>

</main>


@include('components.footer')

@endsection


@push('scripts')

<script>

console.log("JavaScript da IA carregado");

const imagemInput = document.getElementById('imagem');

console.log(imagemInput);

const previewContainer =
    document.getElementById('previewContainer');

const previewImagem =
    document.getElementById('previewImagem');

const removerImagem =
    document.getElementById('removerImagem');

const imagemAntes =
    document.getElementById('imagemAntes');

const imagemDepois =
    document.getElementById('imagemDepois');

const resultado =
    document.getElementById('resultado');

const loading =
    document.getElementById('loading');

const btnGerar =
    document.getElementById('btnGerar');


// SELECIONAR IMAGEM
imagemInput.addEventListener('change', function () {

    const arquivo = this.files[0];

    if (!arquivo) {
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {

        previewImagem.src = e.target.result;

        imagemAntes.src = e.target.result;

        previewContainer.classList.add('active');

    };

    reader.readAsDataURL(arquivo);

});


// REMOVER IMAGEM
removerImagem.addEventListener('click', function () {

    imagemInput.value = '';

    previewImagem.src = '';

    imagemAntes.src = '';

    previewContainer.classList.remove('active');

});


// GERAR SIMULAÇÃO
btnGerar.addEventListener('click', function () {

    const arquivo = imagemInput.files[0];

    const procedimento =
        document.getElementById('procedimento').value;

    const estilo =
        document.getElementById('estilo').value;


    if (!arquivo) {

        alert('Por favor, escolha uma foto.');

        return;

    }


    if (!procedimento) {

        alert('Escolha um procedimento.');

        return;

    }


    if (!estilo) {

        alert('Escolha um estilo.');

        return;

    }


    resultado.classList.add('active');

    loading.style.display = 'flex';

    imagemDepois.style.display = 'none';


    // POR ENQUANTO:
    // aqui estamos utilizando a própria imagem
    // apenas para testar a interface.
    //
    // Depois vamos substituir este trecho
    // pela chamada da API de inteligência artificial.

    setTimeout(function () {

        imagemDepois.src = imagemAntes.src;

        loading.style.display = 'none';

        imagemDepois.style.display = 'block';

    }, 2000);


    resultado.scrollIntoView({

        behavior: 'smooth'

    });

});

</script>

@endpush