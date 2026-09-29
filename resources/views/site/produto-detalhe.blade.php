@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ route('site.produtos') }}">Voltar para a lista de produtos</a>

        <br><br>

        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif

        @if(session('erro'))
            <p>{{ session('erro') }}</p>
        @endif

        @if($errors->any())
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        @endif

        @if($quantidadeNoCarrinho > 0)
            <p><strong>Aviso:</strong> Esse produto já está em seu carrinho em {{ $quantidadeNoCarrinho }} quantidade(s).</p>
        @endif

        <hr>

        @if($item->foto)
            <img 
                src="{{ filter_var($item->foto, FILTER_VALIDATE_URL) ? $item->foto : asset('images/produtos/' . $item->foto) }}" 
                alt="{{ $item->nome }}"
            >
        @else
            <p>Nenhuma foto disponível</p>
        @endif

        <h1>{{ $item->nome }}</h1>
        <p>
            <strong>Descrição:</strong> 
            {{ $item->descricao ?? 'Nenhuma descrição informada para este produto.' }}
        </p>

        <p><strong>Marca:</strong> {{ $item->marcas->nome ?? 'Sem marca' }}</p>

        <p><strong>Categoria:</strong> {{ $item->categorias->nome ?? 'Sem categoria' }}</p>

        @if($item->desconto_ativo)
            <div class="produto-preco" style="margin: 15px 0;">
                <p style="margin: 0;"><strong>Valor:</strong></p>
                <small style="text-decoration: line-through; color: #999; font-size: 1rem;">
                    R$ {{ number_format($item->preco, 2, ',', '.') }}
                </small>
                
                <h3 style="color: #28a745; margin: 5px 0;">
                    R$ {{ number_format($item->preco_final, 2, ',', '.') }}
                </h3>
                
                <span style="background: #ffc107; color: #000; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">
                    -{{ $item->desconto_ativo->valor }}% OFF
                </span>

                @if($item->desconto_ativo->quando_terminar)
                    <p style="font-size: 0.8rem; color: #dc3545; margin-top: 5px;">
                        <i class="bi bi-clock-history"></i> Termina em: {{ \Carbon\Carbon::parse($item->desconto_ativo->quando_terminar)->format('d/m/Y') }}
                    </p>
                @endif
            </div>
        @else
            <p><strong>Valor:</strong> R$ {{ number_format($item->preco, 2, ',', '.') }}</p>
        @endif

        <p><strong>Quantidade em estoque:</strong> {{ $item->estoque }} unidade(s)</p>

        <br>

        @if($item->estoque >= 1)
            
            @auth
                <form action="{{ route('carrinho.adicionar', $item->item_id) }}" method="POST">
                    @csrf
                    <label for="quantidade">Quantidade desejada:</label>
                    <input type="number" name="quantidade" id="quantidade" value="1" min="1" max="{{ $item->estoque }}" required>
                    
                    <br><br>
                    <button type="submit">Adicionar ao Carrinho</button>
                </form>
            @else
                <p>Você precisa estar logado para comprar.</p>
                <a href="{{ route('cliente.login') }}">
                    <button type="button">Fazer Login para Adicionar</button>
                </a>
            @endauth

        @else
            <p><strong>Produto Esgotado</strong></p>
        @endif

    </div>
@endsection