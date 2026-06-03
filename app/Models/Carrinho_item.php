<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrinho_item extends Model
{
    use HasFactory;
    protected $table = 'carrinho_item';
    protected $primaryKey = 'carrinho_item_id';
    protected $fillable = [
        'pedido_id', // FK
        'item_id', // FK
        'subtotal',
        'quantidade'
    ];

    public function itens(): BelongsTo{
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
    public function pedidos(): BelongsTo{
        return $this->belongsTo(Pedido::class, 'pedido_id', 'pedido_id');
    }
}
