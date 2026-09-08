<?php

namespace App\Http\Controllers;

use App\Models\MarcaModel;
use Illuminate\Http\Request;

class MarcaController extends Controller
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

        $existe = MarcaModel::where('nome', $dados['nome'])
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.produtos.index')
                ->withErrors([
                    'Essa marca já está cadastrada.'
                ]);
        }

        MarcaModel::create([
            'nome' => $dados['nome']
        ]);

        return redirect()
            ->route('admin.produtos.index')
            ->with(
                'success',
                'Marca cadastrada com sucesso!'
            );
    }
}