@extends('layouts.app')

@section('content')
    <div>
        <h1>Templates de Notificações</h1>
        <p>Gerencie os textos enviados automaticamente pelo sistema.</p>

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

        <table>
            <thead>
                <tr>
                    <th>Quando ocorrer (Tipo)</th>
                    <th>Título da Mensagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr>
                        <td>{{ $template->tipo }}</td>
                        <td>{{ $template->titulo }}</td>
                        <td>
                            <a href="{{ route('admin.templates.edit', $template->template_notificacao_id) }}">
                                Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Nenhum template encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection