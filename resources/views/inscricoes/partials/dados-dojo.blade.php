<div class="card card-principal mb-4">
    <div class="card-body p-4">
        <h4 class="mb-4">Dados do dojo / responsável</h4>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nome do dojo</label>
                <input type="text" name="dojo_nome" class="form-control" value="{{ old('dojo_nome') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nome do sensei / responsável</label>
                <input type="text" name="sensei_nome" class="form-control" value="{{ old('sensei_nome') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Telefone / WhatsApp</label>
                <input type="text" name="telefone" class="form-control" id="telefone" value="{{ old('telefone') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">E-mail (opcional)</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="col-12">
                <label class="form-label">Comprovante de pagamento</label>
                <input type="file" name="comprovante" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                <div class="form-text">Formatos aceitos: PDF, JPG, JPEG e PNG. Máximo: 5MB.</div>
            </div>
        </div>
    </div>
</div>
