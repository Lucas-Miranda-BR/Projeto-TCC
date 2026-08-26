<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PromptIa;
use Illuminate\Validation\ValidationException;


class AiFotoController extends Controller
{
    public function storePrompt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => ['required'],

            'procedimento_id' => ['required'],
            
            'imagem_prompt'   => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120']

            ]);
        
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $validated = $validator->validated();

    $caminhoImagem = $request->file('imagem_prompt')->store('prompts', 'public');

    $validated['imagem_prompt'] = $caminhoImagem;

    $imagem_prompt = PromptIa::create($validated);

    }
}
