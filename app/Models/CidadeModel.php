<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CidadeModel extends Model
{
    use HasFactory;
    protected $table = 'cidade';
    protected $fillable = [
        'cidade_id', // PK
        'nome'
    ];

    public function cliente(): HasMany {
        return $this->hasMany(ClienteModel::class, 'cidade_id', 'cidade_id');
    }
}
