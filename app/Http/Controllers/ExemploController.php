<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExemploController extends Controller
{
    function teste(Request $dados){
        $exemplo = new \App\Models\ExemploModel();
        $exemplo::create($dados->all());

        $exemplos = new \App\Models\ExemploModel();
        return view('exemplo.exemplo', ['success'=>'Exemplo criado!', 'exemplos'=>$exemplos::all()]);
    }

    
}

// Utilize "php artisan:make controller" para criar um controller.


