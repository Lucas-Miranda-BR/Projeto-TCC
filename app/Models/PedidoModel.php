<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PedidoModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'pedido';

    protected $primaryKey = 'pedido_id';

    protected $fillable = [
        'cliente_id',
        'valor_total',
        'valor_desconto',
        'pedido_data',
        'status'
    ];

    protected $casts = [
        'pedido_data' => 'datetime'
    ];

    public function clientes(): BelongsTo
    {
        return $this->belongsTo(
            ClienteModel::class,
            'cliente_id',
            'cliente_id'
        );
    }

    public function carrinhos_itens(): HasMany
    {
        return $this->hasMany(
            CarrinhoItemModel::class,
            'pedido_id',
            'pedido_id'
        );
    }
}