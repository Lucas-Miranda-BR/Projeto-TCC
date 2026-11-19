@extends('layouts.app')

@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Montserrat:wght@500;600&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
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

<main class="produtos-page sd-pagina">

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

    <section class="produtos-banner produtos-banner--fundo">
        <div class="sd-miolo produtos-banner-grade">
            <div class="produtos-banner-texto">
                <h1>Nossos produtos</h1>
                <p>Selecionados um a um pela Sandra para manter o resultado do salão por muito mais tempo.</p>
            </div>
            <div class="produtos-banner-foto">
                <img src="{{ asset('images/produtos-banner.png') }}" alt="Shampoo, máscara, óleo e leave-in vendidos no salão">
            </div>
        </div>
    </section>

    <section class="produtos-container sd-miolo">

        <form action="{{ route('site.produtos') }}" method="GET" class="produtos-filtros">
            <div class="filtro-grupo filtro-pesquisa">
                <label for="busca">Pesquisar</label>
                <div class="campo-pesquisa">
                    <i class="bi bi-search"></i>
                    <input type="text" name="busca" id="busca" value="{{ request('busca') }}" placeholder="Buscar produto...">
                </div>
            </div>

            <div class="filtro-grupo filtro-dropdown">
                <label id="categoria-label">Categoria</label>
                <input type="hidden" name="categoria" id="categoria" value="{{ request('categoria') }}">
                <div class="dropdown-custom" data-dropdown>
                    <button type="button" class="dropdown-trigger" aria-labelledby="categoria-label" aria-haspopup="listbox" aria-expanded="false">
                        <span class="dropdown-valor">{{ $categorias->firstWhere('categoria_id', request('categoria'))?->nome ?? 'Todas' }}</span>
                        <i class="bi bi-chevron-down dropdown-seta" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-opcoes" role="listbox" aria-label="Categoria">
                        <button type="button" class="dropdown-opcao {{ !request('categoria') ? 'selecionada' : '' }}" role="option" aria-selected="{{ !request('categoria') ? 'true' : 'false' }}" data-value="">Todas</button>
                        @foreach ($categorias as $categoria)
                            <button type="button" class="dropdown-opcao {{ request('categoria') == $categoria->categoria_id ? 'selecionada' : '' }}" role="option" aria-selected="{{ request('categoria') == $categoria->categoria_id ? 'true' : 'false' }}" data-value="{{ $categoria->categoria_id }}">{{ $categoria->nome }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="filtro-grupo filtro-dropdown">
                <label id="marca-label">Marca</label>
                <input type="hidden" name="marca" id="marca" value="{{ request('marca') }}">
                <div class="dropdown-custom" data-dropdown>
                    <button type="button" class="dropdown-trigger" aria-labelledby="marca-label" aria-haspopup="listbox" aria-expanded="false">
                        <span class="dropdown-valor">{{ $marcas->firstWhere('marca_id', request('marca'))?->nome ?? 'Todas' }}</span>
                        <i class="bi bi-chevron-down dropdown-seta" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-opcoes" role="listbox" aria-label="Marca">
                        <button type="button" class="dropdown-opcao {{ !request('marca') ? 'selecionada' : '' }}" role="option" aria-selected="{{ !request('marca') ? 'true' : 'false' }}" data-value="">Todas</button>
                        @foreach ($marcas as $marca)
                            <button type="button" class="dropdown-opcao {{ request('marca') == $marca->marca_id ? 'selecionada' : '' }}" role="option" aria-selected="{{ request('marca') == $marca->marca_id ? 'true' : 'false' }}" data-value="{{ $marca->marca_id }}">{{ $marca->nome }}</button>
                        @endforeach
                    </div>
                </div>
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

        <div class="produtos-topo">
            <p class="produtos-contagem">
                <strong>{{ $produtos->total() }}</strong>
                @if ($produtos->total() == 1)
                    produto encontrado
                @else
                    produtos encontrados
                @endif
            </p>
            <a href="{{ route('cliente.carrinho') }}" class="btn-carrinho">
                <i class="bi bi-bag"></i> Ver Carrinho
            </a>
        </div>

        @if ($produtos->count() > 0)
            <div class="produtos-grid">
                @foreach ($produtos as $produto)
                    <article class="produto-card {{ $produto->estoque < 1 ? 'produto-card--esgotado' : '' }}">

                        <a href="{{ route('site.produto.detalhe', $produto->item_id) }}" class="produto-imagem-link" tabindex="-1" aria-hidden="true">
                            <div class="produto-imagem">
                                {{-- sem imagem (ou imagem que falhou ao carregar): fundo rosa com o shampoo --}}
                                <div class="produto-sem-imagem" role="img" aria-label="Produto sem imagem">
                                    <svg viewBox="0 0 100 140" aria-hidden="true"><use href="#icone-shampoo"></use></svg>
                                </div>

                                @if (!empty($produto->foto))
                                    <img src="{{ asset('images/produtos/' . $produto->foto) }}" alt="" onerror="this.remove()">
                                @endif

                                @if ($produto->desconto_ativo)
                                    <span class="produto-selo">-{{ $produto->desconto_ativo->valor }}%</span>
                                @endif
                            </div>
                        </a>

                        <div class="produto-info">

                            <a href="{{ route('site.produto.detalhe', $produto->item_id) }}" class="produto-titulo-link">
                                <h3>{{ $produto->nome }}</h3>
                            </a>

                            <p class="produto-descricao">
                                @if ($produto->categorias){{ $produto->categorias->nome }}@endif
                                @if ($produto->categorias && $produto->marcas) · @endif
                                @if ($produto->marcas){{ $produto->marcas->nome }}@endif
                            </p>

                            <div class="produto-bottom">
                                <div class="produto-preco">
                                    <div class="produto-preco-linha">
                                        @if($produto->desconto_ativo)
                                            <strong>R$ {{ number_format($produto->preco_final, 2, ',', '.') }}</strong>
                                        @else
                                            <strong>R$ {{ number_format($produto->preco, 2, ',', '.') }}</strong>
                                        @endif
                                        <span class="produto-estoque">{{ $produto->estoque >= 1 ? 'Em estoque' : 'Esgotado' }}</span>
                                    </div>
                                    @if($produto->desconto_ativo)
                                        <div class="produto-preco-extra">
                                            <small class="produto-preco-antigo">R$ {{ number_format($produto->preco, 2, ',', '.') }}</small>
                                            @if($produto->desconto_ativo->quando_terminar)
                                                <small class="produto-preco-termina">até {{ \Carbon\Carbon::parse($produto->desconto_ativo->quando_terminar)->format('d/m') }}</small>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                @if ($produto->estoque >= 1)
                                    @auth
                                        <form
                                            action="{{ route('carrinho.adicionar', $produto->item_id) }}"
                                            method="POST"
                                            class="produto-compra-form"
                                        >
                                            @csrf
                                            <input type="hidden" name="quantidade" value="1">
                                            <button type="submit" class="btn-adicionar" aria-label="Adicionar {{ $produto->nome }} ao carrinho" title="Adicionar ao carrinho">
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('cliente.login') }}" class="btn-adicionar" aria-label="Entre na sua conta para comprar" title="Entre na sua conta para comprar">
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                                        </a>
                                    @endauth
                                @else
                                    <button type="button" class="btn-adicionar btn-esgotado" disabled aria-label="Produto esgotado"></button>
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

<script src="{{ asset('js/produtos.js') }}"></script>

@endsection