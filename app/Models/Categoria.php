<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'tipo',
        'nome',
        'idade_min',
        'idade_max',
        'sexo',
        'faixa_inicial',
        'faixa_final',
        'especial',
        'ativo',
    ];

    public function atletas(){
        return $this->hasMany(Atleta::class);

    }
}
