<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateNotificacaoModel;
use Illuminate\Support\Facades\Validator;

class TemplateNotificacaoController extends Controller
{
    public function index()
    {
        $templates = TemplateNotificacaoModel::all();
        
        return view('admin.templates.index', compact('templates'));
    }

    public function edit($id)
    {
        $template = TemplateNotificacaoModel::findOrFail($id);
        
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.templates.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $template = TemplateNotificacaoModel::findOrFail($id);
        
        $template->update([
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo
        ]);

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template atualizado com sucesso!');
    }
}