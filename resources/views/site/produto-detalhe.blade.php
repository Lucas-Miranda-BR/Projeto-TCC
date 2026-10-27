@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/produto-detalhe.css') }}">
@endpush

@section('content')
   
    @include('components.navbar')

   
    <main class="produto-detalhe-main">
        <div class="produto-detalhe-container">
            
           
            <a href="{{ route('site.produtos') }}" class="btn-voltar">
                &larr; Voltar para a lista de produtos
            </a>

           
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('erro'))
                <div class="alert alert-danger">{{ session('erro') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($quantidadeNoCarrinho > 0)
                <div class="alert alert-info">
                    <strong>Aviso:</strong> Esse produto já está em seu carrinho em {{ $quantidadeNoCarrinho }} quantidade(s).
                </div>
            @endif

     
            <div class="produto-card-split">
                
               
                <div class="produto-col-esquerda">
                    @if($item->foto)
                        <img 
                            src="{{ filter_var($item->foto, FILTER_VALIDATE_URL) ? $item->foto : asset('images/produtos/' . $item->foto) }}" 
                            alt="{{ $item->nome }}"
                            class="foto-produto-full"
                        >
                    @else
                        <div class="sem-foto">
                            <p>Nenhuma foto disponível</p>
                        </div>
                    @endif
                </div>

                
                <div class="produto-col-direita">
                    
                    <div class="badges-container">
                        <span class="badge-categoria">{{ $item->categorias->nome ?? 'Sem categoria' }}</span>
                        <span class="badge-marca">{{ $item->marcas->nome ?? 'Sem marca' }}</span>
                    </div>

                    <h1 class="produto-titulo">{{ $item->nome }}</h1>

                   
                    <div class="preco-container">
                        @if($item->desconto_ativo)
                            <div class="preco-flex">
                                <span class="preco-original">R$ {{ number_format($item->preco, 2, ',', '.') }}</span>
                                <span class="preco-promocao">R$ {{ number_format($item->preco_final, 2, ',', '.') }}</span>
                                <span class="badge-desconto">-{{ $item->desconto_ativo->valor }}% OFF</span>
                            </div>
                            @if($item->desconto_ativo->quando_terminar)
                                <p class="desconto-timer">
                                    <i class="bi bi-clock-history"></i> Termina em: {{ \Carbon\Carbon::parse($item->desconto_ativo->quando_terminar)->format('d/m/Y') }}
                                </p>
                            @endif
                        @else
                            <span class="preco-normal">R$ {{ number_format($item->preco, 2, ',', '.') }}</span>
                        @endif
                    </div>

                    <p class="estoque-info">
                        <strong>Estoque disponível:</strong> {{ $item->estoque }} unidade(s)
                    </p>

                  
                    <div class="descricao-container">
                        <h3>Descrição</h3>
                        <p>{{ $item->descricao ?? 'Nenhuma descrição informada para este produto.' }}</p>
                    </div>

                    
                    <div class="acoes-container">
                        @if($item->estoque >= 1)
                            @auth
                                <form action="{{ route('carrinho.adicionar', $item->item_id) }}" method="POST" class="form-carrinho">
                                    @csrf
                                    <div class="qtd-field">
                                        <label for="quantidade">Qtd:</label>
                                        <input type="number" name="quantidade" id="quantidade" value="1" min="1" max="{{ $item->estoque }}" required>
                                    </div>
                                    
                                    <button type="submit" class="btn-comprar">
                                        Adicionar ao Carrinho
                                    </button>
                                </form>
                            @else
                                <div class="card-login-required">
                                    <p>Você precisa estar logado para comprar este produto.</p>
                                    <a href="{{ route('cliente.login') }}" class="btn-login">
                                        Fazer Login para Adicionar
                                    </a>
                                </div>
                            @endauth
                        @else
                            <div class="card-esgotado">
                                <span>Produto Esgotado</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </main>

    
    @include('components.footer')
@endsection