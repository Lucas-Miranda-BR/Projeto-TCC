@extends('layouts.app')

@section('content')
    <div>
        <h1>Editar Desconto: {{ $desconto->nome }}</h1>

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

        @php 
            $isAniversario = stripos($desconto->nome, 'aniversário') !== false; 
        @endphp

        <form action="{{ route('admin.descontos.update', $desconto->desconto_id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="nome">Nome do Desconto:</label><br>
            @if($isAniversario)
                <input type="text" value="{{ $desconto->nome }}" disabled><br><br>
                <input type="hidden" name="nome" value="{{ $desconto->nome }}">
            @else
                <input type="text" name="nome" id="nome" value="{{ old('nome', $desconto->nome) }}" required><br><br>
            @endif

            <label for="valor">Valor do Desconto (%):</label><br>
            <input type="number" step="0.01" name="valor" id="valor" value="{{ old('valor', $desconto->valor) }}" required><br><br>

            @if(!$isAniversario)
                <label for="quando_terminar">Termina em (deixe em branco se for permanente):</label><br>
                <input type="date" name="quando_terminar" id="quando_terminar" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" value="{{ old('quando_terminar', $desconto->quando_terminar ? \Carbon\Carbon::parse($desconto->quando_terminar)->format('Y-m-d') : '') }}"><br><br>

                <hr>
                <h3>Agrupamentos (Segure CTRL para selecionar vários)</h3>

                @php
                    $itensSelecionados = $desconto->itens->pluck('item_id')->toArray();
                @endphp

                <label for="itens">Itens com esse desconto (Desmarque para remover):</label><br>
                <select name="itens[]" id="itens" multiple size="8">
                    @foreach($itens as $item)
                        <option value="{{ $item->item_id }}" {{ in_array($item->item_id, old('itens', $itensSelecionados)) ? 'selected' : '' }}>
                            {{ $item->nome }}
                        </option>
                    @endforeach
                </select><br><br>

                <p><em>Para adicionar novos itens em massa a este desconto, selecione abaixo:</em></p>

                <label for="marcas">Adicionar Itens por Marcas:</label><br>
                <select name="marcas[]" id="marcas" multiple size="5">
                    @foreach($marcas as $marca)
                        <option value="{{ $marca->marca_id ?? $marca->id }}">{{ $marca->nome }}</option>
                    @endforeach
                </select><br><br>

                <label for="categorias">Adicionar Itens por Categorias:</label><br>
                <select name="categorias[]" id="categorias" multiple size="5">
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->categoria_id ?? $categoria->id }}">{{ $categoria->nome }}</option>
                    @endforeach
                </select><br><br>

                <hr>
                <h3 style="color: darkred;">Exceções</h3>
                <label for="excecoes">Itens que NÃO receberão este desconto (Anula seleção por marca/categoria):</label><br>
                <select name="excecoes[]" id="excecoes" multiple size="5">
                    @foreach($itens as $item)
                        <option value="{{ $item->item_id }}">{{ $item->nome }}</option>
                    @endforeach
                </select><br><br>
            @endif

            <button type="submit">Atualizar Desconto</button>
        </form>
    </div>
@endsection