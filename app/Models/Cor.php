<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cor';
    protected $primaryKey = 'cor_id';
    protected $fillable = [
        'nome',
        'disponivel'
    ];

    public function prompts_ia(): HasMany {
        return $this->hasMany(Prompt_ia::class, 'cor_id', 'cor_id');
    }
}
