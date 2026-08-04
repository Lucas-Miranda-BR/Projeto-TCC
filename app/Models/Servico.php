<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servico extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'servico';
    protected $primaryKey = 'servico_id';
    protected $fillable = [
        'imagem_gerada_id', // FK
        'tipo_id', // FK
        'preco',
        'data_agendada'
    ];

    protected $casts = [
        'data_agendada' => 'date'
    ];

    public function imagens_geradas(): BelongsTo{
        return $this->belongsTo(Imagem_gerada::class, 'imagem_gerada_id', 'imagem_gerada_id');
    }
    public function carrinhos_servicos(): HasMany {
        return $this->hasMany(Carrinho_servico::class, 'servico_id', 'servico_id');
    }

    public function tipos(): HasMany {
        return $this->hasMany(Tipo::class, 'tipo_id', 'tipo_id');
    }
}
