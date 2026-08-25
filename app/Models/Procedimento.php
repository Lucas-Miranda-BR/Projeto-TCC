<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Procedimento extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "procedimento";
    protected $primary_key = "procedimento_id";
    protected $fillable = [
        'tipo_id', // FK
        "nome",
        'descricao',
        'preco'
    ];

    public function agendamentos(): HasMany{
        return $this->hasMany(Agendamento::class, 'agendamento_id', 'agendamento_id');
    }
    public function prompts_ia(): HasMany{
        return $this->hasMany(PromptIa::class, 'prompt_ia_id', 'prompt_ia_id');
    }
    public function tipos(): BelongsTo {
        return $this->belongsTo(Tipo::class, 'tipo_id', 'tipo_id');
    }
}
