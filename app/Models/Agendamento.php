<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agendamento extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'agendamento';
    protected $primaryKey = 'agendamento_id';
    protected $fillable = [
        'cliente_id', // FK
        'hora',
        'data'
    ];

    protected $casts = [
        'data' => 'date'
    ];

    public function servicos(): HasMany {
        return $this->hasMany(Servico::class, 'agendamento_id', 'agendamento_id');
    }

    public function clientes(): BelongsTo {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'cliente_id');
    }

}
