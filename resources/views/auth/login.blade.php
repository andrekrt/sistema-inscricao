<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row w-100 shadow-lg rounded-4 overflow-hidden bg-white" style="max-width: 950px;">

            <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center p-5 text-white"
                 style="background: linear-gradient(135deg, #111111 0%, #7a0d0d 100%);">
                <div>
                    <h1 class="fw-bold mb-3">Sistema de Inscrição de Karatê</h1>
                    <p class="fs-5 text-light-emphasis">
                        Gerencie categorias, inscrições, atletas e comprovantes de pagamento de forma simples.
                    </p>
                </div>

                <hr class="border-light my-4">

                <div class="row g-3">
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                            <h6 class="fw-bold mb-1">Painel Administrativo</h6>
                            <small>Controle total das categorias e inscrições do campeonato.</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                            <h6 class="fw-bold mb-1">Organização por Dojo</h6>
                            <small>Cadastro centralizado dos atletas por responsável.</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                            <h6 class="fw-bold mb-1">Validação de Pagamento</h6>
                            <small>Acompanhe comprovantes e situação das inscrições.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 p-4 p-md-5">
                <div class="mb-4 text-center text-lg-start">
                    <h2 class="fw-bold mb-2">Acesso ao sistema</h2>
                    <p class="text-muted mb-0">Entre com seu usuário para acessar o painel administrativo.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               required
                               autofocus
                               autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input id="password"
                               type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required
                               autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label" for="remember_me">
                                Lembrar acesso
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none">
                                Esqueceu a senha?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">
                        Entrar
                    </button>
                </form>

                <div class="text-center text-muted small mt-4">
                    {{ config('app.name') }}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
