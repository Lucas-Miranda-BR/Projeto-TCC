<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacaoModel extends Model
{
    use HasFactory;
    protected $table = 'notificacao';
    protected $fillable = [
        'notificacao_id',
        'cliente_id',
        'nome_notificacao',
        'conteudo',
        'data_recebida',
        'visualizada'
    ];
}
