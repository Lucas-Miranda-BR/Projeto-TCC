<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tipo';
    protected $primaryKey = 'tipo_id';
    protected $fillable = [
        'nome',
        'colorivel'
    ];

    public function procedimentos(): HasMany {
        return $this->hasMany(ProcedimentoModel::class, 'tipo_id', 'tipo_id');
    }
}
