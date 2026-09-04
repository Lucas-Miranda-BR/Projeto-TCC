<?php

namespace App\Http\Controllers;

use App\Models\ProcedimentoModel;
use App\Models\TipoModel;
use Illuminate\Http\Request;

class ProcedimentoController extends Controller
{
    public function indexProcedimento()
    {
        $procedimentos = ProcedimentoModel::with('tipos')->orderBy('nome')->get();
        
        $tipos = TipoModel::all();

        return view('admin.procedimentos.index', compact('procedimentos', 'tipos'));
    }

    public function storeProcedimento(Request $request)
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

    public function editProcedimento($id)
    {
        $procedimento = ProcedimentoModel::findOrFail($id);
        $tipos = TipoModel::all();

        return view('admin.procedimentos.edit', compact('procedimento', 'tipos'));
    }

    public function updateProcedimento(Request $request, $id)
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

        $procedimento->updateProcedimento($dados);

        return redirect()
            ->route('admin.procedimentos.index')
            ->with(
                'success',
                'Serviço atualizado com sucesso!'
            );
    }

    public function destroyProcedimento($id)
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