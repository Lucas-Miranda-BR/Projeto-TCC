<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'categoria';
    protected $primaryKey = 'categoria_id';
    protected $fillable = [
        'nome'
    ];

    public function itens(): HasMany {
        return $this->hasMany(ItemModel::class, 'categoria_id', 'categoria_id');
    }
}
