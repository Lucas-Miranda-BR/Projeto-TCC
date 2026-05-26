<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $fillable = [
        'cliente_id', // PK
        'estado_id', // FK
        'cidade_id', // FK
        'cliente_nome',
        'sobrenome',
        'cpf',
        'telefone',
        'email',
        'endereco',
        'data_nascimento'
    ];
}
