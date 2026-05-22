<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExemploController extends Model
{
    use HasFactory;

    protected $table = 'exemplos';
    protected $fillable = ['exemplo'];
}

// Utilize "php artisan make:model" para criar um model