@php
    $categoriaOld = old('categorias.' . $categoria->id . '.atletas', []);
    $tipoLabel = match($categoria->tipo) {
        'fukugo' => 'Fukugo',
        'kata' => 'Kata',
        'kumite' => 'Kumite',
        'tira_fita' => 'Tira fita',
        'kihon_ippon' => 'Kihon ippon',
        default => ucfirst($categoria->tipo),
    };
@endphp

<div class="card card-categoria"
     data-categoria-id="{{ $categoria->id }}"
     data-categoria-nome="{{ $categoria->nome }}"
     data-faixa-etaria="{{ $grupoLabel }}">
    <div class="card-header categoria-header">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 py-2">
            <div>
                <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
                    <span class="badge bg-dark badge-tipo">{{ $tipoLabel }}</span>

                    @if($categoria->especial)
                        <span class="badge bg-warning text-dark badge-tipo">{{ strtoupper($categoria->especial) }}</span>
                    @endif

                    <span class="badge bg-danger contador-atletas" id="contador-{{ $categoria->id }}">
                        0 atleta(s)
                    </span>
                </div>

                <h5 class="mb-1">{{ $categoria->nome }}</h5>

                <div class="small text-muted">
                    Sexo: {{ $categoria->sexo === 'M' ? 'Masculino' : 'Feminino' }} |
                    Faixas: {{ ucfirst($categoria->faixa_inicial) }} até {{ ucfirst($categoria->faixa_final) }}
                </div>
            </div>

            <button type="button"
                    class="btn btn-danger btn-sm adicionar-atleta"
                    data-add-atleta-categoria-id="{{ $categoria->id }}">
                Adicionar atleta
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="lista-atletas" id="lista-atletas-{{ $categoria->id }}"></div>

        @if(count($categoriaOld))
            <script>
                window.categoriasOld = window.categoriasOld || {};
                window.categoriasOld[{{ $categoria->id }}] = @json(array_values($categoriaOld));
            </script>
        @endif
    </div>
</div>
