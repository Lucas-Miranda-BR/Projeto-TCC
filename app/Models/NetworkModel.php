<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'network';
    protected $primaryKey = 'network_id';
    protected $fillable = [
        'ganho',
        'custo',
        'network',
        'dia'
    ];
}
