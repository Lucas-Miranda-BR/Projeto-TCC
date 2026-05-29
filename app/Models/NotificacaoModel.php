<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificacaoModel extends Model
{
    use HasFactory;
    protected $table = 'notificacao';
    protected $fillable = [
        'notificacao_id', // PK
        'cliente_id', // FK
        'titulo',
        'conteudo',
        'data_recebida',
        'visualizada'
    ];

    public function cliente(): BelongsTo{
        return $this->belongsTo(ClienteModel::class, 'cliente_id', 'cliente_id');
    }
}
