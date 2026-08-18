<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Extra extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'extra';
    protected $primaryKey = 'extra_id';
    protected $fillable = [
        'nome',
        'disponivel'
    ];

    public function prompts_ia(): HasMany {
        return $this->hasMany(Prompt_ia::class, 'extra_id', 'extra_id');
    }
}
