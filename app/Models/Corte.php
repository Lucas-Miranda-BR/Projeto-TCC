<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Corte extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'corte';
    protected $primaryKey = 'corte_id';
    protected $fillable = [
        'nome',
    ];

    public function cortes(): HasMany {
        return $this->hasMany(Prompt_ia::class, 'corte_id', 'corte_id');
    }
}
