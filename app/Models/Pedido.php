<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pedido';
    protected $primaryKey = 'pedido_id';
    protected $fillable = [
        'cliente_id', // FK
        'valor_total'
    ];

    protected $casts = [
        'pedido_data' => 'datetime'
    ];

    public function clientes(): BelongsTo{
        return $this->belongsTo(Cliente::class, 'cliente_id', 'cliente_id');
    }

    public function carrinhos_itens(): HasMany{
        return $this->hasMany(CarrinhoItem::class, 'carrinho_item_id', 'carrinho_item_id');
    }

    public function carrinhos_servicos(): HasMany{
        return $this->hasMany(CarrinhoServico::class, 'carrinho_sevico_id', 'carrinho_sevico_id');
    }
}
