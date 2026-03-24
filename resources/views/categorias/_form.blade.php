@php
    $categoria = $categoria ?? null;
@endphp

<div class="row g-4">

    {{-- BLOCO 1 --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="mb-1">Informações gerais</h5>
                    <p class="text-muted mb-0">Defina o tipo, sexo e configurações principais da categoria.</p>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tipo da categoria</label>
                        <select name="tipo" id="tipo" class="form-select" required>
                            <option value="">Selecione</option>
                            @foreach($tipos as $valor => $label)
                                <option value="{{ $valor }}" @selected(old('tipo', $categoria->tipo ?? '') === $valor)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Ex.: Kata, Kumite, Fukugo, Tira fita ou Kihon ippon.</div>
                        @error('tipo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sexo</label>
                        <select name="sexo" id="sexo" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="M" @selected(old('sexo', $categoria->sexo ?? '') === 'M')>Masculino</option>
                            <option value="F" @selected(old('sexo', $categoria->sexo ?? '') === 'F')>Feminino</option>
                        </select>
                        <div class="form-text">Define quem poderá se inscrever nessa categoria.</div>
                        @error('sexo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Categoria especial</label>
                        <select name="especial" id="especial" class="form-select">
                            <option value="">Nenhuma</option>
                            @foreach($especiais as $valor => $label)
                                <option value="{{ $valor }}" @selected(old('especial', $categoria->especial ?? '') === $valor)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Use apenas quando a categoria for PCD ou Master.</div>
                        @error('especial')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   role="switch"
                                   name="ativo"
                                   value="1"
                                   id="ativo"
                                   @checked(old('ativo', $categoria->ativo ?? true))>
                            <label class="form-check-label fw-semibold" for="ativo">
                                Disponível para inscrição
                            </label>
                        </div>
                        <div class="form-text">Se desativada, a categoria não deve aparecer no formulário público.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BLOCO 2 --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="mb-1">Faixa etária</h5>
                    <p class="text-muted mb-0">Informe o intervalo de idade permitido para essa categoria.</p>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Idade mínima</label>
                        <input type="number"
                               name="idade_min"
                               id="idade_min"
                               min="0"
                               max="99"
                               class="form-control"
                               value="{{ old('idade_min', $categoria->idade_min ?? '') }}"
                               required>
                        <div class="form-text">Ex.: 14</div>
                        @error('idade_min')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Idade máxima</label>
                        <input type="number"
                               name="idade_max"
                               id="idade_max"
                               min="0"
                               max="99"
                               class="form-control"
                               value="{{ old('idade_max', $categoria->idade_max ?? '') }}"
                               required>
                        <div class="form-text">Use 99 para categorias “acima”.</div>
                        @error('idade_max')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BLOCO 3 --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="mb-1">Graduação</h5>
                    <p class="text-muted mb-0">Defina a faixa inicial e final permitidas para a categoria.</p>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Faixa inicial</label>
                        <select name="faixa_inicial" id="faixa_inicial" class="form-select" required>
                            <option value="">Selecione</option>
                            @foreach($faixas as $faixa)
                                <option value="{{ $faixa }}" @selected(old('faixa_inicial', $categoria->faixa_inicial ?? '') === $faixa)>
                                    {{ ucfirst($faixa) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Ex.: Branca, Laranja, Verde.</div>
                        @error('faixa_inicial')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Faixa final</label>
                        <select name="faixa_final" id="faixa_final" class="form-select" required>
                            <option value="">Selecione</option>
                            @foreach($faixas as $faixa)
                                <option value="{{ $faixa }}" @selected(old('faixa_final', $categoria->faixa_final ?? '') === $faixa)>
                                    {{ ucfirst($faixa) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">A faixa final deve ser igual ou superior à faixa inicial.</div>
                        @error('faixa_final')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BLOCO 4 --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="mb-1">Nome da categoria</h5>
                    <p class="text-muted mb-0">
                        O sistema monta automaticamente o nome da categoria com base nos dados preenchidos.
                    </p>
                </div>

                <div class="alert alert-light border rounded-4 mb-3">
                    <div class="small text-muted mb-1">Pré-visualização automática</div>
                    <div id="preview_nome" class="fw-semibold text-dark">
                        —
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nome final da categoria</label>
                    <input type="text"
                           name="nome"
                           id="nome"
                           class="form-control"
                           value="{{ old('nome', $categoria->nome ?? '') }}"
                           required>
                    <div class="form-text">
                        Você pode editar manualmente, mas o sistema já sugere um nome padronizado.
                    </div>
                    @error('nome')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-outline-dark btn-sm" id="gerar_nome">
                        Gerar nome automaticamente
                    </button>

                    <button type="button" class="btn btn-outline-secondary btn-sm" id="restaurar_nome">
                        Restaurar sugestão
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- BOTÕES --}}
    <div class="col-12">
        <div class="d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-danger px-4">
                Salvar categoria
            </button>

            <a href="{{ route('categorias.index') }}" class="btn btn-secondary px-4">
                Cancelar
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipo = document.getElementById('tipo');
        const sexo = document.getElementById('sexo');
        const especial = document.getElementById('especial');
        const idadeMin = document.getElementById('idade_min');
        const idadeMax = document.getElementById('idade_max');
        const faixaInicial = document.getElementById('faixa_inicial');
        const faixaFinal = document.getElementById('faixa_final');
        const nome = document.getElementById('nome');
        const previewNome = document.getElementById('preview_nome');
        const btnGerarNome = document.getElementById('gerar_nome');
        const btnRestaurarNome = document.getElementById('restaurar_nome');

        const tipoMap = {
            fukugo: 'Fukugo',
            kata: 'Kata individual',
            kumite: 'Kumite individual',
            tira_fita: 'Tira fita',
            kihon_ippon: 'Kihon ippon'
        };

        const sexoMap = {
            M: 'masculino',
            F: 'feminino'
        };

        function capitalize(valor) {
            if (!valor) return '';
            return valor.charAt(0).toUpperCase() + valor.slice(1);
        }

        function montarTextoIdade(min, max) {
            if (min === '' || max === '') return '';

            const minNum = parseInt(min, 10);
            const maxNum = parseInt(max, 10);

            if (isNaN(minNum) || isNaN(maxNum)) return '';

            if (maxNum === 99) {
                return `${minNum} anos acima`;
            }

            if (minNum === 0) {
                return `até ${maxNum} anos`;
            }

            if (minNum === maxNum) {
                return `${minNum} anos`;
            }

            return `${minNum} a ${maxNum} anos`;
        }

        function montarTextoFaixa(inicial, final) {
            if (!inicial || !final) return '';

            if (final === 'preta') {
                return `${inicial} acima`;
            }

            if (inicial === final) {
                return inicial;
            }

            return `${inicial} a ${final}`;
        }

        function montarNome() {
            const tipoTexto = tipoMap[tipo.value] || '';
            const sexoTexto = sexoMap[sexo.value] || '';
            const idadeTexto = montarTextoIdade(idadeMin.value, idadeMax.value);
            const faixaTexto = montarTextoFaixa(faixaInicial.value, faixaFinal.value);
            const especialTexto = especial.value ? ` (${especial.options[especial.selectedIndex].text})` : '';

            let partes = [];

            if (tipoTexto) partes.push(tipoTexto);
            if (sexoTexto) partes.push(sexoTexto);
            if (idadeTexto) partes.push(idadeTexto);
            if (faixaTexto) partes.push(faixaTexto);

            let resultado = partes.join(' - ');
            resultado += especialTexto;

            previewNome.textContent = resultado || '—';

            return resultado;
        }

        function validarFrontend() {
            const min = parseInt(idadeMin.value || '-1', 10);
            const max = parseInt(idadeMax.value || '-1', 10);

            if (!isNaN(min) && !isNaN(max) && min > max) {
                idadeMax.setCustomValidity('A idade máxima deve ser maior ou igual à idade mínima.');
            } else {
                idadeMax.setCustomValidity('');
            }

            const ordemFaixas = [
                'branca',
                'cinza',
                'azul',
                'amarela',
                'laranja',
                'verde',
                'roxa',
                'marrom',
                'preta'
            ];

            const ini = ordemFaixas.indexOf(faixaInicial.value);
            const fim = ordemFaixas.indexOf(faixaFinal.value);

            if (ini !== -1 && fim !== -1 && ini > fim) {
                faixaFinal.setCustomValidity('A faixa final deve ser igual ou superior à faixa inicial.');
            } else {
                faixaFinal.setCustomValidity('');
            }
        }

        [tipo, sexo, especial, idadeMin, idadeMax, faixaInicial, faixaFinal].forEach(campo => {
            campo.addEventListener('change', function () {
                validarFrontend();
                montarNome();
            });

            campo.addEventListener('input', function () {
                validarFrontend();
                montarNome();
            });
        });

        btnGerarNome.addEventListener('click', function () {
            nome.value = montarNome();
        });

        btnRestaurarNome.addEventListener('click', function () {
            nome.value = montarNome();
        });

        montarNome();
        validarFrontend();
    });
</script>
@endpush
