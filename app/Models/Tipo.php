<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'tipo';

    protected $primaryKey = 'tipo_id';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'colorivel'
    ];

    public function procedimentos(): HasMany
    {
        return $this->hasMany(
            Procedimento::class,
            'tipo_id',
            'tipo_id'
        );
    }
}