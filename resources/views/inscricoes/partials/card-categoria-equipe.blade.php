@php
    $nomesAtletas = old(
        'equipes.' . $categoria->id . '.nomes_atletas',
        $equipesOld[$categoria->id]['nomes_atletas'] ?? '',
    );

    $tipoLabel = match ($categoria->tipo) {
        'fukugo' => 'Fukugo',
        'kata' => 'Kata',
        'kumite' => 'Kumite',
        'tira_fita' => 'Tira fita',
        'kihon_ippon' => 'Kihon ippon',
        default => ucfirst($categoria->tipo),
    };
@endphp

<div class="card card-categoria mb-3">
    <div class="card-header categoria-header">
        <div class="py-2">
            <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
                <span class="badge bg-primary badge-tipo">Equipe</span>
                <span class="badge bg-dark badge-tipo">{{ $tipoLabel }}</span>

                @if ($categoria->especial)
                    <span class="badge bg-warning text-dark badge-tipo">{{ strtoupper($categoria->especial) }}</span>
                @endif
            </div>

            <h5 class="mb-1">{{ $categoria->nome }}</h5>

            <div class="small text-muted">
                Equipe com mínimo {{ $categoria->min_atletas_equipe }} e máximo {{ $categoria->max_atletas_equipe }}
                atleta(s)
            </div>
        </div>
    </div>

    <div class="card-body">
        <label class="form-label fw-semibold">Atletas da equipe</label>

        <textarea name="equipes[{{ $categoria->id }}][nomes_atletas]" class="form-control" rows="6"
            placeholder="Digite um nome por linha&#10;Exemplo:&#10;João Silva&#10;Pedro Santos&#10;Lucas Costa">{{ $nomesAtletas }}</textarea>

        <div class="form-text">
            Digite um atleta por linha. Cada dojo pode ter apenas uma equipe por categoria.
        </div>

        @error('equipes.' . $categoria->id . '.nomes_atletas')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>
