<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarrinhoServico extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'carrinho_servico';
    protected $primaryKey = 'carrinho_servico_id';
    protected $fillable = [
        'pedido_id', // FK
        'servico_id', // FK
        'subtotal',
        'quantidade'
    ];

    public function pedidos(): BelongsTo{
        return $this->belongsTo(Pedido::class, 'pedido_id', 'pedido_id');
    }
    public function servicos(): BelongsTo{
        return $this->belongsTo(Servico::class, 'servico_id', 'servico_id');
    }
}
