<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaModel extends Model
{
    use HasFactory;
    protected $table = 'categoria';
    protected $fillable = [
        'categoria_id', // PK
        'nome'
    ];

    public function item(): HasMany {
        return $this->hasMany(ItemModel::class, 'categoria_id', 'categoria_id');
    }
}
