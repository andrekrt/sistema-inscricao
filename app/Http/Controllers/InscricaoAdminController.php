<?php

namespace App\Http\Controllers;

use App\Models\Inscricao;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exports\InscricoesPorCategoriaExport;
use Maatwebsite\Excel\Facades\Excel;

class InscricaoAdminController extends Controller
{
    public function index()
    {
        $inscricoes = Inscricao::withCount('atletas')
            ->orderByDesc('created_at')
            ->get();

        return view('inscricoes.index', compact('inscricoes'));
    }

    public function show(Inscricao $inscricao)
    {
        $inscricao->load([
            'atletas.categoria' => function ($query) {
                $query->orderBy('idade_min')->orderBy('tipo');
            }
        ]);

        $atletasAgrupados = $inscricao->atletas
            ->groupBy(function ($atleta) {
                return $atleta->categoria->nome ?? 'Sem categoria';
            });

        return view('inscricoes.show', [
            'inscricao' => $inscricao,
            'atletasAgrupados' => $atletasAgrupados,
        ]);
    }

    public function updateStatus(Request $request, Inscricao $inscricao)
    {
        $dados = $request->validate([
            'status' => ['required', Rule::in(['pendente', 'pago', 'confirmado', 'cancelado'])],
        ]);

        $inscricao->update([
            'status' => $dados['status'],
        ]);

        return redirect()
            ->route('inscricoes.show', $inscricao)
            ->with('success', 'Status da inscrição atualizado com sucesso.');
    }

    public function export()
    {
        return Excel::download(
            new InscricoesPorCategoriaExport(),
            'inscricoes-por-categoria.xlsx'
        );
    }
}
