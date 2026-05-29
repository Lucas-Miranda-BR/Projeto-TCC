<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function cliente(): BelongsTo{
        return $this->belongsTo(ClienteModel::class, 'cliente_id', 'cliente_id');
    }
}
