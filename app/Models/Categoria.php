<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'tipo',
        'tipo_disputa',
        'nome',
        'idade_min',
        'idade_max',
        'sexo',
        'faixa_inicial',
        'faixa_final',
        'especial',
        'min_atletas_equipe',
        'max_atletas_equipe',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'min_atletas_equipe' => 'integer',
        'max_atletas_equipe' => 'integer',
    ];

    public function atletas()
    {
        return $this->hasMany(Atleta::class);
    }

    public function isEquipe(): bool
    {
        return $this->tipo_disputa === 'equipe';
    }

    public function isIndividual(): bool
    {
        return $this->tipo_disputa === 'individual';
    }

    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }
}
