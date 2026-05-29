<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Imagem_geradaModel extends Model
{
    use HasFactory;
    protected $table = 'imagem_gerada';
    protected $fillable = [
        'imagem_gerada_id', // PK
        'prompt_ia_id', // FK
        'caminho_imagem_gerada'
    ];

    public function prompt_ia(): BelongsTo{
        return $this->belongsTo(Prompt_iaModel::class, 'prompt_ia_id', 'prompt_ia_id');
    }

    public function servico(): HasOne {
        return $this->hasOne(ServicoModel::class, 'imagem_gerada_id', 'imagem_gerada_id');
    }
}
