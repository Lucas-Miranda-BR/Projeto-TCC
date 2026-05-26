<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt_iaModel extends Model
{
    use HasFactory;
    protected $table = 'prompt_ia';
    protected $fillable = [
        'prompt_ia_id', // PK
        'cliente_id', // FK
        'caminho_imagem',
        'cor',
        'formato',
        'extra',
        'tipo_corte'
    ];
}
