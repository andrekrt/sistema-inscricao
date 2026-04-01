<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    protected $table = 'equipes';

    protected $fillable = [
        'inscricao_id',
        'categoria_id',
        'nomes_atletas',
        'quantidade_atletas',
    ];

    protected $casts = [
        'quantidade_atletas' => 'integer',
    ];

    public function inscricao()
    {
        return $this->belongsTo(Inscricao::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getAtletasListaAttribute(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $this->nomes_atletas))
            ->map(fn($nome) => trim($nome))
            ->filter()
            ->values()
            ->toArray();
    }
}
