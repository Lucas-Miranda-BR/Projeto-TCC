<?php

namespace App\Http\Controllers;

use App\Models\TipoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class TipoController extends Controller
{
    public function indexTipo()
    {
        $tipos = TipoModel::all();
        
        return view('admin.tipos.index', compact('tipos'));
    }

    public function storeTipo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => [
                'required',
                'string',
                'max:255'
            ],
            'is_colorivel' => [
                'nullable',
                'boolean'
            ]
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        TipoModel::create([
            'nome' => $request->nome,
            'is_colorivel' => $request->boolean('is_colorivel'),
        ]);

        return redirect()
            ->back()
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

        $validator = Validator::make($request->all(), [
            'nome' => [
                'required',
                'string',
                'max:255'
            ],
            'is_colorivel' => [
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

        $validated = $validator->validated();
        $validated['is_colorivel'] = $request->boolean('is_colorivel') ? 1 : 0;

        $tipo->update($validated);

        return redirect()
            ->route('admin.tipos.index')
            ->with('success', 'Tipo atualizado com sucesso!');
    }

    public function destroyTipo($id)
    {
        try {
            $tipo = TipoModel::findOrFail($id);
            $tipo->delete();

            return redirect()
                ->route('admin.tipos.index')
                ->with('success', 'Tipo excluído com sucesso!');
        }
        catch (QueryException $e) {
            if ($e->getCode() == "23000"){
                return redirect()
                    ->back()
                    ->with('error', 'Não é possível excluir este tipo, pois existem outros registros associados a ele.');
            }

            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro ao tentar excluir o registro.');
        }
    }    
}