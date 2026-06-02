<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    use HasFactory;
    protected $table = 'estado';
    protected $primaryKey = 'estado_id';
    protected $fillable = [
        'nome'
    ];

    public function clientes(): HasMany {
        return $this->hasMany(Cliente::class, 'estado_id', 'estado_id');
    }
}
