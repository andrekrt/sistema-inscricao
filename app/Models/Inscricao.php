<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricoes';

    protected $fillable = [
        'dojo_nome',
        'sensei_nome',
        'telefone',
        'email',
        'comprovante',
        'status',
        'total_atletas',
        'observacoes',
    ];

    public function atletas()
    {
        return $this->hasMany(Atleta::class);
    }
}
