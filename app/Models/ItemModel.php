<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    protected $fillable = [
        'marca_id', // FK
        'categoria_id', // FK
        'nome',
        'preco',
        'foto',
        'estoque'
    ];

    public function marcas(): BelongsTo{
        return $this->belongsTo(MarcaModel::class, 'marca_id', 'marca_id');
    }
    public function categorias(): BelongsTo{
        return $this->belongsTo(CategoriaModel::class, 'categoria_id', 'categoria_id');
    }
    public function carrinhos_itens(): HasMany {
        return $this->hasMany(CarrinhoItemModel::class, 'item_id', 'item_id');
    }
}
