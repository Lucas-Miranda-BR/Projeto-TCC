<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Procedimento;
use App\Models\PromptIa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgendamentoController extends Controller
{
    public function createAgendamento(Request $request)
    {
        $clienteSession = session('cliente');

        if (!$clienteSession) {

            return redirect()
                ->route('cliente.cadastro')
                ->withErrors([
                    'Por favor, faça seu cadastro ou entre em sua conta para realizar um agendamento.'
                ]);
        }

        $cliente = Cliente::find(
            $clienteSession->cliente_id
        );

        if (!$cliente) {

            session()->forget('cliente');

            return redirect()
                ->route('cliente.login')
                ->withErrors([
                    'Não foi possível localizar sua conta. Faça login novamente.'
                ]);
        }

        $imagemGeradaId = $request->query(
            'imagem_gerada_id'
        );

        $procedimentoSelecionado = null;

        if ($imagemGeradaId) {

            $promptIa = PromptIa::find(
                $imagemGeradaId
            );

            if ($promptIa) {
                $procedimentoSelecionado =
                    $promptIa->procedimento_id;
            }
        }

        $procedimentos = Procedimento::with('tipo')
            ->orderBy('nome')
            ->get();

        $agendamentos = Agendamento::with('procedimento')
            ->where(
                'cliente_id',
                $cliente->cliente_id
            )
            ->orderBy('data')
            ->orderBy('hora')
            ->get();

        return view(
            'agendamento.agendar',
            compact(
                'procedimentos',
                'cliente',
                'agendamentos',
                'imagemGeradaId',
                'procedimentoSelecionado'
            )
        );
    }

    public function storeAgendamento(Request $request)
    {
        $clienteSession = session('cliente');

        if (!$clienteSession) {

            return redirect()
                ->route('cliente.login')
                ->withErrors([
                    'Faça login para realizar um agendamento.'
                ]);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'procedimento_id' => [
                    'required',
                    'integer',
                    'exists:procedimento,procedimento_id'
                ],

                'data' => [
                    'required',
                    'date',
                    'after_or_equal:today'
                ],

                'hora' => [
                    'required',
                    'date_format:H:i'
                ],

                'imagem_gerada_id' => [
                    'nullable',
                    'integer'
                ]
            ]
        );

        if ($validator->fails()) {

            return redirect()
                ->route('agendamento.agendar')
                ->withErrors($validator)
                ->withInput();
        }

        $dados = $validator->validated();

        $dados['cliente_id'] =
            $clienteSession->cliente_id;

        $horarioOcupado = Agendamento::where(
                'data',
                $dados['data']
            )
            ->where(
                'hora',
                $dados['hora']
            )
            ->exists();

        if ($horarioOcupado) {

            return redirect()
                ->route('agendamento.agendar')
                ->withErrors([
                    'Esse horário já está ocupado. Escolha outro horário.'
                ])
                ->withInput();
        }

        Agendamento::create($dados);

        return redirect()
            ->route('agendamento.agendar')
            ->with(
                'success',
                'Agendamento realizado com sucesso!'
            );
    }
}