<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgendamentoModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'agendamento';
    protected $primaryKey = 'agendamento_id';
    protected $fillable = [
        'cliente_id', // FK
        'procedimento_id', // FK
        'imagem_gerada_id', // FK
        'hora',
        'data'
    ];

    protected $casts = [
        'data' => 'date'
    ];

    public function servicos(): HasMany {
        return $this->hasMany(ServicoModel::class, 'agendamento_id', 'agendamento_id');
    }

    public function procedimentos(): BelongsTo {
        return $this->belongsTo(ProcedimentoModel::class, 'procedimento_id', 'procedimento_id');
    }

    public function clientes(): BelongsTo {
        return $this->belongsTo(ClienteModel::class, 'cliente_id', 'cliente_id');
    }

    public function imagens_geradas(): BelongsTo {
        return $this->belongsTo(ImagemGeradaModel::class, 'imagem_gerada_id', 'imagem_gerada_id');
    }

}
