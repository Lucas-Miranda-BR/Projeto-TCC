<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ClienteModel extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cliente';
    protected $primaryKey = 'cliente_id';
    protected $fillable = [
        'nome',
        'sobrenome',
        'cpf',
        'telefone',
        'email',
        'data_nascimento',
        'foto',
        'is_admin',
        'senha'
    ];
    
    protected $casts = [
        'senha' => 'hashed',
        'is_admin' => 'boolean',
        'data_nascimento' => 'date'
    ];

    protected $hidden = [
        'senha'
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function notificacoes(): HasMany {
        return $this->hasMany(NotificacaoModel::class, 'cliente_id', 'cliente_id');
    }
    public function pedidos(): HasMany {
        return $this->hasMany(PedidoModel::class, 'cliente_id', 'cliente_id');
    }
    public function prompts_ia(): HasMany {
        return $this->hasMany(PromptIaModel::class, 'cliente_id', 'cliente_id');
    }
    public function agendamentos(): HasMany {
        return $this->hasMany(AgendamentoModel::class, 'cliente_id', 'cliente_id');
    }
}
