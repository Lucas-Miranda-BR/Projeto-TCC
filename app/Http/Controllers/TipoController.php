<?php

namespace App\Http\Controllers;

use App\Models\TipoModel;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function indexTipo()
    {
        $tipos = TipoModel::all()->orderBy('nome');
        
        return view('admin.tipos.index', compact('tipos'));
    }

    public function storeTipo(Request $request)
    {
        $validator = $request->validate([
            'tipo_id' => [
                'required',
                'integer'
            ],
            'nome' => [
                'required',
                'string',
                'max:255'
            ],
            'colorivel' => [
                'required',
                'boolean'
            ]
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.tipos.index')
                ->withErrors($validator)
                ->withInput();
        }


        TipoModel::create($validator);

        return redirect()
            ->route('admin.tipos.index')
            ->with('success', 'Tipo cadastrado com sucesso!');
    }

    public function editTipo($id)
    {
        $tipo = TipoModel::findOrFail($id);

        return view('admin.tipos.edit', compact('tipo'));
    }

    public function updateTipo(Request $request, $id)
    {
        $tipo = TipoModel::findOrFail($id);

        $validator = $request->validate([
            'tipo_id' => [
                'required',
                'integer'
            ],
            'nome' => [
                'required',
                'string',
                'max:255'
            ],
            'colorivel' => [
                'required',
                'boolean'
            ]
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.tipos.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $tipo->update($validator);

        return redirect()
            ->route('admin.tipos.index')
            ->with(
                'success',
                'Tipo atualizado com sucesso!'
            );
    }

    public function destroyTipo($id)
    {
        $tipo = TipoModel::findOrFail($id);
        $tipo->delete();

        return redirect()
            ->route('admin.tipos.index')
            ->with(
                'success',
                'Tipo excluído com sucesso!'
            );
    }
}