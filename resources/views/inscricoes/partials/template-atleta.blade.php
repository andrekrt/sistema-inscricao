<template id="template-atleta">
    <div class="atleta-item mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Atleta <span class="numero-atleta"></span></h6>
            <button type="button" class="btn btn-sm btn-outline-danger remover-atleta">Remover</button>
        </div>

        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label">Nome completo</label>
                <input type="text" class="form-control campo-nome" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Data de nascimento</label>
                <input type="date" class="form-control campo-data" required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Sexo</label>
                <select class="form-select campo-sexo" required>
                    <option value="">Selecione</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Faixa</label>
                <select class="form-select campo-faixa" required>
                    <option value="">Selecione</option>
                    @foreach($faixas as $faixa)
                        <option value="{{ $faixa }}">{{ ucfirst($faixa) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</template>
