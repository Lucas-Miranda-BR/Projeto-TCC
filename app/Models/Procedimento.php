<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Procedimento extends Model
{
    use HasFactory;

    protected $table = 'procedimento';

    protected $primaryKey = 'procedimento_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_id',
        'nome',
        'imagem',
        'descricao',
        'preco'
    ];

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(
            Tipo::class,
            'tipo_id',
            'tipo_id'
        );
    }

    public function agendamentos(): HasMany
    {
        return $this->hasMany(
            Agendamento::class,
            'procedimento_id',
            'procedimento_id'
        );
    }

    public function prompts_ia(): HasMany
    {
        return $this->hasMany(
            PromptIa::class,
            'procedimento_id',
            'procedimento_id'
        );
    }
}