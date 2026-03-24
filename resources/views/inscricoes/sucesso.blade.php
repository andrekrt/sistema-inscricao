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
            <div class="col-lg-7">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body p-5 text-center">
                        <h1 class="text-success fw-bold mb-3">Inscrição realizada com sucesso!</h1>
                        <p class="text-muted mb-4">
                            Sua inscrição foi recebida e será analisada pela organização do campeonato.
                        </p>

                        <a href="{{ route('inscricao.create') }}" class="btn btn-danger">
                            Nova inscrição
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
