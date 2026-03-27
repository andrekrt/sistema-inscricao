<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição realizada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f4f6f9;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body p-5 text-center">
                        <h1 class="text-success fw-bold mb-3">Inscrição realizada com sucesso!</h1>

                        <p class="text-muted mb-3">
                            Sua inscrição foi recebida e será analisada pela organização do campeonato.
                        </p>

                        <p class="text-muted">
                            Guarde este link para gerenciar sua inscrição, adicionar atletas, remover atletas e enviar comprovantes complementares.
                        </p>

                        <div class="alert alert-light border text-start mt-4">
                            <strong>Link de gerenciamento:</strong><br>
                            <a href="{{ $linkEdicao }}" target="_blank">{{ $linkEdicao }}</a>
                        </div>

                        <div class="d-flex justify-content-center gap-2 flex-wrap mt-4">
                            <a href="{{ $linkEdicao }}" class="btn btn-danger">
                                Gerenciar inscrição
                            </a>

                            <a href="{{ route('inscricao.create') }}" class="btn btn-outline-secondary">
                                Nova inscrição
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
