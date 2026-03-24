<x-layouts.admin title="Categorias" pageTitle="Categorias" pageSubtitle="Gerencie as categorias do campeonato">
    <div class="card content-card">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h5 class="mb-1">Lista de categorias</h5>
                    <p class="text-muted mb-0">Organize e filtre as categorias por tipo.</p>
                </div>

                <a href="{{ route('categorias.create') }}" class="btn btn-danger">
                    Nova categoria
                </a>
            </div>

            <div class="mb-4">
                <div class="d-flex flex-wrap gap-2" id="filtros-tipo">
                    <button type="button" class="btn btn-dark btn-sm filtro-tipo active" data-tipo="">
                        Todas
                    </button>
                    @foreach ($tipos as $valor => $label)
                        <button type="button" class="btn btn-outline-dark btn-sm filtro-tipo"
                            data-tipo="{{ $valor }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="table-responsive">
                <table id="categorias-table" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo</th>
                            <th>Nome</th>
                            <th>Idade</th>
                            <th>Sexo</th>
                            <th>Faixas</th>
                            <th>Especial</th>
                            <th>Status</th>
                            <th width="170">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr data-tipo="{{ $categoria->tipo }}">
                                <td>
                                    <span class="badge bg-dark">
                                        {{ $tipos[$categoria->tipo] ?? $categoria->tipo }}
                                    </span>
                                </td>
                                <td>{{ $categoria->nome }}</td>
                                <td>{{ $categoria->idade_min }} a {{ $categoria->idade_max }}</td>
                                <td>{{ $categoria->sexo === 'M' ? 'Masculino' : 'Feminino' }}</td>
                                <td>{{ ucfirst($categoria->faixa_inicial) }} até {{ ucfirst($categoria->faixa_final) }}
                                </td>
                                <td>
                                    @if ($categoria->especial)
                                        <span class="badge bg-warning text-dark">
                                            {{ $especiais[$categoria->especial] ?? $categoria->especial }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($categoria->ativo)
                                        <span class="badge bg-success">Ativa</span>
                                    @else
                                        <span class="badge bg-secondary">Inativa</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('categorias.edit', $categoria) }}"
                                            class="btn btn-sm btn-warning">
                                            Editar
                                        </a>

                                        <form method="POST" action="{{ route('categorias.destroy', $categoria) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Nenhuma categoria cadastrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
        <style>
            #categorias-table_wrapper .dataTables_filter input {
                margin-left: .5rem;
            }

            #categorias-table_wrapper .dataTables_length select {
                margin: 0 .5rem;
            }

            .filtro-tipo.active {
                background-color: #212529 !important;
                color: #fff !important;
                border-color: #212529 !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                let filtroTipoAtual = '';

                const table = $('#categorias-table').DataTable({
                    language: {
                        decimal: "",
                        emptyTable: "Nenhum registro encontrado",
                        info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        infoEmpty: "Mostrando 0 até 0 de 0 registros",
                        infoFiltered: "(filtrado de _MAX_ registros no total)",
                        infoPostFix: "",
                        thousands: ".",
                        lengthMenu: "Mostrar _MENU_ registros",
                        loadingRecords: "Carregando...",
                        processing: "Processando...",
                        search: "Buscar:",
                        zeroRecords: "Nenhum registro encontrado",
                        paginate: {
                            first: "Primeiro",
                            last: "Último",
                            next: "Próximo",
                            previous: "Anterior"
                        },
                        aria: {
                            sortAscending: ": ativar para ordenar a coluna de forma crescente",
                            sortDescending: ": ativar para ordenar a coluna de forma decrescente"
                        }
                    },
                    pageLength: 10,
                    order: [
                        [0, 'asc'],
                        [2, 'asc']
                    ]
                });

                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    if (settings.nTable.id !== 'categorias-table') {
                        return true;
                    }

                    if (!filtroTipoAtual) {
                        return true;
                    }

                    const row = table.row(dataIndex).node();
                    const tipo = $(row).data('tipo');

                    return tipo === filtroTipoAtual;
                });

                $('.filtro-tipo').on('click', function() {
                    $('.filtro-tipo')
                        .removeClass('active btn-dark')
                        .addClass('btn-outline-dark');

                    $(this)
                        .addClass('active btn-dark')
                        .removeClass('btn-outline-dark');

                    filtroTipoAtual = $(this).data('tipo');
                    table.draw();
                });
            });

            document.addEventListener('DOMContentLoaded', function() {

                document.querySelectorAll('.btn-delete').forEach(button => {
                    button.addEventListener('click', function() {

                        let form = this.closest('form');

                        Swal.fire({
                            title: 'Tem certeza?',
                            text: "Essa ação não poderá ser desfeita!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Sim, excluir',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });

                    });
                });

            });
        </script>
    @endpush
</x-layouts.admin>
