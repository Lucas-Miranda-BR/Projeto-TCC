<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\MarcaModel;
use App\Models\CategoriaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $produtos = ItemModel::with([
            'marcas',
            'categorias'
        ])
            ->orderBy('nome')
            ->get();

        $marcas = MarcaModel::orderBy('nome')->get();

        $categorias = CategoriaModel::orderBy('nome')->get();

        return view(
            'admin.produtos.index',
            compact(
                'produtos',
                'marcas',
                'categorias'
            )
        );
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255'
            ],

            'preco' => [
                'required',
                'numeric',
                'min:0'
            ],

            'estoque' => [
                'required',
                'integer',
                'min:0'
            ],

            'marca_id' => [
                'nullable',
                'integer',
                'exists:marca,marca_id'
            ],

            'categoria_id' => [
                'nullable',
                'integer',
                'exists:categoria,categoria_id'
            ],

            'foto' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096'
            ]
        ]);

        $dados['foto'] = $request
            ->file('foto')
            ->store('produtos', 'public');

        ItemModel::create($dados);

        return redirect()
            ->route('admin.produtos.index')
            ->with(
                'success',
                'Produto cadastrado com sucesso!'
            );
    }

    public function edit($id)
    {
        $produto = ItemModel::findOrFail($id);

        $marcas = MarcaModel::orderBy('nome')->get();

        $categorias = CategoriaModel::orderBy('nome')->get();

        return view(
            'admin.produtos.edit',
            compact(
                'produto',
                'marcas',
                'categorias'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $produto = ItemModel::findOrFail($id);

        $dados = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255'
            ],

            'preco' => [
                'required',
                'numeric',
                'min:0'
            ],

            'estoque' => [
                'required',
                'integer',
                'min:0'
            ],

            'marca_id' => [
                'nullable',
                'integer',
                'exists:marca,marca_id'
            ],

            'categoria_id' => [
                'nullable',
                'integer',
                'exists:categoria,categoria_id'
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096'
            ]
        ]);

        if ($request->hasFile('foto')) {

            if (
                $produto->foto &&
                Storage::disk('public')->exists($produto->foto)
            ) {
                Storage::disk('public')->delete($produto->foto);
            }

            $dados['foto'] = $request
                ->file('foto')
                ->store('produtos', 'public');
        }

        $produto->update($dados);

        return redirect()
            ->route('admin.produtos.index')
            ->with(
                'success',
                'Produto atualizado com sucesso!'
            );
    }

    public function destroy($id)
    {
        $produto = ItemModel::findOrFail($id);

        if ($produto->carrinhos_itens()->exists()) {
            return redirect()
                ->route('admin.produtos.index')
                ->withErrors([
                    'Esse produto não pode ser excluído porque já faz parte de um pedido.'
                ]);
        }

        if (
            $produto->foto &&
            Storage::disk('public')->exists($produto->foto)
        ) {
            Storage::disk('public')->delete($produto->foto);
        }

        $produto->delete();

        return redirect()
            ->route('admin.produtos.index')
            ->with(
                'success',
                'Produto excluído com sucesso!'
            );
    }
}