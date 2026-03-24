<x-layouts.admin title="Detalhes da inscrição" pageTitle="Detalhes da inscrição"
    pageSubtitle="Visualize atletas, comprovante e situação">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card content-card">
                <div class="card-body">
                    <h5 class="mb-3">Dados da inscrição</h5>

                    <div class="mb-2">
                        <strong>Dojo:</strong><br>
                        {{ $inscricao->dojo_nome }}
                    </div>

                    <div class="mb-2">
                        <strong>Sensei / Responsável:</strong><br>
                        {{ $inscricao->sensei_nome }}
                    </div>

                    <div class="mb-2">
                        <strong>Telefone:</strong><br>
                        {{ $inscricao->telefone }}
                    </div>

                    <div class="mb-2">
                        <strong>E-mail:</strong><br>
                        {{ $inscricao->email ?: '-' }}
                    </div>

                    <div class="mb-2">
                        <strong>Total de atletas:</strong><br>
                        {{ $inscricao->atletas->count() }}
                    </div>

                    <div class="mb-3">
                        <strong>Enviado em:</strong><br>
                        {{ $inscricao->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div class="mb-3">
                        <strong>Comprovante:</strong><br>
                        <a href="{{ asset('storage/' . $inscricao->comprovante) }}" target="_blank"
                            class="btn btn-sm btn-outline-dark mt-2">
                            Ver comprovante
                        </a>
                    </div>

                    <hr>

                    @php
                        $statusLabel = match ($inscricao->status) {
                            'pendente' => 'Pendente',
                            'pago' => 'Pago',
                            'confirmado' => 'Confirmado',
                            'cancelado' => 'Cancelado',
                            default => ucfirst($inscricao->status),
                        };

                        $statusClasse = match ($inscricao->status) {
                            'pendente' => 'warning text-dark',
                            'pago' => 'info text-dark',
                            'confirmado' => 'success',
                            'cancelado' => 'danger',
                            default => 'secondary',
                        };
                    @endphp

                    <div class="mb-3">
                        <label class="form-label"><strong>Status atual</strong></label>
                        <div>
                            <span class="badge bg-{{ $statusClasse }} fs-6 px-3 py-2">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('inscricoes.updateStatus', $inscricao) }}"
                        id="form-status-inscricao">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label"><strong>Novo status</strong></label>
                            <select name="status" id="novo_status" class="form-select">
                                <option value="pendente" @selected($inscricao->status === 'pendente')>Pendente</option>
                                <option value="pago" @selected($inscricao->status === 'pago')>Pago</option>
                                <option value="confirmado" @selected($inscricao->status === 'confirmado')>Confirmado</option>
                                <option value="cancelado" @selected($inscricao->status === 'cancelado')>Cancelado</option>
                            </select>
                            <div class="form-text">
                                Escolha o novo status da inscrição e confirme a alteração.
                            </div>
                        </div>

                        <button type="button" class="btn btn-danger w-100" id="btn-atualizar-status">
                            Atualizar status
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card content-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Atletas inscritos</h5>
                        <a href="{{ route('inscricoes.index') }}" class="btn btn-secondary btn-sm">
                            Voltar
                        </a>
                    </div>

                    @forelse($atletasAgrupados as $categoriaNome => $atletas)
                        <div class="mb-4">
                            <h6 class="fw-bold border-bottom pb-2">{{ $categoriaNome }}</h6>

                            <div class="table-responsive">
                                <table class="table table-sm table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Data nascimento</th>
                                            <th>Sexo</th>
                                            <th>Faixa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($atletas as $atleta)
                                            <tr>
                                                <td>{{ $atleta->nome_completo }}</td>
                                                <td>{{ \Carbon\Carbon::parse($atleta->data_nascimento)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ $atleta->sexo === 'M' ? 'Masculino' : 'Feminino' }}</td>
                                                <td>{{ ucfirst($atleta->faixa) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Nenhum atleta encontrado nesta inscrição.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnAtualizar = document.getElementById('btn-atualizar-status');
                const formStatus = document.getElementById('form-status-inscricao');
                const selectStatus = document.getElementById('novo_status');
                const statusAtual = @json($inscricao->status);

                const labels = {
                    pendente: 'Pendente',
                    pago: 'Pago',
                    confirmado: 'Confirmado',
                    cancelado: 'Cancelado'
                };

                btnAtualizar.addEventListener('click', function() {
                    const novoStatus = selectStatus.value;

                    if (novoStatus === statusAtual) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Nenhuma alteração',
                            text: 'Selecione um status diferente do atual para atualizar.',
                            confirmButtonColor: '#7a0d0d'
                        });
                        return;
                    }

                    Swal.fire({
                        icon: 'question',
                        title: 'Confirmar alteração?',
                        html: `
                    <p>Você está alterando o status da inscrição de:</p>
                    <p><strong>${labels[statusAtual]}</strong> para <strong>${labels[novoStatus]}</strong></p>
                `,
                        showCancelButton: true,
                        confirmButtonText: 'Sim, atualizar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#7a0d0d',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formStatus.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-layouts.admin>
