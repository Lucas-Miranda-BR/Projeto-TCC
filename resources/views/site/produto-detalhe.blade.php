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

        <p><strong>Valor:</strong> R$ {{ number_format($item->preco, 2, ',', '.') }}</p>

        <p><strong>Quantidade em estoque:</strong> {{ $item->estoque }} unidade(s)</p>

        <br>

        @if($item->estoque >= 1)
            <form action="{{ route('carrinho.adicionar', $item->item_id) }}" method="POST">
                @csrf
                <label for="quantidade">Quantidade desejada:</label>
                <input type="number" name="quantidade" id="quantidade" value="1" min="1" max="{{ $item->estoque }}" required>
                
                <br><br>
                <button type="submit">Adicionar ao Carrinho</button>
            </form>
        @else
            <p><strong>Produto Esgotado</strong></p>
        @endif

    </div>
@endsection