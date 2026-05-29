<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrinho_servicoModel extends Model
{
    use HasFactory;
    protected $table = 'carrinho_servico';
    protected $fillable = [
        'pedido_id', // PK & FK
        'servico_id', // PK & FK
        'subtotal',
        'quantidade'
    ];

    public function pedido(): BelongsTo{
        return $this->belongsTo(PedidoModel::class, 'pedido_id', 'pedido_id');
    }
    public function servico(): BelongsTo{
        return $this->belongsTo(ServicoModel::class, 'servico_id', 'servico_id');
    }
}
