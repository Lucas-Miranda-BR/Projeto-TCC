<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prompt_ia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'prompt_ia';
    protected $primaryKey = 'prompt_ia_id';
    protected $fillable = [
        'cliente_id', // FK
        'imagem_prompt',
        'cor',
        'formato',
        'extra',
        'tipo_corte'
    ];

    public function imagens_geradas(): HasOne {
        return $this->hasOne(Imagem_gerada::class, 'prompt_ia_id', 'prompt_ia_id');
    }
    public function cliente(): BelongsTo{
        return $this->belongsTo(Cliente::class, 'cliente_id', 'cliente_id');
    }
}
