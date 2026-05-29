<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClienteModel extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $fillable = [
        'cliente_id', // PK
        'estado_id', // FK
        'cidade_id', // FK
        'nome',
        'sobrenome',
        'cpf',
        'telefone',
        'email',
        'endereco',
        'data_nascimento'
    ];

    public function estado(): BelongsTo {
        return $this->belongsTo(EstadoModel::class, 'estado_id', 'estado_id');
    }
    public function cidade(): BelongsTo {
        return $this->belongsTo(CidadeModel::class, 'cidade_id', 'cidade_id');
    }
    public function notificacao(): HasMany {
        return $this->hasMany(NotificacaoModel::class, 'cliente_id', 'cliente_id');
    }
    public function pedido(): HasMany {
        return $this->hasMany(PedidoModel::class, 'cliente_id', 'cliente_id');
    }
    public function prompt_ia(): HasMany {
        return $this->hasMany(Prompt_iaModel::class, 'cliente_id', 'cliente_id');
    }
}
