@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/produtos.css') }}">
@endpush

@section('content')

@include('components.navbar')

@if (session('success'))
    <div class="toast-carrinho toast-sucesso">
        <div class="toast-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        <div class="toast-info">
            <strong>Produto adicionado</strong>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" class="toast-close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

@elseif (session('erro'))
    <div class="toast-carrinho toast-erro">
        <div class="toast-icon">
            <i class="bi bi-exclamation-lg"></i>
        </div>
        <div class="toast-info">
            <strong>Atenção</strong>
            <span>{{ session('erro') }}</span>
        </div>
        <button type="button" class="toast-close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

@elseif ($errors->any())
    <div class="toast-carrinho toast-erro">
        <div class="toast-icon">
            <i class="bi bi-exclamation-lg"></i>
        </div>
        <div class="toast-info">
            <strong>Atenção</strong>
            <span>{{ $errors->first() }}</span>
        </div>
        <button type="button" class="toast-close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
@endif

<main class="produtos-page">

    {{-- liga o modo "remover fundo": as fotos ficam ocultas até serem processadas (evita piscar o fundo branco) --}}
    <script>document.querySelector('.produtos-page').classList.add('js-remover-fundo');</script>

    {{-- Ícone padrão (shampoo) usado quando o produto não tem imagem --}}
    <svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
        <symbol id="icone-shampoo" viewBox="0 0 100 140">
            {{-- bico e haste da bomba --}}
            <rect x="60" y="5" width="26" height="8" rx="4" fill="#9d1228"/>
            <rect x="42" y="5" width="26" height="12" rx="4" fill="#9d1228"/>
            <rect x="50" y="17" width="10" height="12" fill="#9d1228"/>
            {{-- tampa --}}
            <rect x="38" y="28" width="34" height="11" rx="3" fill="#ffffff"/>
            {{-- corpo --}}
            <rect x="26" y="38" width="58" height="94" rx="15" fill="#ffffff"/>
            {{-- rótulo vinho --}}
            <rect x="26" y="68" width="58" height="42" fill="#9d1228"/>
            {{-- gota branca --}}
            <path d="M55 77C55 77 46 88 46 94a9 9 0 0 0 18 0C64 88 55 77 55 77Z" fill="#ffffff"/>
            {{-- detalhe no topo do corpo --}}
            <rect x="26" y="50" width="58" height="4" fill="#9d1228"/>
        </symbol>
    </svg>

    <section class="produtos-hero">
        <div class="produtos-hero-content">
            <span class="produtos-tag">SEMPRE DIVA</span>
            <h1>Nossos Produtos</h1>
            <p>Encontre produtos selecionados para cuidar da sua beleza e fazer parte da sua rotina.</p>
        </div>
    </section>

    <section class="produtos-container">

        <div class="produtos-topo">
            <div>
                <span class="catalogo-label">CATÁLOGO</span>
                <h2>Encontre seu produto</h2>
                <p>
                    {{ $produtos->total() }}
                    @if ($produtos->total() == 1)
                        produto encontrado
                    @else
                        produtos encontrados
                    @endif
                </p>
            </div>
            <a href="{{ route('cliente.carrinho') }}" class="btn-carrinho">
                <i class="bi bi-bag"></i> Ver Carrinho
            </a>
        </div>

        <form action="{{ route('site.produtos') }}" method="GET" class="produtos-filtros">
            <div class="filtro-grupo filtro-pesquisa">
                <label for="busca">Pesquisar</label>
                <div class="campo-pesquisa">
                    <i class="bi bi-search"></i>
                    <input type="text" name="busca" id="busca" value="{{ request('busca') }}" placeholder="Buscar produto...">
                </div>
            </div>

            <div class="filtro-grupo">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria">
                    <option value="">Todas</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->categoria_id }}" {{ request('categoria') == $categoria->categoria_id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filtro-grupo">
                <label for="marca">Marca</label>
                <select name="marca" id="marca">
                    <option value="">Todas</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->marca_id }}" {{ request('marca') == $marca->marca_id ? 'selected' : '' }}>
                            {{ $marca->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-filtrar">
                <i class="bi bi-sliders"></i> Filtrar
            </button>

            @if (request()->filled('busca') || request()->filled('categoria') || request()->filled('marca'))
                <a href="{{ route('site.produtos') }}" class="btn-limpar">
                    <i class="bi bi-x-lg"></i> Limpar
                </a>
            @endif
        </form>

        @if ($produtos->count() > 0)
            <div class="produtos-grid">
                @foreach ($produtos as $produto)
                    <article class="produto-card">

                        <a href="{{ route('site.produto.detalhe', $produto->item_id) }}">
                            <div class="produto-imagem" style="position: relative;">
                                {{-- sem imagem (ou imagem que falhou ao carregar): fundo rosa com o shampoo --}}
                                <div class="produto-sem-imagem" role="img" aria-label="Produto sem imagem">
                                    <svg viewBox="0 0 100 140" aria-hidden="true"><use href="#icone-shampoo"></use></svg>
                                </div>

                                @if (!empty($produto->foto))
                                    <img src="{{ asset('images/produtos/' . $produto->foto) }}" alt="{{ $produto->nome }}" onerror="this.remove()">
                                @endif

                                @if ($produto->categorias)
                                    <span class="produto-categoria">{{ $produto->categorias->nome }}</span>
                                @endif

                                <!-- BADGE DE DESCONTO -->
                                @if($produto->desconto_ativo)
                                    <span style="position: absolute; top: 10px; right: 10px; background: #ffc107; color: #000; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 0.8rem; z-index: 2;">
                                        -{{ $produto->desconto_ativo->valor }}%
                                    </span>
                                @endif
                            </div>
                        </a>

                        <div class="produto-info">

                            <a href="{{ route('site.produto.detalhe', $produto->item_id) }}">
                                @if ($produto->marcas)
                                    <span class="produto-marca">{{ $produto->marcas->nome }}</span>
                                @endif
                                <h3>{{ $produto->nome }}</h3>
                            </a>

                            <div class="produto-bottom">
                                <div class="produto-preco">
                                    @if($produto->desconto_ativo)
                                        <div style="display: flex; flex-direction: column; line-height: 1.2;">
                                            <small style="text-decoration: line-through; color: #999; font-size: 0.8rem;">R$ {{ number_format($produto->preco, 2, ',', '.') }}</small>
                                            <strong style="color: #28a745;">R$ {{ number_format($produto->preco_final, 2, ',', '.') }}</strong>
                                            @if($produto->desconto_ativo->quando_terminar)
                                                <small style="color: #dc3545; font-size: 0.7rem; margin-top: 2px;">Termina: {{ \Carbon\Carbon::parse($produto->desconto_ativo->quando_terminar)->format('d/m') }}</small>
                                            @endif
                                        </div>
                                    @else
                                        <span>Por</span>
                                        <strong>R$ {{ number_format($produto->preco, 2, ',', '.') }}</strong>
                                    @endif
                                </div>

                                    @if ($produto->estoque >= 2)
                                        
                                    @auth
                                        <form
                                            action="{{ route('carrinho.adicionar', $produto->item_id) }}"
                                            method="POST"
                                            class="produto-compra-form"
                                        >
                                            @csrf
                                            <div class="quantidade-produto">
                                                <button type="button" class="quantidade-btn quantidade-menos" title="Diminuir quantidade">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                
                                                <input type="number" name="quantidade" class="quantidade-input" value="1" min="1" max="{{ $produto->estoque }}" readonly>
                                                
                                                <button type="button" class="quantidade-btn quantidade-mais" title="Aumentar quantidade">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <button type="submit" class="btn-adicionar" title="Adicionar ao carrinho">
                                                <i class="bi bi-bag-plus"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('cliente.login') }}" style="width: 100%; display: flex; text-decoration: none;">
                                            <button type="button" class="btn-adicionar" style="width: 100%; border-radius: 8px; font-size: 0.9rem; justify-content: center; display: flex; align-items: center; gap: 8px;" title="Faça login para comprar">
                                                <i class="bi bi-box-arrow-in-right"></i> Fazer Login
                                            </button>
                                        </a>
                                    @endauth

                                    @else
                                    <button type="button" class="btn-adicionar btn-esgotado" disabled title="Produto esgotado" style="width: 100%; justify-content: center; display: flex;">
                                        <i class="bi bi-bag-x"></i> Esgotado
                                    </button>
                                    @endif
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>

            @if ($produtos->hasPages())
                <div class="paginacao-container">
                    <div class="paginacao-info">
                        Página <strong>{{ $produtos->currentPage() }}</strong> de <strong>{{ $produtos->lastPage() }}</strong>
                    </div>

                    <nav class="paginacao">
                        @if ($produtos->onFirstPage())
                            <span class="pagina-botao pagina-disabled"><i class="bi bi-chevron-left"></i></span>
                        @else
                            <a href="{{ $produtos->previousPageUrl() }}" class="pagina-botao"><i class="bi bi-chevron-left"></i></a>
                        @endif

                        @php
                            $inicio = max(1, $produtos->currentPage() - 2);
                            $fim = min($produtos->lastPage(), $produtos->currentPage() + 2);
                        @endphp

                        @for ($pagina = $inicio; $pagina <= $fim; $pagina++)
                            @if ($pagina == $produtos->currentPage())
                                <span class="pagina-numero pagina-ativa">{{ $pagina }}</span>
                            @else
                                <a href="{{ $produtos->url($pagina) }}" class="pagina-numero">{{ $pagina }}</a>
                            @endif
                        @endfor

                        @if ($produtos->hasMorePages())
                            <a href="{{ $produtos->nextPageUrl() }}" class="pagina-botao"><i class="bi bi-chevron-right"></i></a>
                        @else
                            <span class="pagina-botao pagina-disabled"><i class="bi bi-chevron-right"></i></span>
                        @endif
                    </nav>
                </div>
            @endif

        @else
            <div class="produtos-vazio">
                <div class="vazio-icone"><i class="bi bi-bag"></i></div>
                <span>CATÁLOGO</span>
                <h2>Nenhum produto encontrado</h2>

                @if (request()->filled('busca') || request()->filled('categoria') || request()->filled('marca'))
                    <p>Nenhum produto corresponde aos filtros selecionados.</p>
                    <a href="{{ route('site.produtos') }}" class="btn-remover-filtros">Limpar filtros</a>
                @else
                    <p>Ainda não há produtos cadastrados.</p>
                @endif
            </div>
        @endif

    </section>

