<?php

namespace App\Http\Controllers;

use App\Models\Procedimento;
use Illuminate\Http\Request;

class ProcedimentoController extends Controller
{
    public function index()
    {
        $procedimentos = Procedimento::orderBy('nome')->get();

        return view(
            'admin.procedimentos.index',
            compact('procedimentos')
        );
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'tipo_id' => [
                'nullable',
                'integer'
            ],

            'nome' => [
                'required',
                'string',
                'max:255'
            ],

            'descricao' => [
                'required',
                'string'
            ],

            'preco' => [
                'required',
                'numeric',
                'min:0'
            ]
        ]);

        Procedimento::create($dados);

        return redirect()
            ->route('admin.procedimentos.index')
            ->with(
                'success',
                'Serviço cadastrado com sucesso!'
            );
    }

    public function edit($id)
    {
        $procedimento = Procedimento::findOrFail($id);

        return view(
            'admin.procedimentos.edit',
            compact('procedimento')
        );
    }

    public function update(Request $request, $id)
    {
        $procedimento = Procedimento::findOrFail($id);

        $dados = $request->validate([
            'tipo_id' => [
                'nullable',
                'integer'
            ],

            'nome' => [
                'required',
                'string',
                'max:255'
            ],

            'descricao' => [
                'required',
                'string'
            ],

            'preco' => [
                'required',
                'numeric',
                'min:0'
            ]
        ]);

        $procedimento->update($dados);

        return redirect()
            ->route('admin.procedimentos.index')
            ->with(
                'success',
                'Serviço atualizado com sucesso!'
            );
    }

    public function destroy($id)
    {
        $procedimento = Procedimento::findOrFail($id);

        $procedimento->delete();

        return redirect()
            ->route('admin.procedimentos.index')
            ->with(
                'success',
                'Serviço excluído com sucesso!'
            );
    }
}