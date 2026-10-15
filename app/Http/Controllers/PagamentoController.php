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
    public function retornoSucesso(Request $request)
    {
        $pedidoId = $request->input('external_reference');

        if ($pedidoId) {
            $pedido = PedidoModel::with('itens.item')->find($pedidoId);

            if ($pedido && $pedido->status !== 'A') {
                $pedido->status = 'A';
                $pedido->pedido_data = now(); 
                $pedido->save();

                foreach ($pedido->itens as $pedidoItem) {
                    $item = $pedidoItem->item;
                    if ($item) {
                        $item->estoque -= $pedidoItem->quantidade;
                        if ($item->estoque < 0) {
                            $item->estoque = 0;
                        }
                        $item->save();
                    }
                }

                $this->dispararNotificacaoCompra($pedido);
            }
        }

        return redirect()->route('site.produtos')
            ->with('success', 'Pagamento aprovado! O seu pedido já está sendo preparado.');
    }

    public function retornoFalha(Request $request)
    {
        $pedidoId = $request->input('external_reference');

        if ($pedidoId) {
            $pedido = PedidoModel::find($pedidoId);

            if ($pedido && !in_array($pedido->status, ['R', 'C', 'A'])) {
                $pedido->status = 'R';
                $pedido->save();
            }
        }

        return redirect()->route('cliente.carrinho')
            ->with('erro', 'O pagamento foi recusado ou cancelado. Tente novamente.');
    }

    public function retornoPendente(Request $request)
    {
        $pedidoId = $request->input('external_reference');

        if ($pedidoId) {
            $pedido = PedidoModel::find($pedidoId);
            if ($pedido && $pedido->status !== 'A') {
                $pedido->status = 'P';
                $pedido->save();
            }
        }

        return redirect()->route('site.produtos')
            ->with('success', 'Seu pagamento está em análise. Avisaremos quando for aprovado!');
    }

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
                $pedido = PedidoModel::with('itens.item')->find($pedidoId);

                if ($pedido) {
                    $statusMp = $payment->status;

                    if ($statusMp === 'approved' && $pedido->status !== 'A') {
                        $pedido->status = 'A';
                        $pedido->pedido_data = now(); 
                        $pedido->save();

                        foreach ($pedido->itens as $pedidoItem) {
                            $item = $pedidoItem->item;
                            if ($item) {
                                $item->estoque -= $pedidoItem->quantidade;
                                if ($item->estoque < 0) $item->estoque = 0;
                                $item->save();
                            }
                        }

                        $this->dispararNotificacaoCompra($pedido);
                    }
                    elseif (in_array($statusMp, ['rejected', 'cancelled', 'refunded']) && !in_array($pedido->status, ['R', 'C', 'A'])) {
                        $pedido->status = 'R';
                        $pedido->save();
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Erro no Webhook: " . $e->getMessage());
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