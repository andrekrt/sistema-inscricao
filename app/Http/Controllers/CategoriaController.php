<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
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
        'preta'
    ];

    private array $tipos = [
        'fukugo' => 'Fukugo',
        'kata' => 'Kata',
        'kumite' => 'Kumite',
        'tira_fita' => 'Tira Fita',
        'kihon_ippon' => 'Kihon Ippon'
    ];

    private array $especiais = [
        'pcd' => 'PDC',
        'master' => 'Master'
    ];

    private array $tiposDisputa = [
        'individual' => 'Individual',
        'equipe' => 'Equipe',
    ];

    public function index()
    {
        $categorias = Categoria::orderBy('tipo')
            ->orderBy('idade_min')
            ->orderBy('sexo')
            ->get();

        return view('categorias.index', [
            'categorias' => $categorias,
            'tipos' => $this->tipos,
            'especiais' => $this->especiais,
        ]);
    }

    public function create()
    {
        return view('categorias.create', [
            'faixas' => $this->faixas,
            'tipos' => $this->tipos,
            'especiais' => $this->especiais,
            'tiposDisputa' => $this->tiposDisputa,
        ]);
    }

    public function store(Request $request)
    {

        $dados = $this->validarCategoria($request);

        // if ($dados['tipo_disputa'] === 'equipe') {
        //     if (empty($dados['min_atletas_equipe']) || empty($dados['max_atletas_equipe'])) {
        //         return back()
        //             ->withInput()
        //             ->withErrors([
        //                 'min_atletas_equipe' => 'Informe o mínimo e o máximo de atletas para categoria de equipe.',
        //             ]);
        //     }

        //     if ($dados['min_atletas_equipe'] > $dados['max_atletas_equipe']) {
        //         return back()
        //             ->withInput()
        //             ->withErrors([
        //                 'max_atletas_equipe' => 'O máximo de atletas deve ser maior ou igual ao mínimo.',
        //             ]);
        //     }
        // } else {
        //     $dados['min_atletas_equipe'] = null;
        //     $dados['max_atletas_equipe'] = null;
        // }

        Categoria::create([
            'tipo' => $dados['tipo'],
            'tipo_disputa' => $dados['tipo_disputa'],
            'nome' => $dados['nome'],
            'idade_min' => $dados['idade_min'],
            'idade_max' => $dados['idade_max'],
            'sexo' => $dados['sexo'],
            'faixa_inicial' => $dados['faixa_inicial'],
            'faixa_final' => $dados['faixa_final'],
            'especial' => $dados['especial'] ?: null,
            'min_atletas_equipe' => 3,
            'max_atletas_equipe' => 4,
            'ativo' => $request->boolean('ativo'),
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria cadastrada com sucesso!');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', [
            'categoria' => $categoria,
            'faixas' => $this->faixas,
            'tipos' => $this->tipos,
            'especiais' => $this->especiais,
            'tiposDisputa' => $this->tiposDisputa,
        ]);
    }

    public function update(Request $request, Categoria $categoria)
    {

        $dados = $this->validarCategoria($request);

        // if ($dados['tipo_disputa'] === 'equipe') {
        //     if (empty($dados['min_atletas_equipe']) || empty($dados['max_atletas_equipe'])) {
        //         return back()
        //             ->withInput()
        //             ->withErrors([
        //                 'min_atletas_equipe' => 'Informe o mínimo e o máximo de atletas para categoria de equipe.',
        //             ]);
        //     }

        //     if ($dados['min_atletas_equipe'] > $dados['max_atletas_equipe']) {
        //         return back()
        //             ->withInput()
        //             ->withErrors([
        //                 'max_atletas_equipe' => 'O máximo de atletas deve ser maior ou igual ao mínimo.',
        //             ]);
        //     }
        // } else {
        //     $dados['min_atletas_equipe'] = null;
        //     $dados['max_atletas_equipe'] = null;
        // }

        $categoria->update([
            'tipo' => $dados['tipo'],
            'tipo_disputa' => $dados['tipo_disputa'],
            'nome' => $dados['nome'],
            'idade_min' => $dados['idade_min'],
            'idade_max' => $dados['idade_max'],
            'sexo' => $dados['sexo'],
            'faixa_inicial' => $dados['faixa_inicial'],
            'faixa_final' => $dados['faixa_final'],
            'especial' => $dados['especial'] ?? null,
            'min_atletas_equipe' => 3,
            'max_atletas_equipe' => 4,
            'tipo_disputa' => $dados['tipo_disputa'],
            'ativo' => $request->boolean('ativo'),
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria atualizada!');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria excluída!');
    }

    private function validarCategoria(Request $request): array
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'string'],
            'tipo_disputa' => ['required', 'in:individual,equipe'],
            'idade_min' => ['required', 'integer', 'min:0'],
            'idade_max' => ['required', 'integer', 'min:0', 'gte:idade_min'],
            'sexo' => ['required', 'in:M,F'],
            'faixa_inicial' => ['required', 'string'],
            'faixa_final' => ['required', 'string'],
            'especial' => ['nullable', 'string'],
            // 'min_atletas_equipe' => ['nullable', 'integer', 'min:1'],
            // 'max_atletas_equipe' => ['nullable', 'integer', 'min:1'],
            'ativo' => ['nullable', 'boolean'],
        ]);

        $ordem = array_flip($this->faixas);

        if ($ordem[$dados['faixa_inicial']] > $ordem[$dados['faixa_final']]) {
            return back()
                ->withErrors(['faixa_final' => 'A faixa final deve ser igual ou superior à faixa inicial.'])
                ->withInput()
                ->throwResponse();
        }

        return $dados;
    }
}
