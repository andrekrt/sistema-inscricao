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
        'token_edicao',
        'edicao_liberada',
        'edicao_ate',
        'status',
        'total_atletas',
        'observacoes',
    ];

    protected $casts = [
        'edicao_liberada' => 'boolean',
        'edicao_ate' => 'datetime',
    ];

    public function atletas()
    {
        return $this->hasMany(Atleta::class);
    }

    public function comprovantes()
    {
        return $this->hasMany(InscricaoComprovante::class);
    }

    public function getLinkEdicaoAttribute(): string
    {
        return route('inscricao.edit.token', [
            'id' => $this->id,
            'token' => $this->token_edicao,
        ]);
    }
}
