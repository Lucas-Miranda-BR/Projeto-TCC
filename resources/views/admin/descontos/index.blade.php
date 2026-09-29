@extends('layouts.app') 

@section('content')
    <div>
        <h1>Gerenciar Descontos</h1>
        
        <a href="{{ route('admin.descontos.create') }}">
            <button type="button">Criar Novo Desconto</button>
        </a>

        @if(session('success'))
            <div style="color: green; margin-top: 10px;">{{ session('success') }}</div>
        @endif

        <hr>

        <table>
            <thead>
                <tr>
                    <th>Nome da Regra</th>
                    <th>Valor (%)</th>
                    <th>Expira Em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($descontos as $desconto)
                    @php 
                        $isAniversario = stripos($desconto->nome, 'aniversário') !== false; 
                    @endphp

                    <tr>
                        <td>{{ $desconto->nome }}</td>
                        <td>{{ $desconto->valor }}%</td>
                        
                        <td>
                            @if($isAniversario)
                                <em>Fixo do Sistema</em>
                            @else
                                {{ $desconto->quando_terminar ? \Carbon\Carbon::parse($desconto->quando_terminar)->format('d/m/Y') : 'Permanente' }}
                            @endif
                        </td>
                        
                        <td>
                            <a href="{{ route('admin.descontos.edit', $desconto->desconto_id) }}">Editar</a>
                            
                            @if(!$isAniversario)
                                <form action="{{ route('admin.descontos.destroy', $desconto->desconto_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Nenhum desconto cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection