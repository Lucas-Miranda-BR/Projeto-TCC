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

    protected $table = 'procedimento';

    protected $primaryKey = 'procedimento_id';

    protected $fillable = [
        'tipo_id',
        'nome',
        'descricao',
        'preco'
    ];

    public function agendamentos(): HasMany
    {
        return $this->hasMany(
            Agendamento::class,
            'procedimento_id',
            'procedimento_id'
        );
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(
            Tipo::class,
            'tipo_id',
            'tipo_id'
        );
    }
}