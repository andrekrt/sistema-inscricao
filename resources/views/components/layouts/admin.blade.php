<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #111111 0%, #7a0d0d 100%);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .85);
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 6px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, .12);
            color: #fff;
        }

        .brand-box {
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
        }

        .content-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .08);
        }

        .stat-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .06);
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row g-0">
            <aside class="col-md-3 col-lg-2 sidebar text-white p-3">
                <div class="brand-box pb-3 mb-3">
                    <h4 class="mb-1">🥋 Karatê</h4>
                    <small class="text-white-50">Painel Administrativo</small>
                </div>

                <nav class="nav flex-column">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('categorias.index') }}"
                        class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                        Categorias
                    </a>

                    <a href="{{ route('inscricoes.index') }}"
                        class="nav-link {{ request()->routeIs('inscricoes.*') ? 'active' : '' }}">
                        Inscrições
                    </a>

                    {{-- <a href="#" class="nav-link">
                        Relatórios
                    </a> --}}
                </nav>
            </aside>

            <main class="col-md-9 col-lg-10 d-flex flex-column" style="min-height: 100vh;">
                <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $pageTitle ?? 'Painel' }}</h5>
                        <small class="text-muted">{{ $pageSubtitle ?? 'Gerenciamento do sistema' }}</small>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted small">
                            Olá, {{ Auth::user()->name }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                Sair
                            </button>
                        </form>
                    </div>
                </div>

                <div class="p-4 flex-grow-1">
                    {{ $slot }}
                </div>

                <footer class="text-center text-muted py-3 px-4 border-top bg-white mt-auto">
                    <small>
                        © {{ date('Y') }} | Copa Bacaba de Karatê-Dô Tradicional |
                        Desenvolvido por
                        <a href="https://innovakode.com.br" target="_blank" class="fw-semibold text-decoration-none">
                            Innova Kode
                        </a>
                    </small>
                </footer>
            </main>
        </div>
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#dc3545'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#dc3545'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Erro no formulário',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonColor: '#dc3545'
                });
            @endif

        });
    </script>
</body>

</html>
