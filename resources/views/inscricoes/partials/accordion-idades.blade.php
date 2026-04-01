<div class="accordion" id="accordionIdades">
    @foreach ($categoriasAgrupadas as $chave => $grupo)
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
                        @if ($categoria->tipo_disputa === 'equipe')
                            @include('inscricoes.partials.card-categoria-equipe', [
                                'categoria' => $categoria,
                                'grupoLabel' => $grupo['label'],
                            ])
                        @else
                            @include('inscricoes.partials.card-categoria', [
                                'categoria' => $categoria,
                                'grupoLabel' => $grupo['label'],
                            ])
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="d-flex justify-content-end mt-4">
    <button type="button" class="btn btn-dark btn-lg px-5" id="btn-revisar-inscricao">
        Revisar e finalizar inscrição
    </button>
</div>
