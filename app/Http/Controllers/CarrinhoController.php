<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\PedidoModel;
use App\Models\CarrinhoItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CarrinhoController extends Controller
{
    public function index()
    {
        $carrinho = session('carrinho', []);

        $linhas = [];

        $totalCentavos = 0;

        foreach ($carrinho as $itemId => $quantidade) {

            $item = ItemModel::with([
                'marcas',
                'categorias'
            ])->find($itemId);

            if (!$item) {
                continue;
            }

            $precoCentavos = (int) round(
                ((float) $item->preco) * 100
            );

            $subtotalCentavos =
                $precoCentavos * $quantidade;

            $totalCentavos += $subtotalCentavos;

            $linhas[] = [
                'item' => $item,
                'quantidade' => $quantidade,
                'subtotal' => $subtotalCentavos / 100
            ];
        }

        $total = $totalCentavos / 100;

        return view(
            'cliente.carrinho',
            compact(
                'linhas',
                'total'
            )
        );
    }

    public function adicionar(Request $request, $id)
    {
        $item = ItemModel::findOrFail($id);

        $dados = $request->validate([
            'quantidade' => [
                'required',
                'integer',
                'min:1'
            ]
        ]);

        $quantidade = (int) $dados['quantidade'];

        if ($item->estoque <= 0) {
            return back()->withErrors([
                'Esse produto está sem estoque.'
            ]);
        }

        $carrinho = session('carrinho', []);

        $quantidadeAtual =
            $carrinho[$item->item_id] ?? 0;

        $novaQuantidade =
            $quantidadeAtual + $quantidade;

        if ($novaQuantidade > $item->estoque) {
            return back()->withErrors([
                'Quantidade indisponível. Estoque atual: '
                . $item->estoque
                . '.'
            ]);
        }

        $carrinho[$item->item_id] =
            $novaQuantidade;

        session([
            'carrinho' => $carrinho
        ]);

        return back()->with(
            'success',
            'Produto adicionado ao carrinho!'
        );
    }

    public function atualizar(Request $request, $id)
    {
        $item = ItemModel::findOrFail($id);

        $dados = $request->validate([
            'quantidade' => [
                'required',
                'integer',
                'min:1'
            ]
        ]);

        $quantidade = (int) $dados['quantidade'];

        if ($quantidade > $item->estoque) {
            return back()->withErrors([
                'Quantidade indisponível. Estoque atual: '
                . $item->estoque
                . '.'
            ]);
        }

        $carrinho = session('carrinho', []);

        $carrinho[$item->item_id] =
            $quantidade;

        session([
            'carrinho' => $carrinho
        ]);

        return back()->with(
            'success',
            'Carrinho atualizado!'
        );
    }

    public function remover($id)
    {
        $carrinho = session('carrinho', []);

        unset($carrinho[$id]);

        session([
            'carrinho' => $carrinho
        ]);

        return back()->with(
            'success',
            'Produto removido do carrinho.'
        );
    }

    public function finalizar()
    {
        $cliente = session('cliente');

        if (!$cliente) {
            return redirect()
                ->route('cliente.login')
                ->with(
                    'erro',
                    'Faça login para finalizar a compra.'
                );
        }

        $carrinho = session('carrinho', []);

        if (empty($carrinho)) {
            return redirect()
                ->route('carrinho.index')
                ->withErrors([
                    'Seu carrinho está vazio.'
                ]);
        }

        $pedido = DB::transaction(function () use (
            $carrinho,
            $cliente
        ) {

            $produtosCompra = [];

            $totalCentavos = 0;

            foreach ($carrinho as $itemId => $quantidade) {

                $item = ItemModel::where(
                    'item_id',
                    $itemId
                )
                    ->lockForUpdate()
                    ->first();

                if (!$item) {
                    throw ValidationException::withMessages([
                        'carrinho' =>
                            'Um produto do carrinho não existe mais.'
                    ]);
                }

                $quantidade = (int) $quantidade;

                if ($quantidade <= 0) {
                    throw ValidationException::withMessages([
                        'carrinho' =>
                            'Quantidade inválida no carrinho.'
                    ]);
                }

                if ($item->estoque < $quantidade) {
                    throw ValidationException::withMessages([
                        'carrinho' =>
                            'Estoque insuficiente para '
                            . $item->nome
                            . '. Disponível: '
                            . $item->estoque
                    ]);
                }

                $precoCentavos = (int) round(
                    ((float) $item->preco) * 100
                );

                $subtotalCentavos =
                    $precoCentavos * $quantidade;

                $totalCentavos +=
                    $subtotalCentavos;

                $produtosCompra[] = [
                    'item' => $item,
                    'quantidade' => $quantidade,
                    'subtotal' => $subtotalCentavos / 100
                ];
            }

            $pedido = PedidoModel::create([
                'cliente_id' =>
                    $cliente->cliente_id,

                'valor_total' =>
                    $totalCentavos / 100
            ]);

            foreach ($produtosCompra as $produtoCompra) {

                $item = $produtoCompra['item'];

                CarrinhoItemModel::create([
                    'pedido_id' =>
                        $pedido->pedido_id,

                    'item_id' =>
                        $item->item_id,

                    'quantidade' =>
                        $produtoCompra['quantidade'],

                    'subtotal' =>
                        $produtoCompra['subtotal']
                ]);

                $item->estoque -=
                    $produtoCompra['quantidade'];

                $item->save();
            }

            return $pedido;
        });

        session()->forget('carrinho');

        return redirect()
            ->route('site.produtos')
            ->with(
                'success',
                'Compra realizada com sucesso! Pedido #'
                . $pedido->pedido_id
            );
    }
}