<?php

namespace App\Http\Controllers;

use App\Models\Atleta;
use App\Models\Categoria;
use App\Models\Inscricao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class InscricaoController extends Controller
{
    private array $faixas = [
        'branca',
        'cinza',
        'azul',
        'amarela',
        'laranja',
        'verde',
        'roxa',
        'marrom',
        'preta',
    ];

    private array $tipos = [
        'fukugo' => 'Fukugo',
        'kata' => 'Kata',
        'kumite' => 'Kumite',
        'tira_fita' => 'Tira fita',
        'kihon_ippon' => 'Kihon ippon',
    ];

    public function create()
    {
        $categorias = Categoria::where('ativo', true)
            ->orderBy('idade_min')
            ->orderBy('idade_max')
            ->orderBy('tipo')
            ->orderBy('sexo')
            ->get();

        $categoriasAgrupadas = $categorias->groupBy(function ($categoria) {
            return $categoria->idade_min . '-' . $categoria->idade_max;
        })->map(function ($grupo) {
            $primeira = $grupo->first();

            return [
                'label' => $this->formatarFaixaEtaria($primeira->idade_min, $primeira->idade_max),
                'categorias' => $grupo->sortBy([
                    ['tipo', 'asc'],
                    ['sexo', 'asc'],
                    ['faixa_inicial', 'asc'],
                ])->values(),
            ];
        });

        return view('inscricoes.publica', [
            'categoriasAgrupadas' => $categoriasAgrupadas,
            'faixas' => $this->faixas,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dojo_nome' => ['required', 'string', 'max:255'],
            'sensei_nome' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'comprovante' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $categoriasInput = $request->input('categorias', []);
        $atletasParaSalvar = [];

        foreach ($categoriasInput as $categoriaId => $dadosCategoria) {
            if (empty($dadosCategoria['atletas']) || !is_array($dadosCategoria['atletas'])) {
                continue;
            }

            foreach ($dadosCategoria['atletas'] as $atleta) {
                $nome = trim($atleta['nome_completo'] ?? '');
                $dataNascimento = trim($atleta['data_nascimento'] ?? '');
                $sexo = trim($atleta['sexo'] ?? '');
                $faixa = trim($atleta['faixa'] ?? '');

                if ($nome === '' && $dataNascimento === '' && $sexo === '' && $faixa === '') {
                    continue;
                }

                $atletasParaSalvar[] = [
                    'categoria_id' => (int) $categoriaId,
                    'nome_completo' => $nome,
                    'data_nascimento' => $dataNascimento,
                    'sexo' => $sexo,
                    'faixa' => $faixa,
                ];
            }
        }

        if (count($atletasParaSalvar) === 0) {
            throw ValidationException::withMessages([
                'categorias' => 'Adicione pelo menos um atleta em alguma categoria.',
            ]);
        }

        foreach ($atletasParaSalvar as $index => $atleta) {
            $validator = validator($atleta, [
                'categoria_id' => ['required', 'exists:categorias,id'],
                'nome_completo' => ['required', 'string', 'max:255'],
                'data_nascimento' => ['required', 'date'],
                'sexo' => ['required', 'in:M,F'],
                'faixa' => ['required', 'in:' . implode(',', $this->faixas)],
            ], [], [
                'nome_completo' => 'nome completo do atleta #' . ($index + 1),
                'data_nascimento' => 'data de nascimento do atleta #' . ($index + 1),
                'sexo' => 'sexo do atleta #' . ($index + 1),
                'faixa' => 'faixa do atleta #' . ($index + 1),
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }
        }

        DB::beginTransaction();

        try {
            $comprovantePath = $request->file('comprovante')->store('comprovantes', 'public');

            $inscricao = Inscricao::create([
                'dojo_nome' => $request->dojo_nome,
                'sensei_nome' => $request->sensei_nome,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'comprovante' => $comprovantePath,
                'status' => 'pendente',
                'total_atletas' => count($atletasParaSalvar),
                'observacoes' => null,
            ]);

            foreach ($atletasParaSalvar as $atletaData) {
                $categoria = Categoria::findOrFail($atletaData['categoria_id']);

                $this->validarAtletaNaCategoria($atletaData, $categoria);

                Atleta::create([
                    'inscricao_id' => $inscricao->id,
                    'categoria_id' => $categoria->id,
                    'nome_completo' => $atletaData['nome_completo'],
                    'data_nascimento' => $atletaData['data_nascimento'],
                    'sexo' => $atletaData['sexo'],
                    'faixa' => $atletaData['faixa'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('inscricao.success')
                ->with('success', 'Inscrição realizada com sucesso.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (isset($comprovantePath) && Storage::disk('public')->exists($comprovantePath)) {
                Storage::disk('public')->delete($comprovantePath);
            }

            if ($e instanceof ValidationException) {
                throw $e;
            }

            return back()
                ->withInput()
                ->with('error', 'Não foi possível concluir a inscrição. Tente novamente.');
        }
    }

    public function success()
    {
        return view('inscricoes.sucesso');
    }

    private function validarAtletaNaCategoria(array $atletaData, Categoria $categoria): void
    {
        $idade = Carbon::parse($atletaData['data_nascimento'])->age;

        if ($idade < $categoria->idade_min || $idade > $categoria->idade_max) {
            throw ValidationException::withMessages([
                'categorias' => ["O atleta {$atletaData['nome_completo']} não se enquadra na idade da categoria {$categoria->nome}."],
            ]);
        }

        if ($atletaData['sexo'] !== $categoria->sexo) {
            throw ValidationException::withMessages([
                'categorias' => ["O atleta {$atletaData['nome_completo']} não se enquadra no sexo da categoria {$categoria->nome}."],
            ]);
        }

        $ordem = array_flip($this->faixas);
        $faixaAtleta = $ordem[$atletaData['faixa']] ?? null;
        $faixaInicial = $ordem[$categoria->faixa_inicial] ?? null;
        $faixaFinal = $ordem[$categoria->faixa_final] ?? null;

        if ($faixaAtleta === null || $faixaInicial === null || $faixaFinal === null) {
            throw ValidationException::withMessages([
                'categorias' => ["Faixa inválida para o atleta {$atletaData['nome_completo']}."],
            ]);
        }

        if ($faixaAtleta < $faixaInicial || $faixaAtleta > $faixaFinal) {
            throw ValidationException::withMessages([
                'categorias' => ["O atleta {$atletaData['nome_completo']} não se enquadra na faixa da categoria {$categoria->nome}."],
            ]);
        }
    }

    private function formatarFaixaEtaria(int $idadeMin, int $idadeMax): string
    {
        if ($idadeMax === 99) {
            return "{$idadeMin} anos acima";
        }

        if ($idadeMin === 0) {
            return "Até {$idadeMax} anos";
        }

        if ($idadeMin === $idadeMax) {
            return "{$idadeMin} anos";
        }

        return "{$idadeMin} a {$idadeMax} anos";
    }
}
