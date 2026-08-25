<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Procedimento extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "procedimento";
    protected $primary_key = "procedimento_id";
    protected $filable = [
        'imagem_gerada_id', // FK
        "titulo",
        'descricao',
        'preco'
    ];

    public function agendamentos(): HasMany{
        return $this->hasMany(Agendamento::class, 'agendamento_id', 'agendamento_id');
    }

    public function imagens_geradas(): BelongsTo{
        return $this->belongsTo(ImagemGerada::class, 'imagem_gerada_id', 'imagem_gerada_id');
    }
}
