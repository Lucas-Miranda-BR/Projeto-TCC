<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoModel extends Model
{
    use HasFactory;
    protected $table = 'servico';
    protected $fillable = [
        'servico_id', // PK
        'imagem_gerada_id', // FK
        'tipo',
        'preco',
        'data_agendada'
    ];
}
