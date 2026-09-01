<?php

namespace App\Http\Controllers;

use App\Models\ProcedimentoModel;
use App\Models\CorModel;
use App\Models\TipoModel;
use Illuminate\Http\Request;

class ProcedimentoController extends Controller
{
    public function index()
    {
        $procedimentos = ProcedimentoModel::with('tipo')->orderBy('nome')->get();
        
        $tipos = TipoModel::all();

        return view('admin.procedimentos.index', compact('procedimentos', 'tipos'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'tipo_id' => [
                'required',
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

        ProcedimentoModel::create($dados);

        return redirect()
            ->route('admin.procedimentos.index')
            ->with('success', 'Serviço cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $procedimento = ProcedimentoModel::findOrFail($id);
        $tipos = TipoModel::all();

        return view('admin.procedimentos.edit', compact('procedimento', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        $procedimento = ProcedimentoModel::findOrFail($id);

        $dados = $request->validate([
            'tipo_id' => [
                'required',
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
        $procedimento = ProcedimentoModel::findOrFail($id);
        $procedimento->delete();

        return redirect()
            ->route('admin.procedimentos.index')
            ->with(
                'success',
                'Serviço excluído com sucesso!'
            );
    }
}