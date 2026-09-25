<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DescontarItemModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'descontar_item';
    protected $primaryKey = 'descontar_item_id';
    protected $fillable = [
        'desconto_id', // FK
        'item_id', // FK
    ];

    public function itens(): BelongsTo{
        return $this->belongsTo(
            ItemModel::class,
            'item_id',
            'item_id'
        );
    }
    public function descontos(): BelongsTo{
        return $this->belongsTo(
            DescontoModel::class,
            'desconto_id',
            'desconto_id'
        );
    }
}
