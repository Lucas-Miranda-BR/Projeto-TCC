<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PedidoModel;
use App\Models\CarrinhoItemModel;
use App\Models\TemplateNotificacaoModel;
use App\Models\NotificacaoModel;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

class PagamentoController extends Controller
{
    public function webhook(Request $request)
    {
        try {
            MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));

            $paymentId = $request->input('data.id') ?? $request->input('id');
            $topic = $request->input('type') ?? $request->input('topic');

            if ($topic === 'payment' && $paymentId) {
                
                $client = new PaymentClient();
                $payment = $client->get($paymentId);

                $pedidoId = $payment->external_reference;
                $pedido = PedidoModel::with('itens')->find($pedidoId);

                if ($pedido) {
                    $statusMp = $payment->status;

                    // 1. PAGAMENTO APROVADO
                    if ($statusMp === 'approved' && $pedido->status !== 'A') {
                        $pedido->status = 'A';
                        $pedido->pedido_data = now(); 
                        $pedido->save();

                        $this->dispararNotificacaoCompra($pedido);
                    }

                    // 2. PAGAMENTO RECUSADO OU CANCELADO
                    elseif (in_array($statusMp, ['rejected', 'cancelled', 'refunded']) && !in_array($pedido->status, ['R', 'C'])) {
                        
                        $pedido->status = 'R';
                        $pedido->save();

                        foreach ($pedido->itens as $pedidoItem) {
                            $item = $pedidoItem->item;
                            if ($item) {
                                $item->estoque += $pedidoItem->quantidade;
                                $item->save();
                            }
                        }

                        Log::info("Pedido #{$pedido->pedido_id} cancelado/recusado pelo Mercado Pago. Estoque devolvido.");
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Erro no Webhook do Mercado Pago: " . $e->getMessage());
            
            if (method_exists($e, 'getApiResponse') && $e->getApiResponse()) {
                Log::error("Detalhes da API do Webhook: " . json_encode($e->getApiResponse()->getContent()));
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    private function dispararNotificacaoCompra($pedido)
    {
        $template = TemplateNotificacaoModel::where('tipo', 'compra_confirmada')->first();
        
        if ($template) {
            $valorFormatado = number_format($pedido->valor_total, 2, ',', '.');
            $valorDesconto = $pedido->valor_desconto ?? 0;
            $descontoFormatado = number_format($valorDesconto, 2, ',', '.');
            
            $textoFinal = str_replace(
                ['{pedido}', '{valor}', '{desconto}'], 
                [$pedido->pedido_id, $valorFormatado, $descontoFormatado], 
                $template->conteudo
            );

            NotificacaoModel::create([
                'cliente_id' => $pedido->cliente_id,
                'titulo' => $template->titulo,
                'conteudo' => $textoFinal,
                'data_recebida' => now(),
                'visualizada' => false
            ]);
        }
    }
}