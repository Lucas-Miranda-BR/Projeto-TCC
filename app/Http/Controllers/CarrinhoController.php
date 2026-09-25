<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\PedidoModel;
use App\Models\CarrinhoItemModel;
use App\Models\NotificacaoModel;
use App\Models\TemplateNotificacaoModel;
use App\Models\DescontoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class CarrinhoController extends Controller
{
    private function getDescontoAniversario($cliente)
    {
        if ($cliente && !empty($cliente->data_nascimento)) {
            $hoje = Carbon::today();
            $nascimento = Carbon::parse($cliente->data_nascimento);

            if ($hoje->month === $nascimento->month && $hoje->day === $nascimento->day) {
                
                $jaUsouDesconto = PedidoModel::where('cliente_id', $cliente->cliente_id)
                    ->whereDate('criado', $hoje)
                    ->exists();

                if (!$jaUsouDesconto) {
                    $regraDesconto = DescontoModel::where('nome', 'like', '%Aniversário%')->first();
                    if ($regraDesconto) {
                        return (float) $regraDesconto->valor;
                    }
                }
            }
        }
        return 0;
    }

    private function calcularTotalCarrinho($carrinho)
    {
        $totalCentavos = 0;
        
        foreach ($carrinho as $itemId => $qtd) {
            $item = ItemModel::find($itemId);
            if ($item && $item->estoque >= 2) {
                $precoCentavos = (int) round(((float) $item->preco) * 100);
                $totalCentavos += $precoCentavos * $qtd;
            }
        }

        $cliente = Auth::user();
        $valorDescontoPercentual = $this->getDescontoAniversario($cliente);

        if ($valorDescontoPercentual > 0) {
            $descontoCentavos = ($totalCentavos * $valorDescontoPercentual) / 100;
            $totalCentavos -= $descontoCentavos;
        }

        return $totalCentavos / 100;
    }

    public function index()
    {
        $cliente = Auth::user();

        if (!$cliente) {
            return redirect()
                ->route('cliente.login')
                ->with('erro', 'Faça login para acessar o seu carrinho.');
        }

        $carrinho = session()->get('carrinho', []);
        $linhas = [];
        $totalCentavos = 0;
        $avisos = [];
        $carrinhoAtualizou = false;

        $valorDescontoPercentual = $this->getDescontoAniversario($cliente);
        $temDescontoAniversario = $valorDescontoPercentual > 0;

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
                $avisos[] = "O estoque de '{$item->nome}' diminuiu. Ajustamos sua quantidade para {$item->estoque}.";
                
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

        if ($temDescontoAniversario) {
            $descontoCentavos = ($totalCentavos * $valorDescontoPercentual) / 100;
            $totalCentavos -= $descontoCentavos;
        }

        $total = $totalCentavos / 100;

        return view('cliente.carrinho', compact('linhas', 'total', 'temDescontoAniversario', 'valorDescontoPercentual'));
    }

    public function adicionar(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('cliente.login')
                ->with('erro', 'Faça login para adicionar produtos ao carrinho.');
        }

        $item = ItemModel::findOrFail($id);

        $dados = $request->validate([
            'quantidade' => ['required', 'integer', 'min:1']
        ]);

        $quantidade = (int) $dados['quantidade'];

        if ($item->estoque < 2) {
            return back()->with('erro', 'O produto "' . $item->nome . '" está esgotado.');
        }

        if ($quantidade > $item->estoque) {
            return back()->with('erro', 'Quantidade indisponível. Estoque atual: ' . $item->estoque . '.');
        }

        $carrinho = session()->get('carrinho', []);
        $quantidadeAtual = $carrinho[$item->item_id] ?? 0;
        $novaQuantidade = $quantidadeAtual + $quantidade;

        if ($novaQuantidade > $item->estoque) {
            $restante = $item->estoque - $quantidadeAtual;

            if ($restante <= 0) {
                return back()->with('erro', 'Você já possui a quantidade máxima disponível de "' . $item->nome . '" no carrinho.');
            }

            return back()->with('erro', 'Você pode adicionar apenas mais ' . $restante . ' unidade(s) de "' . $item->nome . '".');
        }

        $carrinho[$item->item_id] = $novaQuantidade;
        session()->put('carrinho', $carrinho);

        return back()->with('success', $quantidade . ' unidade(s) de "' . $item->nome . '" adicionada(s) ao carrinho!');
    }

    public function atualizar(Request $request, $id)
    {
        $item = ItemModel::findOrFail($id);

        $dados = $request->validate([
            'quantidade' => ['required', 'integer', 'min:1']
        ]);

        $quantidade = (int) $dados['quantidade'];
        $isAjax = $request->wantsJson() || $request->ajax();

        if ($item->estoque < 2) {
            $carrinho = session()->get('carrinho', []);
            unset($carrinho[$item->item_id]);
            session()->put('carrinho', $carrinho);

            if ($isAjax) {
                return response()->json([
                    'removido' => true,
                    'mensagem' => 'O produto "' . $item->nome . '" ficou sem estoque e foi removido do carrinho.',
                    'novo_total' => number_format($this->calcularTotalCarrinho($carrinho), 2, ',', '.')
                ]);
            }
            return back()->with('erro', 'O produto "' . $item->nome . '" ficou sem estoque e foi removido.');
        }

        if ($quantidade > $item->estoque) {
            if ($isAjax) {
                return response()->json([
                    'erro' => true,
                    'mensagem' => 'Quantidade indisponível. Estoque atual: ' . $item->estoque . '.',
                    'estoque_atual' => $item->estoque
                ]);
            }
            return back()->with('erro', 'Quantidade indisponível.');
        }

        $carrinho = session()->get('carrinho', []);
        $carrinho[$item->item_id] = $quantidade;
        session()->put('carrinho', $carrinho);

        if ($isAjax) {
            $subtotal = $item->preco * $quantidade;
            return response()->json([
                'success' => true,
                'novo_subtotal' => number_format($subtotal, 2, ',', '.'),
                'novo_total' => number_format($this->calcularTotalCarrinho($carrinho), 2, ',', '.')
            ]);
        }

        return back()->with('success', 'Quantidade atualizada!');
    }

    public function remover($id)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            unset($carrinho[$id]);
        }

        session()->put('carrinho', $carrinho);

        return back()->with('success', 'Produto removido do carrinho.');
    }

    public function finalizar()
    {
        $cliente = Auth::user();

        if (!$cliente) {
            return redirect()->route('cliente.login')->with('erro', 'Faça login para finalizar a compra.');
        }

        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('erro', 'Seu carrinho está vazio.');
        }

        try {
            $pedido = DB::transaction(function () use ($carrinho, $cliente) {
                $produtosCompra = [];
                $totalCentavos = 0;

                foreach ($carrinho as $itemId => $quantidade) {
                    $item = ItemModel::where('item_id', $itemId)->lockForUpdate()->first();

                    if (!$item || $item->estoque < 2) {
                        throw ValidationException::withMessages([
                            'carrinho' => 'O produto "' . ($item ? $item->nome : 'desconhecido') . '" esgotou antes da finalização e foi removido do carrinho.'
                        ]);
                    }

                    $quantidade = (int) $quantidade;

                    if ($quantidade <= 0) {
                        throw ValidationException::withMessages([
                            'carrinho' => 'Quantidade inválida no carrinho.'
                        ]);
                    }

                    if ($item->estoque < $quantidade) {
                        throw ValidationException::withMessages([
                            'carrinho' => 'Estoque insuficiente para ' . $item->nome . '. Disponível: ' . $item->estoque
                        ]);
                    }

                    $precoCentavos = (int) round(((float) $item->preco) * 100);
                    $subtotalCentavos = $precoCentavos * $quantidade;
                    $totalCentavos += $subtotalCentavos;

                    $produtosCompra[] = [
                        'item' => $item,
                        'quantidade' => $quantidade,
                        'subtotal' => $subtotalCentavos / 100
                    ];
                }

                $valorDescontoPercentual = $this->getDescontoAniversario($cliente);
                $descontoCentavos = 0;
                
                if ($valorDescontoPercentual > 0) {
                    $descontoCentavos = ($totalCentavos * $valorDescontoPercentual) / 100;
                    $totalCentavos -= $descontoCentavos;
                }

                $pedido = PedidoModel::create([
                    'cliente_id' => $cliente->cliente_id,
                    'valor_total' => $totalCentavos / 100
                ]);

                foreach ($produtosCompra as $produtoCompra) {
                    $item = $produtoCompra['item'];

                    CarrinhoItemModel::create([
                        'pedido_id' => $pedido->pedido_id,
                        'item_id' => $item->item_id,
                        'quantidade' => $produtoCompra['quantidade'],
                        'subtotal' => $produtoCompra['subtotal']
                    ]);

                    $item->estoque -= $produtoCompra['quantidade'];
                    $item->save();
                }

                $template = TemplateNotificacaoModel::where('tipo', 'compra_confirmada')->first();

                if ($template) {
                    $valorFormatado = number_format($pedido->valor_total, 2, ',', '.');
                    $descontoFormatado = number_format($descontoCentavos / 100, 2, ',', '.');
                    
                    $textoFinal = str_replace(
                        ['{pedido}', '{valor}', '{desconto}'], 
                        [$pedido->pedido_id, $valorFormatado, $descontoFormatado], 
                        $template->conteudo
                    );

                    NotificacaoModel::create([
                        'cliente_id' => $cliente->cliente_id,
                        'titulo' => $template->titulo,
                        'conteudo' => $textoFinal,
                        'data_recebida' => now(),
                        'visualizada' => false
                    ]);
                }

                return $pedido;
            });

            session()->forget('carrinho');

            return redirect()->route('site.produtos')->with('success', 'Compra realizada com sucesso! Pedido #' . $pedido->pedido_id);

        } catch (ValidationException $e) {
            return redirect()->route('carrinho.index')->withErrors($e->errors());
        }
    }
}