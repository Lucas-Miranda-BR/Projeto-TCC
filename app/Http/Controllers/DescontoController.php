<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DescontoModel;
use App\Models\ItemModel;
use App\Models\MarcaModel; 
use App\Models\CategoriaModel; 
use Carbon\Carbon;

class DescontoController extends Controller
{
    public function index()
    {
        $descontos = DescontoModel::all();
        return view('admin.descontos.index', compact('descontos'));
    }

    public function create()
    {
        $itens = ItemModel::all();
        $marcas = MarcaModel::all();
        $categorias = CategoriaModel::all();

        return view('admin.descontos.create', compact('itens', 'marcas', 'categorias'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:255'],
            'valor' => ['required', 'numeric', 'min:0'],
            'quando_terminar' => ['nullable', 'date', 'after_or_equal:today'],
            'itens' => ['nullable', 'array'],
            'marcas' => ['nullable', 'array'],
            'categorias' => ['nullable', 'array'],
            'excecoes' => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $itensParaAplicar = $this->obterItensSincronizacao($request);

        if (empty($itensParaAplicar)) {
            return redirect()->back()
                ->with('erro', 'Você precisa selecionar pelo menos um Item, Marca ou Categoria válida para criar este desconto.')
                ->withInput();
        }

        $desconto = DescontoModel::create([
            'nome' => $request->nome,
            'valor' => $request->valor,
            'quando_terminar' => $request->quando_terminar ? Carbon::parse($request->quando_terminar)->format('Y-m-d') : null,
        ]);

        $desconto->itens()->sync($itensParaAplicar);

        return redirect()->route('admin.descontos.index')->with('success', 'Desconto criado com sucesso!');
    }

    public function edit($id)
    {
        $desconto = DescontoModel::with('itens')->findOrFail($id);
        
        $itens = ItemModel::all();
        $marcas = MarcaModel::all();
        $categorias = CategoriaModel::all();

        return view('admin.descontos.edit', compact('desconto', 'itens', 'marcas', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $desconto = DescontoModel::findOrFail($id);
        $isAniversario = stripos($desconto->nome, 'aniversário') !== false;

        $regrasValidacao = [
            'valor' => ['required', 'numeric', 'min:0'],
        ];

        if (!$isAniversario) {
            $regrasValidacao['nome'] = ['required', 'string', 'max:255'];
            $regrasValidacao['quando_terminar'] = ['nullable', 'date', 'after_or_equal:today'];
            $regrasValidacao['itens'] = ['nullable', 'array'];
            $regrasValidacao['marcas'] = ['nullable', 'array'];
            $regrasValidacao['categorias'] = ['nullable', 'array'];
            $regrasValidacao['excecoes'] = ['nullable', 'array'];
        }

        $validator = Validator::make($request->all(), $regrasValidacao);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!$isAniversario) {
            $itensParaAplicar = $this->obterItensSincronizacao($request);

            if (empty($itensParaAplicar)) {
                return redirect()->back()
                    ->with('erro', 'O desconto precisa ter pelo menos um item vinculado.')
                    ->withInput();
            }

            $desconto->update([
                'nome' => $request->nome,
                'valor' => $request->valor,
                'quando_terminar' => $request->quando_terminar ? Carbon::parse($request->quando_terminar)->format('Y-m-d') : null,
            ]);

            $desconto->itens()->sync($itensParaAplicar);
        } else {
            $desconto->update([
                'valor' => $request->valor,
            ]);
        }

        return redirect()->route('admin.descontos.index')->with('success', 'Desconto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $desconto = DescontoModel::findOrFail($id);
        
        $desconto->itens()->detach();
        $desconto->delete();

        return redirect()->route('admin.descontos.index')->with('success', 'Desconto excluído com sucesso!');
    }


    private function obterItensSincronizacao(Request $request)
    {
        $itemIds = $request->itens ?? [];

        if (!empty($request->marcas)) {
            $itensMarcas = ItemModel::whereIn('marca_id', $request->marcas)->pluck('item_id')->toArray();
            $itemIds = array_merge($itemIds, $itensMarcas);
        }

        if (!empty($request->categorias)) {
            $itensCategorias = ItemModel::whereIn('categoria_id', $request->categorias)->pluck('item_id')->toArray();
            $itemIds = array_merge($itemIds, $itensCategorias);
        }

        $itemIdsUnicos = array_unique($itemIds);

        if (!empty($request->excecoes)) {
            $itemIdsUnicos = array_diff($itemIdsUnicos, $request->excecoes);
        }

        return $itemIdsUnicos;
    }
}