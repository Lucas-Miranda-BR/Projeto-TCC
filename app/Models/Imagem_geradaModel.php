<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem_geradaModel extends Model
{
    use HasFactory;
    protected $table = 'imagem_gerada';
    protected $fillable = [
        'imagem_gerada_id', // PK
        'prompt_ia_id', // FK
        'caminho_imagem_gerada'
    ];
}
