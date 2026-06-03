<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cidade extends Model
{
    use HasFactory;
    protected $table = 'cidade';
    protected $primaryKey = 'cidade_id';
    protected $fillable = [
        'nome'
    ];

    public function clientes(): HasMany {
        return $this->hasMany(Cliente::class, 'cidade_id', 'cidade_id');
    }
}
