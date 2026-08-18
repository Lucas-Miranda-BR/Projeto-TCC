<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tipo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tipo';
    protected $primaryKey = 'tipo_id';
    protected $fillable = [
        'nome'
    ];

    public function tipos(): HasMany {
        return $this->hasMany(Servico::class, 'tipo_id', 'tipo_id');
    }
}
