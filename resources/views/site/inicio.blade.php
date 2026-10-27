@extends('layouts.app')

@php
    // versão pelo horário de modificação: a cada alteração o navegador baixa o CSS novo (sem depender de cache)
    $versaoCss = file_exists(public_path('css/inicio.css')) ? filemtime(public_path('css/inicio.css')) : time();
@endphp

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}?v={{ $versaoCss }}">

    {{--
        ANIMAÇÃO DE ENTRADA DA TELA INICIAL
        - O título entra em 3 camadas, da esquerda: cada linha começa quando a anterior está na metade do caminho.
        - Depois, o cartão "Nossos trabalhos" e o botão "Nossos serviços" deslizam.
        - Quando terminam de entrar, os dois passam a flutuar suavemente.
        JavaScript simples (ES5): funciona em qualquer navegador e dispositivo.
        Roda aqui no <head>, antes da primeira pintura, para esconder os elementos sem piscar.
    --}}
    <script>
        (function () {
            'use strict';

            var DUR = 700;           // duração do deslizar (igual ao CSS: 700ms)
            var DUR_TEXTO = 550;     // duração do deslizar de cada linha do título (igual ao CSS: 550ms)
            var PASSO = DUR_TEXTO / 2; // a próxima linha começa na metade do caminho da anterior
            var ENTRE_CAIXAS = 0;    // intervalo entre o cartão e o botão (0 = entram juntos)

            // false = a animação roda sempre, mesmo se o Windows/navegador estiver com "reduzir movimento".
            // true = respeita essa configuração (tudo aparece parado).
            var RESPEITAR_MOVIMENTO_REDUZIDO = false;
            var html = document.documentElement;
            var iniciou = false;

            // esconde os elementos animados antes de pintar a tela (o CSS usa a classe ini-js)
            html.classList.add('ini-js');

            // segurança: se algo falhar, tudo aparece depois de 4s
            window.setTimeout(function () {
                if (!iniciou) {
                    html.classList.add('ini-fallback');
                }
            }, 4000);

            function depois(fn, ms) {
                return window.setTimeout(fn, ms);
            }

            function entrar(el) {
                el.classList.add('ini-in');
            }

            // cada elemento flutua num ritmo um pouco diferente (a, b, c) para não ficar mecânico
            function flutuar(el, indice) {
                el.classList.add('ini-float');
                if (indice === 1) {
                    el.classList.add('ini-float--b');
                } else if (indice === 2) {
                    el.classList.add('ini-float--c');
                }
            }

            function iniciar() {
                iniciou = true;

                var linhas = Array.prototype.slice.call(document.querySelectorAll('.inicio-line'));
                var caixas = [
                    document.querySelector('.inicio-card-wrap'),
                    document.querySelector('.inicio-pill-wrap'),
                    document.querySelector('.inicio-cta-wrap')
                ];

                var reduzMovimento = window.matchMedia &&
                    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                if (RESPEITAR_MOVIMENTO_REDUZIDO && reduzMovimento) {
                    html.classList.add('ini-fallback');
                    return;
                }

                // 1) título em camadas
                linhas.forEach(function (linha, i) {
                    depois(function () {
                        entrar(linha);
                    }, i * PASSO);
                });

                // 2) cartão e botão: começam ao mesmo tempo que o título (no instante da primeira linha)
                var inicioCaixas = 0;

                caixas.forEach(function (caixa, i) {
                    if (!caixa) {
                        return;
                    }

                    depois(function () {
                        entrar(caixa);

                        // 3) ao terminar de entrar, começa a flutuar
                        depois(function () {
                            flutuar(caixa, i);
                        }, DUR);
                    }, inicioCaixas + i * ENTRE_CAIXAS);
                });
            }

            // espera a página existir e o navegador pintar o estado inicial (escondido) antes de animar
            function comecar() {
                if (window.requestAnimationFrame) {
                    window.requestAnimationFrame(function () {
                        window.requestAnimationFrame(iniciar);
                    });
                } else {
                    depois(iniciar, 50);
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', comecar);
            } else {
                comecar();
            }
        })();
    </script>
@endpush

@section('content')

@include('components.navbar')

{{-- Tela inicial do site: sem footer. O botão leva para a página home. --}}
<main class="inicio-page">

    <h1 class="inicio-title">
        <span class="inicio-line ini-anim">Um salão que cuida</span>
        <span class="inicio-line inicio-line--red ini-anim">de cada detalhe</span>
        <span class="inicio-line ini-anim">não só do corte</span>
    </h1>

    <div class="inicio-intro">

        <p>
            Cabelo, unhas e depilação com atendimento individual e produtos de
            qualidade, para realçar a sua essência.
        </p>

        <div class="inicio-cta-wrap">
            <a href="{{ route('home') }}" class="inicio-cta">
                <span class="inicio-btn">Conhecer o salão</span>
            </a>
        </div>

    </div>

    <img
        class="inicio-butterfly"
        src="{{ asset('images/Design_sem_nome-removebg-preview.png') }}"
        alt="Borboleta do logo do Salão Sempre Diva"
    >

    <div class="inicio-card-wrap ini-anim">
        <a href="{{ route('site.servicos') }}" class="inicio-card">
            <img src="{{ asset('images/trabalho1.png') }}" alt="Corte de cabelo feito no salão">
            <strong>Nossos trabalhos</strong>
            <span>Veja exemplos do resultado dos nossos atendimentos</span>
        </a>
    </div>

    <div class="inicio-pill-wrap ini-anim">
        <a href="{{ route('site.servicos') }}" class="inicio-pill">Nossos serviços</a>
    </div>

    <div class="inicio-stats">

        <div class="inicio-stats-title"><span>20</span> anos</div>

        <p>de carreira em Tatuí<br>para todas as clientes</p>

        <div class="inicio-avatars">
            <img src="{{ asset('images/trabalho1.png') }}" alt="">
            <img src="{{ asset('images/manicure.png') }}" alt="">
            <img src="{{ asset('images/depilacao.png') }}" alt="">
        </div>

    </div>

</main>

@endsection