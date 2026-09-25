<?php

namespace App\Http\Controllers;

use App\Models\CorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class CorController extends Controller
{
    public function indexCor()
    {
        $cores = CorModel::all();

        return view(
            'admin.cores.index',
            compact('cores')
        );
    }


    public function storeCor(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nome' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'estoque' => [
                    'required',
                    'integer',
                    'min:0'
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


        CorModel::create([
            'nome' =>
                $validated['nome'],

            'estoque' =>
                $validated['estoque']
        ]);


        return redirect()
            ->back()
            ->with(
                'success',
                'Cor cadastrada com sucesso!'
            );
    }


    public function editCor($id)
    {
        $cor =
            CorModel::findOrFail($id);


        return view(
            'admin.cores.edit',
            compact('cor')
        );
    }


    public function updateCor(
        Request $request,
        $id
    ) {
        $cor =
            CorModel::findOrFail($id);


        $validator = Validator::make(
            $request->all(),
            [
                'nome' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'estoque' => [
                    'required',
                    'integer',
                    'min:0'
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


        $cor->update([
            'nome' =>
                $validated['nome'],

            'estoque' =>
                $validated['estoque']
        ]);


        return redirect()
            ->route('admin.cores.index')
            ->with(
                'success',
                'Cor atualizada com sucesso!'
            );
    }


    public function destroyCor($id)
    {
        try {

            $cor =
                CorModel::findOrFail($id);


            $cor->delete();


            return redirect()
                ->route('admin.cores.index')
                ->with(
                    'success',
                    'Cor excluída com sucesso!'
                );

        } catch (QueryException $e) {

            if ($e->getCode() == '23000') {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Não é possível excluir esta cor, pois existem outros registros associados a ela.'
                    );

            }


            return redirect()
                ->back()
                ->with(
                    'error',
                    'Ocorreu um erro ao tentar excluir a cor.'
                );

        }
    }
}