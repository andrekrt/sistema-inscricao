<x-layouts.admin title="Dashboard" pageTitle="Dashboard" pageSubtitle="Visão geral do sistema">
    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-muted">Categorias</h6>
                    <h2 class="fw-bold mb-0">{{ \App\Models\Categoria::count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-muted">Inscrições</h6>
                    <h2 class="fw-bold mb-0">{{ \App\Models\Inscricao::count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-muted">Atletas</h6>
                    <h2 class="fw-bold mb-0">{{ \App\Models\Atleta::count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-muted">Pendentes</h6>
                    <h2 class="fw-bold mb-0">{{ \App\Models\Inscricao::where('status', 'pendente')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card content-card mt-4">
        <div class="card-body">
            <h5 class="mb-3">Acesso rápido</h5>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('categorias.index') }}" class="btn btn-outline-dark">Categorias</a>
                <a href="{{ route('inscricoes.index') }}" class="btn btn-danger">Inscrições</a>
                <a href="{{ route('inscricao.create') }}" target="_blank" class="btn btn-outline-secondary">Abrir formulário público</a>
            </div>
        </div>
    </div>
</x-layouts.admin>
