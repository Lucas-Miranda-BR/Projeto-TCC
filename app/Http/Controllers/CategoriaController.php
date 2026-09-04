<?php

namespace App\Http\Controllers;

use App\Models\CategoriaModel;
use Illuminate\Http\Request;

class CategoriaController extends Controller
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

        $existe = CategoriaModel::where(
            'nome',
            $dados['nome']
        )->exists();

        if ($existe) {
            return redirect()
                ->route('admin.produtos.index')
                ->withErrors([
                    'Essa categoria já está cadastrada.'
                ]);
        }

        CategoriaModel::create([
            'nome' => $dados['nome']
        ]);

        return redirect()
            ->route('admin.produtos.index')
            ->with(
                'success',
                'Categoria cadastrada com sucesso!'
            );
    }
}