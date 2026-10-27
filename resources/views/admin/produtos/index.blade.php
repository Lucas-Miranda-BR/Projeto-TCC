@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/produtos.css') }}">
@endpush

@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="produtos-content">

            @php
                $produtosBastante = $produtos->filter(function ($produto) {
                    return $produto->estoque > 5;
                })->count();

                $produtosAtencao = $produtos->filter(function ($produto) {
                    return $produto->estoque > 0 && $produto->estoque <= 5;
                })->count();

                $produtosEsgotados = $produtos->filter(function ($produto) {
                    return $produto->estoque <= 0;
                })->count();
            @endphp

            <div class="produtos-header">
                <span class="breadcrumb-produtos">Painel > Produtos</span>
                <h1>Produtos e Estoque</h1>
            </div>

            @if(session('success'))
                <div class="produto-alert produto-alert-success">
                    <i class="bi bi-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="produto-alert produto-alert-error">
                    <i class="bi bi-exclamation-circle"></i>
                    <div>
                        @foreach($errors->all() as $erro)
                            <p>{{ $erro }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <section class="estoque-resumo">
                <div class="estoque-card estoque-bastante">
                    <span class="estoque-titulo">BASTANTE</span>
                    <strong>{{ $produtosBastante }} <span>produtos</span></strong>
                </div>

                <div class="estoque-card estoque-atencao">
                    <span class="estoque-titulo">ATENÇÃO</span>
                    <strong>{{ $produtosAtencao }} <span>produtos</span></strong>
                </div>

                <div class="estoque-card estoque-esgotado">
                    <span class="estoque-titulo">ESGOTADOS</span>
                    <strong>{{ $produtosEsgotados }} <span>produtos</span></strong>
                </div>
            </section>

            <section class="produtos-area">

                <div class="catalogo-card">
                    <div class="catalogo-header">
                        <div>
                            <h2>Catálogo de produtos</h2>
                            <p>
                                {{ $categorias->count() }} categorias ·
                                {{ $marcas->count() }} marcas ·
                                {{ $produtos->count() }} produtos
                            </p>
                        </div>

                        <details class="novo-produto">
                            <summary>
                                <i class="bi bi-plus-lg"></i>
                                Novo produto
                            </summary>

                            <div class="novo-produto-conteudo">
                                <div class="novo-produto-cabecalho">
                                    <h3>Cadastrar Produto</h3>
                                    <p>Adicione um novo produto ao estoque.</p>
                                </div>

                                <form action="{{ route('admin.produtos.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nome">Nome do produto</label>
                                        <input type="text" name="nome" id="nome" value="{{ old('nome') }}" placeholder="Ex: Shampoo Hidratante" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="descricao">Descrição</label>
                                        <textarea name="descricao" id="descricao" rows="3" placeholder="Descrição detalhada do produto">{{ old('descricao') }}</textarea>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="categoria_id">Categoria</label>
                                            <select name="categoria_id" id="categoria_id">
                                                <option value="">Sem categoria</option>
                                                @foreach($categorias as $categoria)
                                                    <option value="{{ $categoria->categoria_id }}" {{ old('categoria_id') == $categoria->categoria_id ? 'selected' : '' }}>
                                                        {{ $categoria->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="marca_id">Marca</label>
                                            <select name="marca_id" id="marca_id">
                                                <option value="">Sem marca</option>
                                                @foreach($marcas as $marca)
                                                    <option value="{{ $marca->marca_id }}" {{ old('marca_id') == $marca->marca_id ? 'selected' : '' }}>
                                                        {{ $marca->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="preco">Preço</label>
                                            <input type="number" name="preco" id="preco" min="0" step="0.01" value="{{ old('preco') }}" placeholder="0,00" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="estoque">Estoque inicial</label>
                                            <input type="number" name="estoque" id="estoque" min="0" value="{{ old('estoque') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="foto">Foto do produto</label>
                                        <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/webp" onchange="previewImagem(event, 'preview-cadastro')" required>
                                        
                                        <img id="preview-cadastro" src="#" alt="Preview da Foto" style="display: none; max-width: 120px; margin-top: 10px; border-radius: 8px; border: 1px solid #ddd; object-fit: cover;">
                                    </div>

                                    <button type="submit" class="btn-salvar-produto">
                                        <i class="bi bi-plus-lg"></i>
                                        Cadastrar produto
                                    </button>
                                </form>
                            </div>
                        </details>
                    </div>

                    <div class="catalogo-pesquisa">
                        <i class="bi bi-search"></i>
                        <input type="text" id="pesquisa-produtos" placeholder="Buscar marca, categoria, produto..." autocomplete="off">
                    </div>

                    <div class="tabela-produtos-wrapper">
                        <table class="tabela-produtos">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Foto</th>
                                    <th>Produto</th>
                                    <th>Descrição</th> <!-- NOVA COLUNA -->
                                    <th>Categoria</th>
                                    <th>Marca</th>
                                    <th>Preço</th>
                                    <th>Estoque</th>
                                    <th>Status do estoque</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody id="produtos-tbody">
                                @forelse($produtos as $produto)
                                    <tr class="produto-linha" data-pesquisa="{{ mb_strtolower(($produto->nome ?? '') . ' ' . ($produto->categorias->nome ?? '') . ' ' . ($produto->marcas->nome ?? '')) }}">
                                        
                                        <td>
                                            @if($produto->foto)
                                                <img src="{{ asset('images/produtos/' . $produto->foto) }}" alt="{{ $produto->nome }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px;">
                                            @else
                                                <div style="width: 48px; height: 48px; background: #f0f0f0; border-radius: 6px; display:flex; align-items:center; justify-content:center;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>

                                        <td><strong class="produto-nome">{{ $produto->nome }}</strong></td>
                                        
                                        <!-- NOVO CAMPO DESCRIÇÃO LIMITADO A 25 CARACTERES -->
                                        <td title="{{ $produto->descricao }}" style="color: #666; font-size: 0.9em;">
                                            {{ \Illuminate\Support\Str::limit($produto->descricao, 25, '...') }}
                                        </td>

                                        <td>{{ $produto->categorias->nome ?? 'Sem categoria' }}</td>
                                        <td>{{ $produto->marcas->nome ?? 'Sem marca' }}</td>
                                        <td><strong class="produto-preco">R$ {{ number_format($produto->preco, 2, ',', '.') }}</strong></td>
                                        <td class="produto-estoque">{{ $produto->estoque }} un</td>
                                        
                                        <td>
                                            @if($produto->estoque <= 0)
                                                <span class="status-produto sem-estoque"><span class="status-bolinha"></span> Esgotado</span>
                                            @elseif($produto->estoque <= 5)
                                                <span class="status-produto estoque-baixo"><span class="status-bolinha"></span> Baixo Estoque</span>
                                            @else
                                                <span class="status-produto disponivel"><span class="status-bolinha"></span> Disponível</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="acoes-produto">
                                                <a href="{{ route('admin.produtos.edit', $produto->item_id) }}" class="btn-editar-produto" title="Editar produto">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="{{ route('admin.produtos.destroy', $produto->item_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-excluir-produto" title="Excluir produto" onclick="return confirm('Deseja excluir este produto?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="produtos-vazio">Nenhum produto cadastrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div id="nenhum-produto-pesquisa" class="nenhum-produto-pesquisa">
                        <i class="bi bi-search"></i>
                        <span>Nenhum produto encontrado.</span>
                    </div>

                    <div class="catalogo-footer">
                        <span id="contador-produtos">Exibindo 0 produtos</span>
                        <nav class="produtos-pagination" id="produtos-pagination">
                            <button type="button" class="pagination-btn" id="pagination-anterior">Anterior</button>
                            <div class="pagination-numeros" id="pagination-numeros"></div>
                            <button type="button" class="pagination-btn" id="pagination-proximo">Próximo</button>
                        </nav>
                    </div>
                </div>

                <aside class="produtos-lateral">

                    <div class="lateral-card">
                        <div class="lateral-card-header">
                            <h3>Categorias</h3>
                            <details class="adicionar-lateral">
                                <summary title="Nova categoria">+</summary>
                                <div class="adicionar-lateral-form">
                                    <form action="{{ route('admin.categorias.store') }}" method="POST">
                                        @csrf
                                        <label for="categoria_nome">Nova categoria</label>
                                        <input type="text" name="nome" id="categoria_nome" placeholder="Nome da categoria" required>
                                        <button type="submit">Adicionar</button>
                                    </form>
                                </div>
                            </details>
                        </div>

                        <div class="lateral-lista">
                            @forelse($categorias as $categoria)
                                <div class="lateral-item">
                                    <div class="lateral-item-nome">
                                        <span class="categoria-bolinha"></span>
                                        <span>{{ $categoria->nome }}</span>
                                    </div>
                                    <span class="lateral-quantidade">
                                        {{ $produtos->where('categoria_id', $categoria->categoria_id)->count() }} itens
                                    </span>
                                </div>
                            @empty
                                <p class="lateral-vazio">Nenhuma categoria cadastrada.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="lateral-card">
                        <div class="lateral-card-header">
                            <h3>Marcas</h3>
                            <details class="adicionar-lateral">
                                <summary title="Nova marca">+</summary>
                                <div class="adicionar-lateral-form">
                                    <form action="{{ route('admin.marcas.store') }}" method="POST">
                                        @csrf
                                        <label for="marca_nome">Nova marca</label>
                                        <input type="text" name="nome" id="marca_nome" placeholder="Nome da marca" required>
                                        <button type="submit">Adicionar</button>
                                    </form>
                                </div>
                            </details>
                        </div>

                        <div class="lateral-lista">
                            @forelse($marcas as $marca)
                                <div class="lateral-item">
                                    <div class="lateral-item-nome">
                                        <span class="marca-bolinha"></span>
                                        <span>{{ $marca->nome }}</span>
                                    </div>
                                    <span class="lateral-quantidade">
                                        {{ $produtos->where('marca_id', $marca->marca_id)->count() }} itens
                                    </span>
                                </div>
                            @empty
                                <p class="lateral-vazio">Nenhuma marca cadastrada.</p>
                            @endforelse
                        </div>
                    </div>

                </aside>

            </section>
        </main>
    </div>
</div>

<script src="{{ asset('js/admin/produtos.js') }}"></script>

@endsection