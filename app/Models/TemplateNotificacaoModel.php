<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TemplateNotificacaoModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'template_notificacao';

    protected $primaryKey = 'template_notificacao_id';

    protected $fillable = [
        'titulo',
        'conteudo',
        'tipo'
    ];

    public function notificacoes(): BelongsTo
    {
        return $this->hasMany(
            NotificacoModel::class,
            'notificacao_id',
            'notificacao_id'
        );
    }
}