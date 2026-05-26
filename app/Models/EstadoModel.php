<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoModel extends Model
{
    use HasFactory;
    protected $table = 'estado';
    protected $fillable = [
        'estado_id', // PK
        'estado_nome'
    ];
}
