<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Marca extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'marca';
    protected $primaryKey = 'marca_id';
    protected $fillable = [
        'nome'
    ];

    public function itens(): HasMany {
        return $this->hasMany(Item::class, 'marca_id', 'marca_id');
    }
}
