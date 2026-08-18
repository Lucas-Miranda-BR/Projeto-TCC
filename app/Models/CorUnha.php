<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CorUnha extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cor_unha';
    protected $primaryKey = 'cor_unha_id';
    protected $fillable = [
        'nome',
        'disponivel'
    ];

    public function cores(): HasMany {
        return $this->hasMany(Prompt_ia::class, 'cor_unha_id', 'cor_unha_id');
    }
}
