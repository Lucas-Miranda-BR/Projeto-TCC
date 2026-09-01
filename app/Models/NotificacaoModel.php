<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificacaoModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'notificacao';
    protected $primaryKey = 'notificacao_id';
    protected $fillable = [
        'cliente_id', // FK
        'titulo',
        'conteudo',
        'data_recebida',
        'visualizada'
    ];

    protected $casts = [
        'data_recebida' => 'datetime',
        'visualizada' => 'boolean'
    ];

    public function clientes(): BelongsTo{
        return $this->belongsTo(ClienteModel::class, 'cliente_id', 'cliente_id');
    }
}
