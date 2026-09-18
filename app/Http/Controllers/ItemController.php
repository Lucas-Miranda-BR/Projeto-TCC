<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\MarcaModel;
use App\Models\CategoriaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
                'max:2048'
            ]
        ]);

        try {
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $destino = public_path('images/produtos');

                if (!File::isDirectory($destino)) {
                    File::makeDirectory($destino, 0755, true, true);
                }

                $nomeImagem = time() . '_' . uniqid() . '.' . $request->foto->extension();
                $request->foto->move($destino, $nomeImagem);

                $dados['foto'] = $nomeImagem;
            }

            ItemModel::create($dados);

            return redirect()
                ->route('admin.produtos.index')
                ->with('success', 'Produto cadastrado com sucesso!');
        } catch (\Throwable $e) {
            if (isset($nomeImagem) && File::exists(public_path('images/produtos/' . $nomeImagem))) {
                File::delete(public_path('images/produtos/' . $nomeImagem));
            }

            return back()
                ->withInput()
                ->withErrors([
                    'Ocorreu um erro ao cadastrar o produto: ' . $e->getMessage()
                ]);
        }
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

        try {
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $destino = public_path('images/produtos');

                if (!File::isDirectory($destino)) {
                    File::makeDirectory($destino, 0755, true, true);
                }

                $nomeNovaImagem = time() . '_' . uniqid() . '.' . $request->foto->extension();
                $request->foto->move($destino, $nomeNovaImagem);

                if ($produto->foto && File::exists(public_path('images/produtos/' . $produto->foto))) {
                    File::delete(public_path('images/produtos/' . $produto->foto));
                }

                $dados['foto'] = $nomeNovaImagem;
            }

            $produto->update($dados);

            return redirect()
                ->route('admin.produtos.index')
                ->with('success', 'Produto atualizado com sucesso!');
        } catch (\Throwable $e) {
            if (isset($nomeNovaImagem) && File::exists(public_path('images/produtos/' . $nomeNovaImagem))) {
                File::delete(public_path('images/produtos/' . $nomeNovaImagem));
            }

            return back()
                ->withInput()
                ->withErrors([
                    'Ocorreu um erro ao atualizar o produto: ' . $e->getMessage()
                ]);
        }
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

        if ($produto->foto && File::exists(public_path('images/produtos/' . $produto->foto))) {
            File::delete(public_path('images/produtos/' . $produto->foto));
        }

        $produto->delete();

        return redirect()
            ->route('admin.produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}