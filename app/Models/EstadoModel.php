<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoModel extends Model
{
    use HasFactory;
    protected $table = 'estado';
    protected $fillable = [
        'estado_id', // PK
        'nome'
    ];

    public function cliente(): HasMany {
        return $this->hasMany(ClienteModel::class, 'estado_id', 'estado_id');
    }
}
