<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ItemModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'item';

    protected $primaryKey = 'item_id';

    protected $fillable = [
        'categoria_id', // FK
        'marca_id', // FK
        'nome',
        'preco',
        'foto',
        'estoque'
    ];

    public function descontos(): BelongsToMany
    {
        return $this->belongsToMany(
            DescontoModel::class,
            'descontar_item',
            'item_id',
            'desconto_id'
        );
    }

    public function categorias(): BelongsTo{
        return $this->belongsTo(
            CategoriaModel::class,
            'categoria_id',
            'categoria_id'
        );
    }

    public function marcas(): BelongsTo{
        return $this->belongsTo(
            MarcaModel::class,
            'marca_id',
            'marca_id'
        );
    }

    public function getDescontoAtivoAttribute()
    {
        $hoje = Carbon::today()->format('Y-m-d');
        
        $descontosValidos = $this->descontos->filter(function ($desc) use ($hoje) {
            if ($desc->quando_terminar === null) {
                return true;
            }
            return Carbon::parse($desc->quando_terminar)->format('Y-m-d') >= $hoje;
        });

        return $descontosValidos->sortByDesc('valor')->first();
    }

    public function getPrecoFinalAttribute()
    {
        $desconto = $this->desconto_ativo;
        
        if ($desconto) {
            $valorDesconto = ($this->preco * $desconto->valor) / 100;
            return $this->preco - $valorDesconto;
        }
        
        return $this->preco;
    }
}