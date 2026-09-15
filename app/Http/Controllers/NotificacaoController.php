<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\NotificacaoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('cliente.login');
        }

        $cliente = Auth::user();

        if ($cliente->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $notificacoes = NotificacaoModel::where(
                'cliente_id',
                $cliente->cliente_id
            )
            ->orderByDesc('data_recebida')
            ->get();

        return view(
            'cliente.notificacoes',
            compact('notificacoes')
        );
    }

    public function marcarComoVisualizada($id)
    {
        if (!Auth::check()) {
            return redirect()->route('cliente.login');
        }

        $cliente = Auth::user();

        if ($cliente->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $notificacao = NotificacaoModel::where(
                'notificacao_id',
                $id
            )
            ->where(
                'cliente_id',
                $cliente->cliente_id
            )
            ->firstOrFail();

        $notificacao->update([
            'visualizada' => true
        ]);

        return redirect()
            ->route('cliente.notificacoes')
            ->with(
                'success',
                'Notificação marcada como visualizada.'
            );
    }

    public function marcarTodasComoVisualizadas()
    {
        if (!Auth::check()) {
            return redirect()->route('cliente.login');
        }

        $cliente = Auth::user();

        if ($cliente->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        NotificacaoModel::where(
                'cliente_id',
                $cliente->cliente_id
            )
            ->where(
                'visualizada',
                false
            )
            ->update([
                'visualizada' => true
            ]);

        return redirect()
            ->route('cliente.notificacoes')
            ->with(
                'success',
                'Todas as notificações foram marcadas como visualizadas.'
            );
    }

    public function enviarParaCliente(Request $request, $id)
    {
        $dados = $request->validate([
            'titulo' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'conteudo' => [
                'required',
                'string',
                'min:5',
                'max:255'
            ]
        ], [
            'titulo.required' =>
                'Informe o título da notificação.',

            'titulo.min' =>
                'O título deve possuir pelo menos 3 caracteres.',

            'titulo.max' =>
                'O título pode possuir no máximo 255 caracteres.',

            'conteudo.required' =>
                'Digite a mensagem para o cliente.',

            'conteudo.min' =>
                'A mensagem deve possuir pelo menos 5 caracteres.',

            'conteudo.max' =>
                'A mensagem pode possuir no máximo 255 caracteres.'
        ]);

        $cliente = ClienteModel::where(
                'cliente_id',
                $id
            )
            ->where(
                'is_admin',
                false
            )
            ->firstOrFail();

        NotificacaoModel::create([
            'cliente_id' => $cliente->cliente_id,
            'titulo' => $dados['titulo'],
            'conteudo' => $dados['conteudo'],
            'visualizada' => false
        ]);

        return redirect()
            ->route('admin.clientes')
            ->with(
                'success',
                'Notificação enviada para ' .
                $cliente->nome .
                ' com sucesso!'
            );
    }
}