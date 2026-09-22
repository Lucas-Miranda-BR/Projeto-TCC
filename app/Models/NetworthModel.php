<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworthModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'networth';
    protected $primaryKey = 'networth_id';
    protected $fillable = [
        'ganho',
        'custo',
        'networth',
        'dia',
        'hora'
    ];
}
