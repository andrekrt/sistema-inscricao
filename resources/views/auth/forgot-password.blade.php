<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row w-100 shadow-lg rounded-4 overflow-hidden bg-white" style="max-width: 950px;">

            <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center p-5 text-white"
                 style="background: linear-gradient(135deg, #111111 0%, #7a0d0d 100%);">
                <div>
                    <h1 class="fw-bold mb-3">Copa Bacabal de Karatê-Dô Tradicional</h1>
                    <p class="fs-5 text-light-emphasis">
                        Solicite um link para redefinir sua senha de acesso ao sistema.
                    </p>
                </div>

                <hr class="border-light my-4">

                <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                    <h6 class="fw-bold mb-1">Recuperação de acesso</h6>
                    <small>Informe seu e-mail cadastrado e enviaremos um link seguro para redefinição de senha.</small>
                </div>
            </div>

            <div class="col-lg-6 p-4 p-md-5">
                <div class="mb-4 text-center text-lg-start">
                    <h2 class="fw-bold mb-2">Esqueceu sua senha?</h2>
                    <p class="text-muted mb-0">
                        Informe seu e-mail e enviaremos um link para você criar uma nova senha.
                    </p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               required
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">
                        Enviar link de redefinição
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        Voltar para o login
                    </a>
                </div>

                <div class="text-center text-muted small mt-4">
                    {{ config('app.name') }}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
