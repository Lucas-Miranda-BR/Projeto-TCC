<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255'
            ]
        ]);

        Tipo::create($dados);

        return redirect()
            ->route('admin.procedimentos.index')
            ->with(
                'success',
                'Categoria cadastrada com sucesso!'
            );
    }
}