<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\PromptIaModel;
use App\Models\ImagemGeradaModel;

class AiFotoController extends Controller
{
    public function storePrompt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => [
                'required'
            ],
            'procedimento_id' => [
                'required'
            ],
            'cor_id' => [
                'nullable'
            ],
            'imagem_prompt' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg',
                'max:5120'
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated =$validator->validated();

        $caminhoTemp =$request->file('imagem_prompt')->store('prompts_temp', 'local');

        try {
            $prompt = PromptIaModel::create([
                'cliente_id' => $validated['cliente_id'],
                'procedimento_id' => $validated['procedimento_id'],
                'cor_id' => $validated['cor_id'] ?? null,
                'imagem_prompt' => $caminhoTemp,
            ]);

            $extensao =$request->file('imagem_prompt')->getClientOriginalExtension() ?: 'jpg';
            $nomeArquivo = Str::uuid() . '.' .$extensao;
            $caminhoRelativoPublico = 'images/imagens_geradas/' .$nomeArquivo;

            $pastaDestino = public_path('images/imagens_geradas');
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0755, true);
            }

            $conteudoTemp = Storage::disk('local')->get($caminhoTemp);
            file_put_contents($pastaDestino . DIRECTORY_SEPARATOR . $nomeArquivo,$conteudoTemp);

            $imagemGerada = ImagemGeradaModel::create([
                'prompt_ia_id' => $prompt->prompt_ia_id,
                'caminho_imagem_gerada' => $caminhoRelativoPublico,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Simulação salva com sucesso!',
                'data' => $imagemGerada,
                'imagem_gerada_id' => $imagemGerada->imagem_gerada_id,
                'imagem_gerada_url' => asset($imagemGerada->caminho_imagem_gerada),
                'redirect_url' => route('agendamento.agendar', ['imagem_gerada_id' => $imagemGerada->imagem_gerada_id])
            ], 201);
        } finally {
            if ($caminhoTemp && Storage::disk('local')->exists($caminhoTemp)) {
                Storage::disk('local')->delete($caminhoTemp);
            }
        }
    }
}