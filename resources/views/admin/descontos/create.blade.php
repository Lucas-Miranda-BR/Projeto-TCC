@extends('layouts.app')

@section('content')
    <div>
        <h1>Criar Novo Desconto</h1>

        <a href="{{ route('admin.descontos.index') }}">Voltar para a lista</a>
        <br><br>

        @if($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('erro'))
            <div style="color: red; font-weight: bold; margin-bottom: 15px;">
                {{ session('erro') }}
            </div>
        @endif

        <form action="{{ route('admin.descontos.store') }}" method="POST">
            @csrf

            <label for="nome">Nome do Desconto:</label><br>
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required><br>

            <label for="valor">Valor do Desconto (%):</label><br>
            <input type="number" step="0.01" name="valor" id="valor" value="{{ old('valor') }}" required><br>

            <label for="quando_terminar">Termina em (deixe em branco se for permanente):</label><br>
            <input type="date" name="quando_terminar" id="quando_terminar" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" value="{{ old('quando_terminar') }}"><br>

            <hr>
            <h3>Agrupamentos (Segure CTRL para selecionar vários)</h3>

            <label for="itens">Aplicar a Itens Específicos:</label><br>
            <select name="itens[]" id="itens" multiple size="5">
                @foreach($itens as $item)
                    <option value="{{ $item->item_id }}">{{ $item->nome }}</option>
                @endforeach
            </select><br>

            <label for="marcas">Adicionar Itens por Marcas:</label><br>
            <select name="marcas[]" id="marcas" multiple size="5">
                @foreach($marcas as $marca)
                    <option value="{{ $marca->marca_id ?? $marca->id }}">{{ $marca->nome }}</option>
                @endforeach
            </select><br>

            <label for="categorias">Adicionar Itens por Categorias:</label><br>
            <select name="categorias[]" id="categorias" multiple size="5">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->categoria_id ?? $categoria->id }}">{{ $categoria->nome }}</option>
                @endforeach
            </select><br>

            <hr>
            <h3 style="color: darkred;">Exceções</h3>
            <label for="excecoes">Itens que NÃO receberão este desconto (Anula seleção por marca/categoria):</label><br>
            <select name="excecoes[]" id="excecoes" multiple size="5">
                @foreach($itens as $item)
                    <option value="{{ $item->item_id }}">{{ $item->nome }}</option>
                @endforeach
            </select><br>

            <button type="submit">Salvar Desconto</button>
        </form>
    </div>
@endsection