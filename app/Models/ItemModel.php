<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemModel extends Model
{
    use HasFactory;
    protected $table = 'item';
    protected $fillable = [
        'item_id', // PK
        'marca_id', // FK
        'categoria_id', // FK
        'nome',
        'preco',
        'estoque'
    ];

    public function marca(): BelongsTo{
        return $this->belongsTo(MarcaModel::class, 'marca_id', 'marca_id');
    }
    public function categoria(): BelongsTo{
        return $this->belongsTo(CategoriaModel::class, 'categoria_id', 'categoria_id');
    }
    public function carrinho_item(): HasMany {
        return $this->hasMany(Carrinho_itemModel::class, 'item_id', 'item_id');
    }
}
