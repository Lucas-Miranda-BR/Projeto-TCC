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


    <form action="{{ route('ia.gerar') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <section class="ia-container">
    
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
    
            <div class="ia-options">

            <h2>Escolha sua transformação</h2>

            <p>
                Selecione o que você deseja experimentar.
            </p>
    
    
            <div class="option-group">

                <label for="procedimento_id">Procedimento</label>

                <select id="procedimento_id" name="procedimento_id">

                    <option value="" disabled selected>
                        Selecione um procedimento
                    </option>

                    @foreach ($procedimentos as $procedimento)
                    <option value="{{ $procedimento->procedimento_id }}">
                            {{ $procedimento->nome }}
                    </option>
                    @endforeach

                </select>

            </div>
    
    
            <div class="option-group" id="grupo-cor">
                <label>Cor</label>
                <select id="cor_id" name="cor_id">
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->tipo_id }}"> 
                            {{ $tipo->nome }} 
                        </option>
                    @endforeach
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
                    type="submit"
                    id="btnGerar"
                    class="btn-gerar"
                >
                    ✨ Simular meu visual
                </button>
    
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

            !API NÃO ADICIONADA!

        </small>

    </section>

</main>


@include('components.footer')

@endsection


@push('scripts')

<script>
    window.dadosProcedimentos = @json($procedimentos);
</script>
<script src="{{ asset('js/ia.js') }}"></script>

@endpush