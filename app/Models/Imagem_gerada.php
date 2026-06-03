<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Imagem_gerada extends Model
{
    use HasFactory;
    protected $table = 'imagem_gerada';
    protected $primaryKey = 'imagem_gerada_id';
    protected $fillable = [
        'prompt_ia_id', // FK
        'caminho_imagem_gerada'
    ];

    public function prompts_ia(): BelongsTo{
        return $this->belongsTo(Prompt_ia::class, 'prompt_ia_id', 'prompt_ia_id');
    }

    public function servicos(): HasOne {
        return $this->hasOne(Servico::class, 'imagem_gerada_id', 'imagem_gerada_id');
    }
}
