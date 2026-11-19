<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class VerificarPaginaIaAtiva
{
    public static function caminhoArquivoConfig(): string
    {
        return storage_path('app/status_pagina_ia.json');
    }

    public static function estaAtiva(): bool
    {
        $caminho = self::caminhoArquivoConfig();

        if (!File::exists($caminho)) {
            return true;
        }

        $dados = json_decode(File::get($caminho), true);
        return (bool) ($dados['ativa'] ?? true);
    }

    public function handle(Request $request, Closure $next): Response
    {
        $ativa = self::estaAtiva();

        $usuario = Auth::user();
        $isAdmin = $usuario && (
            (isset($usuario->tipo) && $usuario->tipo === 'admin') ||
            (isset($usuario->is_admin) && (bool) $usuario->is_admin) ||
            (isset($usuario->role) && $usuario->role === 'admin')
        );

        if (!$ativa && !$isAdmin) {
            return redirect()
                ->route('home')
                ->with('erro', 'O Provador de Estilo (IA) está temporariamente indisponível.');
        }

        return $next($request);
    }
}