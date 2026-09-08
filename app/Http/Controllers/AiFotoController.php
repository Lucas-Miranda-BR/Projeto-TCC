<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PromptIaModel;
use Illuminate\Validation\ValidationException;


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

        $validated = $validator->validated();

        $caminhoImagem = $request->file('imagem_prompt')->store('prompts', 'public');

        $validated['imagem_prompt'] = $caminhoImagem;

        $imagemGerada = PromptIaModel::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Salvo com sucesso!',
            'data' => $imagemGerada,
            'imagem_gerada_id' => $imagemGerada->prompt_ia_id,
            'redirect_url' => route('agendamento.agendar', ['imagem_gerada_id' => $imagemGerada->prompt_ia_id])
        ], 201);
    }
}
