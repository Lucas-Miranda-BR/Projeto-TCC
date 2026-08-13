<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cliente';
    protected $primaryKey = 'cliente_id';
    protected $fillable = [
        'nome',
        'sobrenome',
        'cpf',
        'cep',
        'telefone',
        'email',
        'endereco',
        'data_nascimento',
        'admin',
        'senha'
    ];
    
    protected $casts = [
        'senha' => 'hashed',
        'admin' => 'boolean',
        'data_nascimento' => 'date'
    ];

    public function estados(): BelongsTo {
        return $this->belongsTo(Estado::class, 'estado_id', 'estado_id');
    }
    public function cidades(): BelongsTo {
        return $this->belongsTo(Cidade::class, 'cidade_id', 'cidade_id');
    }
    public function notificacoes(): HasMany {
        return $this->hasMany(Notificacao::class, 'cliente_id', 'cliente_id');
    }
    public function pedidos(): HasMany {
        return $this->hasMany(Pedido::class, 'cliente_id', 'cliente_id');
    }
    public function prompts_ia(): HasMany {
        return $this->hasMany(Prompt_ia::class, 'cliente_id', 'cliente_id');
    }
}
