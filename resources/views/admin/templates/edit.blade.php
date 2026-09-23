@extends('layouts.app')

@section('content')
    <div>
        <h1>Editar Template: {{ $template->tipo }}</h1>
        
        <p>
            <strong>Atenção:</strong> Não altere as palavras entre chaves (como {data}, {hora}, {nome}), pois elas são substituídas automaticamente pelo sistema.
        </p>

        @if(session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div>
                @foreach($errors->all() as $erro)
                    <p>{{ $erro }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.templates.update', $template->template_notificacao_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="titulo"><strong>Título da Notificação:</strong></label>
                <br>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $template->titulo) }}" required>
            </div>

            <div>
                <label for="conteudo"><strong>Conteúdo da Mensagem:</strong></label>
                <br>
                <textarea name="conteudo" id="conteudo" rows="6" required>{{ old('conteudo', $template->conteudo) }}</textarea>
            </div>

            <div>
                <button type="submit">Salvar Alterações</button>
                <a href="{{ route('admin.templates.index') }}">Voltar</a>
            </div>
        </form>
    </div>
@endsection