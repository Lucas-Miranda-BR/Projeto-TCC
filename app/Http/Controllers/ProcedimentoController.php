<?php

namespace App\Http\Controllers;

use App\Models\Procedimento;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcedimentoController extends Controller
{
    public function index()
    {
        $procedimentos = Procedimento::with('tipo')
            ->orderBy('nome')
            ->get();

        $tipos = Tipo::orderBy('nome')
            ->get();

        return view(
            'admin.procedimentos.index',
            compact(
                'procedimentos',
                'tipos'
            )
        );
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'tipo_id' => [
                'required',
                'integer',
                'exists:tipo,tipo_id'
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
            ],

            'imagem' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096'
            ]
        ]);

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request
                ->file('imagem')
                ->store(
                    'procedimentos',
                    'public'
                );
        }

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

        $tipos = Tipo::orderBy('nome')
            ->get();

        return view(
            'admin.procedimentos.edit',
            compact(
                'procedimento',
                'tipos'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $procedimento = Procedimento::findOrFail($id);

        $dados = $request->validate([
            'tipo_id' => [
                'required',
                'integer',
                'exists:tipo,tipo_id'
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
            ],

            'imagem' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096'
            ]
        ]);

        if ($request->hasFile('imagem')) {

            if (
                $procedimento->imagem &&
                Storage::disk('public')->exists(
                    $procedimento->imagem
                )
            ) {
                Storage::disk('public')
                    ->delete($procedimento->imagem);
            }

            $dados['imagem'] = $request
                ->file('imagem')
                ->store(
                    'procedimentos',
                    'public'
                );
        }

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

        if (
            $procedimento->imagem &&
            Storage::disk('public')->exists(
                $procedimento->imagem
            )
        ) {
            Storage::disk('public')
                ->delete($procedimento->imagem);
        }

        $procedimento->delete();

        return redirect()
            ->route('admin.procedimentos.index')
            ->with(
                'success',
                'Serviço excluído com sucesso!'
            );
    }
}