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
use Illuminate\Support\Str;
use App\Notifications\InscricaoRealizadaNotification;
use App\Services\N8nWebhookService;
use App\Support\EmailNotifiable;
use Illuminate\Support\Facades\Notification;
use App\Models\Equipe;

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
            ->orderBy('tipo_disputa')
            ->orderBy('idade_min')
            ->orderBy('idade_max')
            ->orderBy('tipo')
            ->orderBy('sexo')
            ->get();

        $categoriasIndividuais = $categorias
            ->where('tipo_disputa', 'individual');

        $categoriasEquipe = $categorias
            ->where('tipo_disputa', 'equipe')
            ->values();

        $categoriasIndividuaisAgrupadas = $categoriasIndividuais
            ->groupBy(function ($categoria) {
                return $categoria->idade_min . '-' . $categoria->idade_max;
            })
            ->map(function ($grupo) {
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
            'categoriasIndividuaisAgrupadas' => $categoriasIndividuaisAgrupadas,
            'categoriasEquipe' => $categoriasEquipe,
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
        $equipesInput = $request->input('equipes', []);

        $atletasParaSalvar = [];
        $equipesParaSalvar = [];

        /*
    |--------------------------------------------------------------------------
    | Monta equipes para salvar
    |--------------------------------------------------------------------------
    */
        foreach ($equipesInput as $categoriaId => $dadosEquipe) {
            $categoria = Categoria::find($categoriaId);

            if (!$categoria || $categoria->tipo_disputa !== 'equipe') {
                continue;
            }

            $nomesBrutos = $dadosEquipe['nomes_atletas'] ?? '';

            $nomesArray = collect(preg_split('/\r\n|\r|\n/', $nomesBrutos))
                ->map(fn($nome) => trim($nome))
                ->filter()
                ->values()
                ->toArray();

            if (count($nomesArray) === 0) {
                continue;
            }

            $quantidade = count($nomesArray);

            if ($quantidade < $categoria->min_atletas_equipe || $quantidade > $categoria->max_atletas_equipe) {
                throw ValidationException::withMessages([
                    "equipes.$categoriaId.nomes_atletas" =>
                    "A categoria {$categoria->nome} exige entre {$categoria->min_atletas_equipe} e {$categoria->max_atletas_equipe} atletas.",
                ]);
            }

            $equipesParaSalvar[] = [
                'categoria_id' => (int) $categoriaId,
                'nomes_atletas' => implode(PHP_EOL, $nomesArray),
                'quantidade_atletas' => $quantidade,
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | Monta atletas individuais para salvar
    |--------------------------------------------------------------------------
    */
        foreach ($categoriasInput as $categoriaId => $dadosCategoria) {
            $categoria = Categoria::find($categoriaId);

            if (!$categoria || $categoria->tipo_disputa !== 'individual') {
                continue;
            }

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

        /*
    |--------------------------------------------------------------------------
    | Deve existir pelo menos um atleta individual ou uma equipe
    |--------------------------------------------------------------------------
    */
        if (count($atletasParaSalvar) === 0 && count($equipesParaSalvar) === 0) {
            throw ValidationException::withMessages([
                'categorias' => 'Adicione pelo menos um atleta individual ou uma equipe.',
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Validação dos atletas individuais
    |--------------------------------------------------------------------------
    */
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

            $totalAtletas = count($atletasParaSalvar) + collect($equipesParaSalvar)->sum('quantidade_atletas');

            $inscricao = Inscricao::create([
                'dojo_nome' => $request->dojo_nome,
                'sensei_nome' => $request->sensei_nome,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'comprovante' => $comprovantePath,
                'token_edicao' => Str::random(64),
                'edicao_liberada' => 1,
                'edicao_ate' => now()->addDays(30),
                'status' => 'pendente',
                'total_atletas' => $totalAtletas,
                'observacoes' => null,
            ]);

            $inscricao->comprovantes()->create([
                'arquivo' => $comprovantePath,
                'nome_original' => $request->file('comprovante')->getClientOriginalName(),
            ]);

            /*
        |--------------------------------------------------------------------------
        | Salva atletas individuais
        |--------------------------------------------------------------------------
        */
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

            /*
        |--------------------------------------------------------------------------
        | Salva equipes
        |--------------------------------------------------------------------------
        */
            foreach ($equipesParaSalvar as $equipeData) {
                Equipe::create([
                    'inscricao_id' => $inscricao->id,
                    'categoria_id' => $equipeData['categoria_id'],
                    'nomes_atletas' => $equipeData['nomes_atletas'],
                    'quantidade_atletas' => $equipeData['quantidade_atletas'],
                ]);
            }

            DB::commit();

            if ($inscricao->email) {
                Notification::send(
                    new EmailNotifiable($inscricao->email),
                    new InscricaoRealizadaNotification($inscricao)
                );
            }

            app(N8nWebhookService::class)->enviarInscricaoRealizada($inscricao);

            return redirect()
                ->route('inscricao.success', [
                    'id' => $inscricao->id,
                    'token' => $inscricao->token_edicao,
                ])
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

    public function success($id, $token)
    {
        $inscricao = Inscricao::findOrFail($id);

        if ($inscricao->token_edicao !== $token) {
            abort(403, 'Link inválido.');
        }

        return view('inscricoes.sucesso', [
            'inscricao' => $inscricao,
            'linkEdicao' => route('inscricao.edit.token', [
                'id' => $inscricao->id,
                'token' => $inscricao->token_edicao,
            ]),
        ]);
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

    public function editByToken($id, $token)
    {
        $inscricao = Inscricao::with([
            'comprovantes',
            'atletas.categoria',
            'equipes.categoria',
        ])->findOrFail($id);

        if ($inscricao->token_edicao !== $token) {
            abort(403, 'Link de edição inválido.');
        }

        if (!$inscricao->edicao_liberada) {
            abort(403, 'A edição desta inscrição está bloqueada.');
        }

        if ($inscricao->edicao_ate && now()->greaterThan($inscricao->edicao_ate)) {
            abort(403, 'O prazo para editar esta inscrição expirou.');
        }

        $categorias = Categoria::where('ativo', true)
            ->orderBy('tipo_disputa')
            ->orderBy('idade_min')
            ->orderBy('idade_max')
            ->orderBy('tipo')
            ->orderBy('sexo')
            ->get();

        $categoriasIndividuais = $categorias
            ->where('tipo_disputa', 'individual');

        $categoriasEquipe = $categorias
            ->where('tipo_disputa', 'equipe')
            ->values();

        $categoriasIndividuaisAgrupadas = $categoriasIndividuais
            ->groupBy(function ($categoria) {
                return $categoria->idade_min . '-' . $categoria->idade_max;
            })
            ->map(function ($grupo) {
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

        $atletasPorCategoria = $inscricao->atletas->groupBy('categoria_id');
        $equipesPorCategoria = $inscricao->equipes->groupBy('categoria_id');

        return view('inscricoes.editar-publica', [
            'inscricao' => $inscricao,
            'categoriasIndividuaisAgrupadas' => $categoriasIndividuaisAgrupadas,
            'categoriasEquipe' => $categoriasEquipe,
            'atletasPorCategoria' => $atletasPorCategoria,
            'equipesPorCategoria' => $equipesPorCategoria,
            'faixas' => $this->faixas,
            'token' => $token,
        ]);
    }

    public function updateByToken(Request $request, $id, $token)
    {
        $inscricao = Inscricao::with(['atletas', 'equipes', 'comprovantes'])->findOrFail($id);

        if ($inscricao->token_edicao !== $token) {
            abort(403, 'Link de edição inválido.');
        }

        if (!$inscricao->edicao_liberada) {
            abort(403, 'A edição desta inscrição está bloqueada.');
        }

        if ($inscricao->edicao_ate && now()->greaterThan($inscricao->edicao_ate)) {
            abort(403, 'O prazo para editar esta inscrição expirou.');
        }

        $request->validate([
            'telefone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'novo_comprovante' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $categoriasInput = $request->input('categorias', []);
        $equipesInput = $request->input('equipes', []);

        $atletasParaSalvar = [];
        $equipesParaSalvar = [];

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

        foreach ($equipesInput as $categoriaId => $dadosEquipe) {
            $nomesAtletas = trim($dadosEquipe['nomes_atletas'] ?? '');

            if ($nomesAtletas === '') {
                continue;
            }

            $linhas = preg_split('/\r\n|\r|\n/', $nomesAtletas);
            $linhas = array_values(array_filter(array_map('trim', $linhas)));

            if (count($linhas) === 0) {
                continue;
            }

            $equipesParaSalvar[] = [
                'categoria_id' => (int) $categoriaId,
                'nomes_atletas' => implode("\n", $linhas),
                'quantidade_atletas' => count($linhas),
            ];
        }

        if (count($atletasParaSalvar) === 0 && count($equipesParaSalvar) === 0) {
            return back()
                ->withInput()
                ->withErrors(['categorias' => 'A inscrição deve ter pelo menos um atleta ou uma equipe.']);
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
                return back()->withInput()->withErrors($validator);
            }
        }

        foreach ($equipesParaSalvar as $index => $equipe) {
            $validator = validator($equipe, [
                'categoria_id' => ['required', 'exists:categorias,id'],
                'nomes_atletas' => ['required', 'string'],
                'quantidade_atletas' => ['required', 'integer', 'min:1'],
            ], [], [
                'nomes_atletas' => 'nomes dos atletas da equipe #' . ($index + 1),
                'quantidade_atletas' => 'quantidade de atletas da equipe #' . ($index + 1),
            ]);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }

            $categoria = Categoria::findOrFail($equipe['categoria_id']);

            if ($categoria->tipo_disputa !== 'equipe') {
                return back()
                    ->withInput()
                    ->withErrors(['equipes' => 'Uma das categorias de equipe é inválida.']);
            }

            if ($categoria->min_atletas_equipe && $equipe['quantidade_atletas'] < $categoria->min_atletas_equipe) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'equipes' => "A equipe da categoria {$categoria->nome} deve ter no mínimo {$categoria->min_atletas_equipe} atleta(s)."
                    ]);
            }

            if ($categoria->max_atletas_equipe && $equipe['quantidade_atletas'] > $categoria->max_atletas_equipe) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'equipes' => "A equipe da categoria {$categoria->nome} deve ter no máximo {$categoria->max_atletas_equipe} atleta(s)."
                    ]);
            }
        }

        DB::beginTransaction();

        try {
            $totalAtletas = count($atletasParaSalvar) + collect($equipesParaSalvar)->sum('quantidade_atletas');

            $inscricao->update([
                'telefone' => $request->telefone,
                'email' => $request->email,
                'total_atletas' => $totalAtletas,
            ]);

            $inscricao->atletas()->delete();
            $inscricao->equipes()->delete();

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

            foreach ($equipesParaSalvar as $equipeData) {
                $inscricao->equipes()->create([
                    'categoria_id' => $equipeData['categoria_id'],
                    'nomes_atletas' => $equipeData['nomes_atletas'],
                    'quantidade_atletas' => $equipeData['quantidade_atletas'],
                ]);
            }

            if ($request->hasFile('novo_comprovante')) {
                $novoComprovantePath = $request->file('novo_comprovante')->store('comprovantes', 'public');

                $inscricao->comprovantes()->create([
                    'arquivo' => $novoComprovantePath,
                    'nome_original' => $request->file('novo_comprovante')->getClientOriginalName(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('inscricao.edit.token', [
                    'id' => $inscricao->id,
                    'token' => $inscricao->token_edicao,
                ])
                ->with('success', 'Inscrição atualizada com sucesso.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Não foi possível atualizar a inscrição.');
        }
    }
}
