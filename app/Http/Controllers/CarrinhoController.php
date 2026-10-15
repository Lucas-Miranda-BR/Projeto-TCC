<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\ItemModel;
use App\Models\PedidoModel;
use App\Models\CarrinhoItemModel;
use App\Models\DescontoModel;
use Carbon\Carbon;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class CarrinhoController extends Controller
{

    public function index()
    {
        $carrinho = session()->get('carrinho', []);
        $linhas = [];
        $total = 0;
        $cliente = Auth::user();

        foreach ($carrinho as $itemId => $quantidade) {
            $item = ItemModel::find($itemId);
            if ($item) {
                $subtotal = $item->preco_final * $quantidade;
                $total += $subtotal;
                
                $linhas[] = [
                    'item' => $item,
                    'quantidade' => $quantidade,
                    'subtotal' => $subtotal
                ];
            }
        }

        $temDescontoAniversario = false;
        $valorDescontoPercentual = 0;

        if ($cliente) {
            $valorDescontoPercentual = $this->getDescontoAniversario($cliente);
            if ($valorDescontoPercentual > 0) {
                $temDescontoAniversario = true;
                $total = $total - ($total * ($valorDescontoPercentual / 100));
            }
        }

        return view('cliente.carrinho', compact('linhas', 'total', 'temDescontoAniversario', 'valorDescontoPercentual'));    
    }

    public function adicionar(Request $request, $id)
    {
        $item = ItemModel::findOrFail($id);
        $quantidade = (int) $request->input('quantidade', 1);

        if ($item->estoque < $quantidade) {
            return redirect()->back()->with('erro', 'Estoque insuficiente.');
        }

        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            $novaQuantidade = $carrinho[$id] + $quantidade;
            if ($item->estoque < $novaQuantidade) {
                return redirect()->back()->with('erro', 'A quantidade total desejada excede o estoque.');
            }
            $carrinho[$id] = $novaQuantidade;
        } else {
            $carrinho[$id] = $quantidade;
        }

        session()->put('carrinho', $carrinho);
        return redirect()->route('cliente.carrinho')->with('success', 'Produto adicionado ao carrinho!');
    }

    public function atualizar(Request $request, $id)
    {
        $item = ItemModel::findOrFail($id);
        $quantidade = (int) $request->input('quantidade');

        if ($quantidade <= 0) {
            return $this->remover($id);
        }

        if ($item->estoque < $quantidade) {
            return redirect()->back()->with('erro', 'Estoque insuficiente.');
        }

        $carrinho = session()->get('carrinho', []);
        
        if (isset($carrinho[$id])) {
            $carrinho[$id] = $quantidade;
            session()->put('carrinho', $carrinho);
        }

        return redirect()->route('cliente.carrinho');
    }

    public function remover($id)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            unset($carrinho[$id]);
            session()->put('carrinho', $carrinho);
        }

        return redirect()->route('cliente.carrinho')->with('success', 'Produto removido do carrinho.');
    }

    private function getDescontoAniversario($cliente)
    {
        if (empty($cliente->data_nascimento)) {
            return 0;
        }

        $nascimento = Carbon::parse($cliente->data_nascimento);
        
        if ($nascimento->isBirthday()) {
            $descontoAniversario = DescontoModel::where('nome', 'like', '%aniversário%')->first();
            
            if ($descontoAniversario) {
                return (float) $descontoAniversario->valor;
            }
        }

        return 0;
    }

    public function finalizar()
    {
        $cliente = Auth::user();

        if (!$cliente) {
            return redirect()->route('cliente.login')->with('erro', 'Faça login para finalizar a compra.');
        }

        if (empty($cliente->cpf)) {
            return redirect()->route('cliente.carrinho')
                             ->with('erro', 'Para finalizar a compra, é obrigatório cadastrar o seu CPF. Atualize seus dados no perfil.');
        }

        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('cliente.carrinho')->with('erro', 'Seu carrinho está vazio.');
        }

        try {
            MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));

            $itensMercadoPago = [];
            $pedidoIdRetorno = null;
            $descontoCentavosGeral = 0;

            DB::transaction(function () use ($carrinho, $cliente, &$itensMercadoPago, &$pedidoIdRetorno, &$descontoCentavosGeral) {
                $produtosCompra = [];
                $totalCentavos = 0;

                foreach ($carrinho as $itemId => $quantidade) {
                    $item = ItemModel::where('item_id', $itemId)->lockForUpdate()->first();

                    if (!$item || $item->estoque < 1) {
                        throw ValidationException::withMessages([
                            'carrinho' => 'O produto "' . ($item ? $item->nome : 'desconhecido') . '" esgotou antes da finalização e foi removido.'
                        ]);
                    }

                    $quantidade = (int) $quantidade;

                    if ($item->estoque < $quantidade) {
                        throw ValidationException::withMessages([
                            'carrinho' => 'Estoque insuficiente para ' . $item->nome . '. Disponível: ' . $item->estoque
                        ]);
                    }

                    $precoCentavos = (int) round(((float) $item->preco_final) * 100);
                    $subtotalCentavos = $precoCentavos * $quantidade;
                    $totalCentavos += $subtotalCentavos;

                    $produtosCompra[] = [
                        'item' => $item,
                        'quantidade' => $quantidade,
                        'subtotal' => $subtotalCentavos / 100
                    ];
                }

                $valorDescontoPercentual = $this->getDescontoAniversario($cliente);
                $fatorDescontoAniversario = 1;
                
                if ($valorDescontoPercentual > 0) {
                    $descontoCentavosGeral = ($totalCentavos * $valorDescontoPercentual) / 100;
                    $totalCentavos -= $descontoCentavosGeral;
                    $fatorDescontoAniversario = 1 - ($valorDescontoPercentual / 100);
                }

                $pedido = PedidoModel::create([
                    'cliente_id' => $cliente->cliente_id,
                    'valor_total' => $totalCentavos / 100,
                    'valor_desconto' => $descontoCentavosGeral / 100,
                    'status' => 'P'
                ]);

                $pedidoIdRetorno = $pedido->pedido_id;

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

                    $precoParaMP = $item->preco_final * $fatorDescontoAniversario;

                    $itensMercadoPago[] = [
                        "id" => (string) $item->item_id,
                        "title" => $item->nome,
                        "quantity" => $produtoCompra['quantidade'],
                        "unit_price" => (float) round($precoParaMP, 2),
                        "currency_id" => "BRL"
                    ];
                }
            });

            $client = new PreferenceClient();
            
            $preference = $client->create([
                "items" => $itensMercadoPago,
                "external_reference" => (string) $pedidoIdRetorno,
                "back_urls" => [
                    "success" => route('site.pagamento.sucesso'),
                    "failure" => route('site.pagamento.falha'),
                    "pending" => route('site.pagamento.pendente')
                ],
                "auto_return" => "approved",
                "payer" => [
                    "name" => $cliente->nome,
                    "email" => $cliente->email,
                    "identification" => [
                        "type" => "CPF",
                        "number" => preg_replace('/[^0-9]/', '', $cliente->cpf)
                    ]
                ]
            ]);

            session()->forget('carrinho');

            return redirect()->away($preference->sandbox_init_point);

        } catch (ValidationException $e) {
            return redirect()->route('cliente.carrinho')->withErrors($e->errors());
        } catch (\Exception $e) {
            
            // CAPTURA DETALHADA PARA ENCONTRAR O ERRO
            $errorMessage = "Erro no Carrinho (MP): " . $e->getMessage();
            
            if (method_exists($e, 'getApiResponse') && $e->getApiResponse()) {
                $errorMessage .= " | Detalhes da API: " . json_encode($e->getApiResponse()->getContent());
            }

            dd($errorMessage);
        }
    }
}