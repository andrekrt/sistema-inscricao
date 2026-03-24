<x-layouts.admin title="Inscrições" pageTitle="Inscrições" pageSubtitle="Acompanhe as inscrições recebidas">
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    @endpush

    <div class="card content-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-1">Lista de inscrições</h5>
                    <p class="text-muted mb-0">Visualize os dojos inscritos, atletas e situação do pagamento.</p>
                </div>
            </div>

            <a href="{{ route('inscricoes.export') }}" class="btn btn-success">
                Exportar Excel
            </a>

            <div class="table-responsive">
                <table id="inscricoes-table" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Dojo</th>
                            <th>Sensei</th>
                            <th>Telefone</th>
                            <th>Atletas</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscricoes as $inscricao)
                            <tr>
                                <td>{{ $inscricao->dojo_nome }}</td>
                                <td>{{ $inscricao->sensei_nome }}</td>
                                <td>{{ $inscricao->telefone }}</td>
                                <td>{{ $inscricao->atletas_count }}</td>
                                <td>
                                    @php
                                        $badge = match ($inscricao->status) {
                                            'pendente' => 'warning text-dark',
                                            'pago' => 'info text-dark',
                                            'confirmado' => 'success',
                                            'cancelado' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <span class="badge bg-{{ $badge }}">
                                        {{ ucfirst($inscricao->status) }}
                                    </span>
                                </td>
                                <td>{{ $inscricao->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('inscricoes.show', $inscricao) }}" class="btn btn-sm btn-dark">
                                        Detalhes
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Nenhuma inscrição recebida ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#inscricoes-table').DataTable({
                    language: {
                        decimal: "",
                        emptyTable: "Nenhum registro encontrado",
                        info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        infoEmpty: "Mostrando 0 até 0 de 0 registros",
                        infoFiltered: "(filtrado de _MAX_ registros no total)",
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
                        }
                    },
                    pageLength: 10,
                    order: [
                        [5, 'desc']
                    ]
                });
            });
        </script>
    @endpush
</x-layouts.admin>