</main>

@include('components.footer')

<script>
/*
 * Remove o fundo liso (branco, cinza...) das fotos dos produtos, no navegador.
 * - Só age se a borda da foto for de uma cor só; caso contrário, deixa a foto como está.
 * - Apaga a cor "de fora para dentro", então detalhes internos da mesma cor (rótulo branco) ficam.
 * - Não altera o arquivo no servidor: o recorte é refeito a cada visita.
 */
(function () {
    var TOL = 38, TOL2 = TOL * TOL;   // distância de cor considerada "fundo"
    var SUAVIZACAO = 1.5;              // transição suave na borda do recorte
    var MIN_BORDA = 0.8;               // % da borda que precisa ter a cor do fundo
    var MIN_REMOVIDO = 0.02, MAX_REMOVIDO = 0.94;
    var MARGEM = 0.04;                 // folga em volta do produto depois de cortar
    var MAX_LADO = 700;                // lado maior usado no processamento (px)

    function mediana(v) {
        v.sort(function (a, b) { return a - b; });
        return v[v.length >> 1];
    }

    function limitar(v) {
        return v < 0 ? 0 : (v > 255 ? 255 : Math.round(v));
    }

    function carregada(img) {
        return new Promise(function (resolve) {
            if (img.complete && img.naturalWidth) { return resolve(img); }
            img.addEventListener('load', function () { resolve(img); }, { once: true });
            img.addEventListener('error', function () { resolve(img); }, { once: true });
        });
    }

    function processar(img) {
        return new Promise(function (resolve) {
            try {
                var nw = img.naturalWidth, nh = img.naturalHeight;
                if (!nw || !nh) { return resolve(false); }

                var escala = Math.min(1, MAX_LADO / Math.max(nw, nh));
                var w = Math.round(nw * escala), h = Math.round(nh * escala);
                if (w < 20 || h < 20) { return resolve(false); }

                var canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;
                var ctx = canvas.getContext('2d', { willReadFrequently: true });
                ctx.drawImage(img, 0, 0, w, h);

                var dados = ctx.getImageData(0, 0, w, h); // erro se a imagem for de outro domínio
                var d = dados.data;

                // já é um PNG recortado: não mexe
                var cantos = [0, (w - 1) * 4, (h - 1) * w * 4, ((h - 1) * w + w - 1) * 4], transp = 0;
                cantos.forEach(function (p) { if (d[p + 3] < 30) { transp++; } });
                if (transp >= 2) { return resolve(false); }

                // pixels da borda da imagem
                var per = [], x, y;
                for (x = 0; x < w; x++) { per.push(x, (h - 1) * w + x); }
                for (y = 1; y < h - 1; y++) { per.push(y * w, y * w + w - 1); }

                // cor do fundo = mediana da borda
                var rs = [], gs = [], bs = [];
                per.forEach(function (i) { rs.push(d[i * 4]); gs.push(d[i * 4 + 1]); bs.push(d[i * 4 + 2]); });
                var br = mediana(rs), bg = mediana(gs), bb = mediana(bs);

                function dist2(i) {
                    var p = i * 4, dr = d[p] - br, dg = d[p + 1] - bg, db = d[p + 2] - bb;
                    return dr * dr + dg * dg + db * db;
                }

                // a borda precisa ser (quase toda) dessa cor, ou não é fundo liso
                var limite = Math.pow(TOL * 1.2, 2), parecidos = 0;
                per.forEach(function (i) { if (dist2(i) <= limite) { parecidos++; } });
                if (parecidos / per.length < MIN_BORDA) { return resolve(false); }

                // flood fill a partir da borda: 1 = fundo, 2 = borda do produto
                var mascara = new Uint8Array(w * h);
                var pilha = new Int32Array(w * h), topo = 0, cand = [];

                per.forEach(function (i) {
                    if (mascara[i] === 0 && dist2(i) <= TOL2) { mascara[i] = 1; pilha[topo++] = i; }
                });

                function visitar(n) {
                    if (mascara[n] !== 0) { return; }
                    if (dist2(n) <= TOL2) { mascara[n] = 1; pilha[topo++] = n; }
                    else { mascara[n] = 2; cand.push(n); }
                }

                while (topo > 0) {
                    var i = pilha[--topo];
                    var cx = i % w, cy = (i - cx) / w;
                    if (cx + 1 < w) { visitar(i + 1); }
                    if (cx > 0) { visitar(i - 1); }
                    if (cy + 1 < h) { visitar(i + w); }
                    if (cy > 0) { visitar(i - w); }
                }

                var removidos = 0;
                for (i = 0; i < mascara.length; i++) { if (mascara[i] === 1) { removidos++; } }
                var proporcao = removidos / (w * h);
                if (proporcao < MIN_REMOVIDO || proporcao > MAX_REMOVIDO) { return resolve(false); }

                // apaga o fundo
                for (i = 0; i < mascara.length; i++) { if (mascara[i] === 1) { d[i * 4 + 3] = 0; } }

                // suaviza a borda do recorte (e tira o "resto" do fundo misturado na cor)
                cand.forEach(function (n) {
                    var a = (Math.sqrt(dist2(n)) - TOL) / (TOL * SUAVIZACAO);
                    if (a >= 1) { return; }
                    if (a < 0) { a = 0; }
                    var p = n * 4;
                    if (a > 0.05) {
                        d[p]     = limitar((d[p]     - (1 - a) * br) / a);
                        d[p + 1] = limitar((d[p + 1] - (1 - a) * bg) / a);
                        d[p + 2] = limitar((d[p + 2] - (1 - a) * bb) / a);
                    }
                    d[p + 3] = Math.round(255 * a);
                });

                // corta as sobras transparentes
                var minX = w, maxX = -1, minY = h, maxY = -1;
                for (y = 0; y < h; y++) {
                    for (x = 0; x < w; x++) {
                        if (mascara[y * w + x] !== 1) {
                            if (x < minX) { minX = x; }
                            if (x > maxX) { maxX = x; }
                            if (y < minY) { minY = y; }
                            if (y > maxY) { maxY = y; }
                        }
                    }
                }
                if (maxX < 0) { return resolve(false); }

                var margem = Math.round(Math.max(maxX - minX + 1, maxY - minY + 1) * MARGEM);
                var x0 = Math.max(0, minX - margem), y0 = Math.max(0, minY - margem);
                var x1 = Math.min(w - 1, maxX + margem), y1 = Math.min(h - 1, maxY + margem);
                var cw = x1 - x0 + 1, ch = y1 - y0 + 1;

                ctx.putImageData(dados, 0, 0);

                var saida = document.createElement('canvas');
                saida.width = cw;
                saida.height = ch;
                saida.getContext('2d').drawImage(canvas, x0, y0, cw, ch, 0, 0, cw, ch);

                saida.toBlob(function (blob) {
                    if (!blob) { return resolve(false); }
                    img.addEventListener('load', function () { resolve(true); }, { once: true });
                    img.src = URL.createObjectURL(blob);
                }, 'image/png');
            } catch (e) {
                resolve(false); // imagem de outro domínio, memória, etc.: mantém a original
            }
        });
    }

    function pronta(img) { img.classList.add('fundo-ok'); }

    var imgs = Array.prototype.slice.call(document.querySelectorAll('.produtos-page .produto-imagem img'));

    imgs.forEach(function (img) {
        carregada(img).then(processar).catch(function () { return false; }).then(function () { pronta(img); });
    });

    // segurança: nenhuma imagem fica escondida por mais de 5s
    setTimeout(function () { imgs.forEach(pronta); }, 5000);
})();
</script>

<script src="{{ asset('js/listar-produtos.js') }}"></script>

@endsection