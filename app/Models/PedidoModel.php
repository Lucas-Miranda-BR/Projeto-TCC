<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoModel extends Model
{
    use HasFactory;
    protected $table = 'pedido';
    protected $fillable = [
        'pedido_id', // PK
        'cliente_id', // FK
        'valor_total',
        'pedido_data',
        'forma_pagamento'
    ];
}
