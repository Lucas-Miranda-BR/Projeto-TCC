<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PromptIa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'prompt_ia';
    protected $primaryKey = 'prompt_ia_id';
    protected $fillable = [
        'cliente_id', // FK
        'cor_unha_id', // FK
        'cor_cabelo_id', // FK
        'formato_id', // FK
        'extra_id', // FK
        'corte_id', // FK
        'imagem_prompt'
    ];

    public function imagens_geradas(): HasOne {
        return $this->hasOne(ImagemGerada::class, 'prompt_ia_id', 'prompt_ia_id');
    }
    public function clientes(): BelongsTo{
        return $this->belongsTo(Cliente::class, 'cliente_id', 'cliente_id');
    }
    public function cores_unhas(): BelongsTo{
        return $this->belongsTo(CorUnha::class, 'cor_unha_id', 'cor_unha_id');
    }
    public function cores_cabelo(): BelongsTo{
        return $this->belongsTo(CorCabelo::class, 'cor_cabelo_id', 'cor_cabelo_id');
    }
    public function extras(): BelongsTo{
        return $this->belongsTo(Extras::class, 'extras_id', 'extras_id');
    }
    public function formatos(): BelongsTo{
        return $this->belongsTo(Formatos::class, 'formato_id', 'formato_id');
    }
}
