<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formato extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'formato';
    protected $primaryKey = 'formato_id';
    protected $fillable = [
        'nome',
    ];

    public function prompts_ia(): HasMany {
        return $this->hasMany(Prompt_ia::class, 'formato_id', 'formato_id');
    }
}
