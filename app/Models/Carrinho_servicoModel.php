<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho_servicoModel extends Model
{
    use HasFactory;
    protected $table = 'carrinho_servico';
    protected $fillable = [
        'pedido_id', // PK
        'cliente_id', // PK
        'subtotal',
        'quantidade'
    ];
}
