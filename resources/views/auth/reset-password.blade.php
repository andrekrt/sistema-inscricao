<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir senha - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100"
      style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12" style="max-width: 950px;">
                    <div class="row shadow-lg rounded-4 overflow-hidden bg-white">

                        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center p-5 text-white"
                             style="background: linear-gradient(135deg, #111111 0%, #7a0d0d 100%);">
                            <div>
                                <h1 class="fw-bold mb-3">Copa Bacabal de Karatê-Dô Tradicional</h1>
                                <p class="fs-5 text-light-emphasis">
                                    Redefina sua senha para acessar novamente o painel administrativo.
                                </p>
                            </div>

                            <hr class="border-light my-4">

                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                                <h6 class="fw-bold mb-1">Segurança de acesso</h6>
                                <small>
                                    Crie uma nova senha segura para continuar gerenciando inscrições, categorias e atletas.
                                </small>
                            </div>
                        </div>

                        <div class="col-lg-6 p-4 p-md-5">
                            <div class="mb-4 text-center text-lg-start">
                                <h2 class="fw-bold mb-2">Redefinir senha</h2>
                                <p class="text-muted mb-0">Informe seu e-mail e escolha uma nova senha.</p>
                            </div>

                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input id="email"
                                           type="email"
                                           name="email"
                                           value="{{ old('email', $request->email) }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           required
                                           autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Nova senha</label>
                                    <input id="password"
                                           type="password"
                                           name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Confirmar nova senha</label>
                                    <input id="password_confirmation"
                                           type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                           required>
                                </div>

                                <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">
                                    Redefinir senha
                                </button>
                            </form>

                            <div class="text-center text-muted small mt-4">
                                {{ config('app.name') }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center text-muted py-3 border-top bg-white">
        <small>
            © {{ date('Y') }} | Copa Bacabal de Karatê-Dô Tradicional |
            Desenvolvido por
            <a href="https://innovakode.com.br" target="_blank" class="fw-semibold text-decoration-none">
                Innova Kode
            </a>
        </small>
    </footer>

</body>
</html>
