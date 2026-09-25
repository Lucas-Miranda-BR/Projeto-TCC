<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DescontoModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'desconto';

    protected $primaryKey = 'desconto_id';

    protected $fillable = [
        'nome',
        'valor',
        'quando_terminar'
    ];

    public function descontar_itens(): HasMany
    {
        return $this->hasMany(
            DescontarItemModel::class,
            'desconto_id',
            'desconto_id'
        );
    }
}