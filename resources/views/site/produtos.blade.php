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

<script src="{{ asset('js/listar-produtos.js') }}"></script>

@endsection