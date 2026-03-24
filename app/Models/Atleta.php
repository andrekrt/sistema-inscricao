<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atleta extends Model
{
    protected $table = 'atletas';

    protected $fillable = [
        'inscricao_id',
        'categoria_id',
        'nome_completo',
        'data_nascimento',
        'sexo',
        'faixa',
    ];

    public function inscricao()
    {
        return $this->belongsTo(Inscricao::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
