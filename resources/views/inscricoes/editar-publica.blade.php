<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar inscrição - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/inscricoes-publica.css', 'resources/js/inscricoes-publica.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="topo py-5 mb-4">
        <div class="container">
            <h1 class="fw-bold mb-2">Gerenciar inscrição do dojo</h1>
            <p class="mb-0">Adicione ou remova atletas e envie comprovantes complementares.</p>
        </div>
    </div>

    <main class="flex-grow-1">
        <div class="container pb-5">
            @include('inscricoes.partials.alertas')

            <form method="POST"
                action="{{ route('inscricao.update.token', ['id' => $inscricao->id, 'token' => $token]) }}"
                enctype="multipart/form-data"
                id="form-inscricao">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card card-principal mb-4">
                            <div class="card-body p-4">
                                <h4 class="mb-4">Dados do dojo / responsável</h4>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nome do dojo</label>
                                        <input type="text" class="form-control" value="{{ $inscricao->dojo_nome }}" disabled>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Nome do sensei / responsável</label>
                                        <input type="text" class="form-control" value="{{ $inscricao->sensei_nome }}" disabled>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Telefone / WhatsApp</label>
                                        <input type="text" name="telefone" id="telefone" class="form-control"
                                            value="{{ old('telefone', $inscricao->telefone) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $inscricao->email) }}">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Novo comprovante complementar</label>
                                        <input type="file" name="novo_comprovante" class="form-control"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <div class="form-text">
                                            Os comprovantes antigos serão mantidos. Você pode anexar apenas comprovantes complementares.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <strong>Comprovantes já enviados:</strong>
                                        <div class="mt-2 d-flex flex-column gap-2">
                                            @forelse($inscricao->comprovantes as $index => $comprovante)
                                                <div class="border rounded p-2">
                                                    <div class="small text-muted mb-1">
                                                        Comprovante {{ $index + 1 }} • enviado em {{ $comprovante->created_at->format('d/m/Y H:i') }}
                                                    </div>

                                                    <div class="small mb-2">
                                                        {{ $comprovante->nome_original ?: 'Arquivo sem nome' }}
                                                    </div>

                                                    <a href="{{ asset('storage/' . $comprovante->arquivo) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-dark">
                                                        Ver arquivo
                                                    </a>
                                                </div>
                                            @empty
                                                <div class="text-muted">Nenhum comprovante encontrado.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('inscricoes.partials.accordion-idades-edicao')
                    </div>

                    <div class="col-lg-4">
                        @include('inscricoes.partials.resumo')
                    </div>
                </div>
            </form>
        </div>
    </main>

    <footer class="text-center text-muted py-3 px-4 border-top bg-white mt-auto">
        <small>
            © {{ date('Y') }} | Copa Bacabal de Karatê-Dô Tradicional |
            Desenvolvido por
            <a href="https://innovakode.com.br" target="_blank" class="fw-semibold text-decoration-none">
                Innova Kode
            </a>
        </small>
    </footer>

    @include('inscricoes.partials.template-atleta')

    @php
        $categoriasOld = old('categorias');

        if (!$categoriasOld) {
            $categoriasOld = $atletasPorCategoria
                ->map(function ($grupo) {
                    return [
                        'atletas' => $grupo->map(function ($atleta) {
                            return [
                                'nome_completo' => $atleta->nome_completo,
                                'data_nascimento' => $atleta->data_nascimento,
                                'sexo' => $atleta->sexo,
                                'faixa' => $atleta->faixa,
                            ];
                        })->values()->toArray(),
                    ];
                })
                ->toArray();
        }
    @endphp

    <script>
        window.inscricaoConfig = {
            categoriasOld: @json($categoriasOld),
            faixas: @json($faixas),
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
