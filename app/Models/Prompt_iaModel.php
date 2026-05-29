<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prompt_iaModel extends Model
{
    use HasFactory;
    protected $table = 'prompt_ia';
    protected $fillable = [
        'prompt_ia_id', // PK
        'cliente_id', // FK
        'imagem_prompt',
        'cor',
        'formato',
        'extra',
        'tipo_corte'
    ];

    public function imagem_gerada(): HasOne {
        return $this->hasOne(Imagem_geradaModel::class, 'prompt_ia_id', 'prompt_ia_id');
    }
    public function cliente(): BelongsTo{
        return $this->belongsTo(ClienteModel::class, 'cliente_id', 'cliente_id');
    }
}
