<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/inscricoes-publica.css', 'resources/js/inscricoes-publica.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="topo py-5 mb-4">
        <div class="container">
            <h1 class="fw-bold mb-2">Inscrição Copa Bacaba de Karatê-Dô Tradicional</h1>
            <p class="mb-0">Preencha os dados do dojo e inscreva os atletas em suas respectivas categorias.</p>
        </div>
    </div>

    <div class="container pb-5">
        @include('inscricoes.partials.alertas')

        <form method="POST" action="{{ route('inscricao.store') }}" enctype="multipart/form-data" id="form-inscricao">
            @csrf

            <div class="row g-4">
                <div class="col-lg-8">
                    @include('inscricoes.partials.dados-dojo')
                    @include('inscricoes.partials.accordion-idades')
                </div>

                <div class="col-lg-4">
                    @include('inscricoes.partials.resumo')
                </div>
            </div>
        </form>
    </div>

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

    <script>
        window.inscricaoConfig = {
            categoriasOld: @json(old('categorias', [])),
            faixas: @json($faixas),
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
