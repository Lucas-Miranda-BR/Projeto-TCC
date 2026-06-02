<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedido';
    protected $primaryKey = 'pedido_id';
    protected $fillable = [
        'cliente_id', // FK
        'valor_total',
        'pedido_data',
        'forma_pagamento'
    ];

    protected $casts = [
        'pedido_data' => 'datetime'
    ];

    public function clientes(): BelongsTo{
        return $this->belongsTo(Cliente::class, 'cliente_id', 'cliente_id');
    }
}
