<?php

namespace App\Http\Controllers;

use App\Models\ProcedimentoModel;
use App\Models\TipoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return redirect()
                ->route('admin.procedimentos.index')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        ProcedimentoModel::create($validated);

        return redirect()
            ->route('admin.procedimentos.index')
            ->with('success', 'Procedimento cadastrado com sucesso!');
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

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return redirect()
                ->route('admin.procedimentos.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $procedimento->update($validated);

        return redirect()
            ->route('admin.procedimentos.index')
            ->with('success', 'Procedimento atualizado com sucesso!');
    }

    public function destroyProcedimento($id)
    {
        $procedimento = ProcedimentoModel::findOrFail($id);
        $procedimento->delete();

        return redirect()
            ->route('admin.procedimentos.index')
            ->with('success', 'Procedimento excluído com sucesso!');
    }
}