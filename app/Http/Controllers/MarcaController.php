<?php

namespace App\Http\Controllers;

use App\Models\MarcaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class MarcaController extends Controller
{
    public function indexMarca()
    {
        $marcas = MarcaModel::all();

        return view(
            'admin.marcas.index',
            compact('marcas')
        );
    }

    public function storeMarca(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nome' => [
                    'required',
                    'string',
                    'max:255'
                ]
            ]
        );


        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();

        }


        $validated =
            $validator->validated();


        MarcaModel::create([
            'nome' =>
                $validated['nome'],
        ]);


        return redirect()
            ->back()
            ->with(
                'success',
                'Marca cadastrada com sucesso!'
            );
    }


    public function editMarca($id)
    {
        $marca =
            MarcaModel::findOrFail($id);


        return view(
            'admin.marcas.edit',
            compact('marca')
        );
    }


    public function updateMarca(Request $request, $id) {
        $marca =
            MarcaModel::findOrFail($id);


        $validator = Validator::make(
            $request->all(),
            [
                'nome' => [
                    'required',
                    'string',
                    'max:255'
                ]
            ]
        );


        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();

        }


        $validated =
            $validator->validated();


        $marca->update([
            'nome' =>
                $validated['nome'],
        ]);


        return redirect()
            ->route('admin.produtos.index')
            ->with(
                'success',
                'Marca atualizada com sucesso!'
            );
    }


    public function destroyMarca($id)
    {
        try {

            $marca =
                MarcaModel::findOrFail($id);


            $marca->delete();


            return redirect()
                ->route('admin.produtos.index')
                ->with(
                    'success',
                    'Marca excluída com sucesso!'
                );

        } catch (QueryException $e) {

            if ($e->getCode() == '23000') {

                return redirect()
                    ->route('admin.produtos.index')
                    ->with(
                        'error',
                        'Não é possível excluir esta marca, pois existem outros registros associados a ela.'
                    );

            }


            return redirect()
                ->route('admin.produtos.index')
                ->with(
                    'error',
                    'Occoreu um erro ao tentar excluir a marca.'
                );

        }
    }
}