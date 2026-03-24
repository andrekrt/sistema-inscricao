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
        ]);
    }

    public function store(Request $request)
    {

        $dados = $this->validarCategoria($request);

        Categoria::create([
            'tipo' => $dados['tipo'],
            'nome' => $dados['nome'],
            'idade_min' => $dados['idade_min'],
            'idade_max' => $dados['idade_max'],
            'sexo' => $dados['sexo'],
            'faixa_inicial' => $dados['faixa_inicial'],
            'faixa_final' => $dados['faixa_final'],
            'especial' => $dados['especial'] ?: null,
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

        ]);
    }

    public function update(Request $request, Categoria $categoria)
    {

        $dados = $this->validarCategoria($request);

        $categoria->update([
            'tipo' => $dados['tipo'],
            'nome' => $dados['nome'],
            'idade_min' => $dados['idade_min'],
            'idade_max' => $dados['idade_max'],
            'sexo' => $dados['sexo'],
            'faixa_inicial' => $dados['faixa_inicial'],
            'faixa_final' => $dados['faixa_final'],
            'especial' => $dados['especial'] ?? null,
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
            'tipo' => ['required', Rule::in(array_keys($this->tipos))],
            'nome' => ['required', 'string', 'max:255'],
            'idade_min' => ['required', 'integer', 'min:0', 'max:99'],
            'idade_max' => ['required', 'integer', 'min:0', 'max:99', 'gte:idade_min'],
            'sexo' => ['required', Rule::in(['M', 'F'])],
            'faixa_inicial' => ['required', Rule::in($this->faixas)],
            'faixa_final' => ['required', Rule::in($this->faixas)],
            'especial' => ['nullable', Rule::in(array_keys($this->especiais))],
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
