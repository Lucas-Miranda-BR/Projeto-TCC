<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaModel extends Model
{
    use HasFactory;
    protected $tabçe = 'categoria';
    protected $fillable = [
        'categoria_id', // PK
        'nome'
    ];
}
