<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscricaoComprovante extends Model
{
    protected $table = 'inscricao_comprovantes';

    protected $fillable = [
        'inscricao_id',
        'arquivo',
        'nome_original',
    ];

    public function inscricao()
    {
        return $this->belongsTo(Inscricao::class);
    }
}
