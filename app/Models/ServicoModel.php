<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServicoModel extends Model
{
    use HasFactory;
    protected $table = 'servico';
    protected $fillable = [
        'servico_id', // PK
        'imagem_gerada_id', // FK
        'tipo',
        'preco',
        'data_agendada'
    ];

    public function imagem_gerada(): BelongsTo{
        return $this->belongsTo(imagem_geradaModel::class, 'imagem_gerada_id', 'imagem_gerada_id');
    }
    public function carrinho_servico(): HasMany {
        return $this->hasMany(Carrinho_servicoModel::class, 'servico_id', 'servico_id');
    }
}
