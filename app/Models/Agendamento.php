<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'agendamento';

    protected $primaryKey = 'agendamento_id';

    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'procedimento_id',
        'imagem_gerada_id',
        'hora',
        'data'
    ];

    protected $casts = [
        'data' => 'date'
    ];

    public function procedimento(): BelongsTo
    {
        return $this->belongsTo(
            Procedimento::class,
            'procedimento_id',
            'procedimento_id'
        );
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(
            Cliente::class,
            'cliente_id',
            'cliente_id'
        );
    }

    public function imagemGerada(): BelongsTo
    {
        return $this->belongsTo(
            ImagemGerada::class,
            'imagem_gerada_id',
            'imagem_gerada_id'
        );
    }
}