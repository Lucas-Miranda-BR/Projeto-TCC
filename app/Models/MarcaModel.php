<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarcaModel extends Model
{
    use HasFactory;
    protected $table = 'marca';
    protected $fillable = [
        'marca_id', // PK
        'nome'
    ];

    public function item(): HasMany {
        return $this->hasMany(ItemModel::class, 'marca_id', 'marca_id');
    }
}
