<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PromptIaModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'prompt_ia';
    protected $primaryKey = 'prompt_ia_id';
    protected $fillable = [
        'cliente_id', // FK
        'cor_id', // FK
        'procedimento_id', // FK
        'imagem_prompt'
    ];

    public function imagens_geradas(): HasOne {
        return $this->hasOne(ImagemGeradaModel::class, 'prompt_ia_id', 'prompt_ia_id');
    }

    public function clientes(): BelongsTo{
        return $this->belongsTo(ClienteModel::class, 'cliente_id', 'cliente_id');
    }

    public function cores(): BelongsTo{
        return $this->belongsTo(CorModel::class, 'cor_id', 'cor_id');
    }

    public function procedimentos(): BelongsTo{
        return $this->belongsTo(ProcedimentoModel::class, 'procedimento_id', 'procedimento_id');
    }
}