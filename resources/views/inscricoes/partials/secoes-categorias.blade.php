{{-- =========================
    CATEGORIAS INDIVIDUAIS
========================= --}}
<div class="mb-5">
    <div class="mb-3">
        <h4 class="fw-bold mb-1">Categorias individuais</h4>
        <p class="text-muted mb-0">
            Primeiro, inscreva os atletas nas categorias individuais.
        </p>
    </div>

    <div class="accordion" id="accordionIdades">
        @foreach ($categoriasIndividuaisAgrupadas as $chave => $grupo)
            @php
                $collapseId = 'idade_' . str_replace('-', '_', $chave);
            @endphp

            <div class="accordion-item mb-3">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#{{ $collapseId }}">
                        {{ $grupo['label'] }}
                    </button>
                </h2>

                <div id="{{ $collapseId }}" class="accordion-collapse collapse" data-bs-parent="#accordionIdades">

                    <div class="accordion-body">
                        @foreach ($grupo['categorias'] as $categoria)
                            @include('inscricoes.partials.card-categoria', [
                                'categoria' => $categoria,
                                'grupoLabel' => $grupo['label'],
                            ])
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


{{-- =========================
    CATEGORIAS POR EQUIPE
========================= --}}
<div class="mb-4">
    <div class="mb-3">
        <h4 class="fw-bold mb-1">Categorias por equipe</h4>
        <p class="text-muted mb-0">
            Agora informe as equipes. Cada dojo pode ter apenas uma equipe por categoria.
        </p>
    </div>

    @if ($categoriasEquipe->count())
        <div class="d-flex flex-column gap-3">
            @foreach ($categoriasEquipe as $categoria)
                @include('inscricoes.partials.card-categoria-equipe', [
                    'categoria' => $categoria,
                    'equipesOld' => $equipesOld ?? [],
                ])
            @endforeach
        </div>
    @else
        <div class="alert alert-light border">
            Nenhuma categoria por equipe disponível no momento.
        </div>
    @endif
</div>


<div class="d-flex justify-content-end mt-4">
    <button type="button" class="btn btn-dark btn-lg px-5" id="btn-revisar-inscricao">
        Finalizar inscrição
    </button>
</div>
