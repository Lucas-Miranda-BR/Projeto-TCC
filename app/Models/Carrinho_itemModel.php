<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho_itemModel extends Model
{
    use HasFactory;
    protected $table = 'carrinho_item';
    protected $fillable = [
        'pedido_id', // PK
        'item_id', // PK
        'quantidade',
        'subtotal'
    ];
}
