<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrinho_itemModel extends Model
{
    use HasFactory;
    protected $table = 'carrinho_item';
    protected $fillable = [
        'pedido_id', // PK & FK
        'item_id', // PK & FK
        'subtotal',
        'quantidade'
    ];

    public function item(): BelongsTo{
        return $this->belongsTo(ItemModel::class, 'item_id', 'item_id');
    }
    public function pedido(): belongsTo{
        return $this->belongsTo(PedidoModel::class, 'pedido_id', 'pedido_id');
    }
}
