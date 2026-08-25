<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Servico extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'servico';
    protected $primaryKey = 'servico_id';
    protected $fillable = [
        'agendamento_id', // FK
        'total'
        ];

    protected $casts = [
        'data_agendada' => 'date'
    ];

    public function imagens_geradas(): BelongsTo{
        return $this->belongsTo(ImagemGerada::class, 'imagem_gerada_id', 'imagem_gerada_id');
    }

    public function agendamentos(): BelongsTo{
        return $this->belongsTo(Agendamento::class, 'agendamento_id', 'agendamento_id');
    }
}
