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
        'hora',
        'data'
    ];

    protected $casts = [
        'hora' => 'time',
        'data' => 'date'
    ];

    public function servicos(): HasMany {
        return $this->hasMany(Servico::class, 'agendamento_id', 'agendamento_id');
    }

}
