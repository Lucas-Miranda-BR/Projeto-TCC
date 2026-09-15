<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\PedidoModel;
use App\Models\CarrinhoItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CarrinhoController extends Controller
{
    public function index()
    {
        $carrinho = session()->get('carrinho', []);
        $linhas = [];
        $totalCentavos = 0;
        $avisos = [];
        $carrinhoAtualizou = false;

        foreach ($carrinho as $itemId => $quantidade) {

            $item = ItemModel::with(['marcas', 'categorias'])->find($itemId);

            if (!$item || $item->estoque < 2) {
                $nomeProduto = $item ? $item->nome : 'Produto indisponível';
                $avisos[] = "O produto '{$nomeProduto}' esgotou e foi removido do seu carrinho.";
                
                unset($carrinho[$itemId]);
                $carrinhoAtualizou = true;
                continue; 
            }

            $quantidade = (int) $quantidade;

            if ($quantidade > $item->estoque) {
                $avisos[] = "O estoque de '{$item->nome}' diminuiu. Ajustamos sua quantidade para {$item->estoque} unidade(s).";
                
                $quantidade = $item->estoque;
                $carrinho[$itemId] = $quantidade;
                $carrinhoAtualizou = true;
            }

            $precoCentavos = (int) round(((float) $item->preco) * 100);
            $subtotalCentavos = $precoCentavos * $quantidade;
            $totalCentavos += $subtotalCentavos;

            $linhas[] = [
                'item' => $item,
                'quantidade' => $quantidade,
                'subtotal' => $subtotalCentavos / 100
            ];
        }

        if ($carrinhoAtualizou) {
            session()->put('carrinho', $carrinho);
            session()->flash('avisos', $avisos);
        }

        $total = $totalCentavos / 100;

        return view('cliente.carrinho', compact('linhas', 'total'));
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

            return back()->with(
                'erro',
                'O produto "' . $item->nome . '" está esgotado.'
            );
        }

        if ($quantidade > $item->estoque) {

            return back()->with(
                'erro',
                'Quantidade indisponível. Estoque atual: ' .
                $item->estoque .
                '.'
            );
        }

        $carrinho = session()->get(
            'carrinho',
            []
        );

        $quantidadeAtual =
            $carrinho[$item->item_id] ?? 0;

        $novaQuantidade =
            $quantidadeAtual + $quantidade;

        if ($novaQuantidade > $item->estoque) {

            $restante =
                $item->estoque - $quantidadeAtual;

            if ($restante <= 0) {

                return back()->with(
                    'erro',
                    'Você já possui a quantidade máxima disponível de "' .
                    $item->nome .
                    '" no carrinho.'
                );
            }

            return back()->with(
                'erro',
                'Você pode adicionar apenas mais ' .
                $restante .
                ' unidade(s) de "' .
                $item->nome .
                '".'
            );
        }

        $carrinho[$item->item_id] =
            $novaQuantidade;

        session()->put(
            'carrinho',
            $carrinho
        );

        return back()->with(
            'success',
            $quantidade .
            ' unidade(s) de "' .
            $item->nome .
            '" adicionada(s) ao carrinho!'
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

        $quantidade =
            (int) $dados['quantidade'];

        if ($item->estoque <= 0) {

            $carrinho = session()->get(
                'carrinho',
                []
            );

            unset($carrinho[$item->item_id]);

            session()->put(
                'carrinho',
                $carrinho
            );

            return back()->with(
                'erro',
                'O produto "' .
                $item->nome .
                '" ficou sem estoque e foi removido do carrinho.'
            );
        }

        if ($quantidade > $item->estoque) {

            return back()->with(
                'erro',
                'Quantidade indisponível. Estoque atual: ' .
                $item->estoque .
                '.'
            );
        }

        $carrinho = session()->get(
            'carrinho',
            []
        );

        $carrinho[$item->item_id] =
            $quantidade;

        session()->put(
            'carrinho',
            $carrinho
        );

        return back()->with(
            'success',
            'Quantidade atualizada com sucesso!'
        );
    }

    public function remover($id)
    {
        $carrinho = session()->get(
            'carrinho',
            []
        );

        if (isset($carrinho[$id])) {
            unset($carrinho[$id]);
        }

        session()->put(
            'carrinho',
            $carrinho
        );

        return back()->with(
            'success',
            'Produto removido do carrinho.'
        );
    }

    public function finalizar()
    {
        $cliente = Auth::user();

        if (!$cliente) {

            return redirect()
                ->route('cliente.login')
                ->with(
                    'erro',
                    'Faça login para finalizar a compra.'
                );
        }

        $carrinho = session()->get(
            'carrinho',
            []
        );

        if (empty($carrinho)) {

            return redirect()
                ->route('carrinho.index')
                ->with(
                    'erro',
                    'Seu carrinho está vazio.'
                );
        }

        $pedido = DB::transaction(
            function () use (
                $carrinho,
                $cliente
            ) {

                $produtosCompra = [];

                $totalCentavos = 0;

                foreach (
                    $carrinho
                    as $itemId => $quantidade
                ) {

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

                    $quantidade =
                        (int) $quantidade;

                    if ($quantidade <= 0) {

                        throw ValidationException::withMessages([
                            'carrinho' =>
                                'Quantidade inválida no carrinho.'
                        ]);
                    }

                    if (
                        $item->estoque <
                        $quantidade
                    ) {

                        throw ValidationException::withMessages([
                            'carrinho' =>
                                'Estoque insuficiente para ' .
                                $item->nome .
                                '. Disponível: ' .
                                $item->estoque
                        ]);
                    }

                    $precoCentavos =
                        (int) round(
                            ((float) $item->preco) * 100
                        );

                    $subtotalCentavos =
                        $precoCentavos *
                        $quantidade;

                    $totalCentavos +=
                        $subtotalCentavos;

                    $produtosCompra[] = [
                        'item' => $item,
                        'quantidade' => $quantidade,
                        'subtotal' =>
                            $subtotalCentavos / 100
                    ];
                }

                $pedido = PedidoModel::create([
                    'cliente_id' =>
                        $cliente->cliente_id,

                    'valor_total' =>
                        $totalCentavos / 100
                ]);

                foreach (
                    $produtosCompra
                    as $produtoCompra
                ) {

                    $item =
                        $produtoCompra['item'];

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
            }
        );

        session()->forget('carrinho');

        return redirect()
            ->route('site.produtos')
            ->with(
                'success',
                'Compra realizada com sucesso! Pedido #' .
                $pedido->pedido_id
            );
    }
}