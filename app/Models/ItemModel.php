<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    use HasFactory;
    protected $table = 'item';
    protected $fillable = [
        'item_id', // PK
        'marca_id', // FK
        'categoria_id', // FK
        'item_nome',
        'preco',
        'estoque'
    ];
}
