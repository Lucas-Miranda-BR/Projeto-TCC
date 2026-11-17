<?php

namespace App\Http\Controllers;

use App\Models\CategoriaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class CategoriaController extends Controller
{
    public function indexCategoria()
    {
        $categorias = CategoriaModel::all();

        return view(
            'admin.categorias.index',
            compact('categorias')
        );
    }

    public function storeCategoria(Request $request)
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


        CategoriaModel::create([
            'nome' =>
                $validated['nome'],
        ]);


        return redirect()
            ->back()
            ->with(
                'success',
                'Categoria cadastrada com sucesso!'
            );
    }


    public function editCategoria($id)
    {
        $categoria =
            CategoriaModel::findOrFail($id);


        return view(
            'admin.categorias.edit',
            compact('categoria')
        );
    }


    public function updateCategoria(Request $request, $id) {
        $categoria =
            CategoriaModel::findOrFail($id);


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


        $categoria->update([
            'nome' =>
                $validated['nome'],
        ]);


        return redirect()
            ->route('admin.categorias.index')
            ->with(
                'success',
                'Categoria atualizada com sucesso!'
            );
    }


    public function destroyCategoria($id)
    {
        try {

            $categoria =
                CategoriaModel::findOrFail($id);


            $categoria->delete();


            return redirect()
                ->route('admin.categorias.index')
                ->with(
                    'success',
                    'Categoria excluída com sucesso!'
                );

        } catch (QueryException $e) {

            if ($e->getCode() == '23000') {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Não é possível excluir esta categoria, pois existem outros registros associados a ela.'
                    );

            }


            return redirect()
                ->back()
                ->with(
                    'error',
                    'Occoreu um erro ao tentar excluir a categoria.'
                );

        }
    }
}