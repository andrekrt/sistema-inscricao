<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run():void
    {
        $categorias = [
            // FUKUGO
            ['tipo' => 'fukugo', 'nome' => 'Fukugo Feminino - 16 e 17 anos - verde acima', 'idade_min' => 16, 'idade_max' => 17, 'sexo' => 'F', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'fukugo', 'nome' => 'Fukugo Masculino - 16 e 17 anos - verde acima', 'idade_min' => 16, 'idade_max' => 17, 'sexo' => 'M', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'fukugo', 'nome' => 'Fukugo Masculino - 18 a 21 anos - verde acima', 'idade_min' => 18, 'idade_max' => 21, 'sexo' => 'M', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'fukugo', 'nome' => 'Fukugo Masculino - 22 a 40 anos - marrom e preta', 'idade_min' => 22, 'idade_max' => 40, 'sexo' => 'M', 'faixa_inicial' => 'marrom', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],

            // KATA FEMININO
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - até 7 anos - branca a azul', 'idade_min' => 0, 'idade_max' => 7, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 8 e 9 anos - branca a azul', 'idade_min' => 8, 'idade_max' => 9, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 8 e 9 anos - amarela acima', 'idade_min' => 8, 'idade_max' => 9, 'sexo' => 'F', 'faixa_inicial' => 'amarela', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 10 e 11 anos - branca a azul', 'idade_min' => 10, 'idade_max' => 11, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 10 e 11 anos - amarela acima', 'idade_min' => 10, 'idade_max' => 11, 'sexo' => 'F', 'faixa_inicial' => 'amarela', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 12 e 13 anos - branca a amarela', 'idade_min' => 12, 'idade_max' => 13, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 14 e 15 anos - branca a amarela', 'idade_min' => 14, 'idade_max' => 15, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 14 e 15 anos - laranja acima', 'idade_min' => 14, 'idade_max' => 15, 'sexo' => 'F', 'faixa_inicial' => 'laranja', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 16 e 17 anos - verde acima', 'idade_min' => 16, 'idade_max' => 17, 'sexo' => 'F', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 17 anos acima - branca a laranja', 'idade_min' => 17, 'idade_max' => 99, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'laranja', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 17 anos acima - verde e roxa', 'idade_min' => 17, 'idade_max' => 99, 'sexo' => 'F', 'faixa_inicial' => 'verde', 'faixa_final' => 'roxa', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual feminino - 18 acima - verde acima', 'idade_min' => 18, 'idade_max' => 99, 'sexo' => 'F', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],

            // KATA MASCULINO
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - até 7 anos - branca a azul', 'idade_min' => 0, 'idade_max' => 7, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - até 7 anos - amarela acima', 'idade_min' => 0, 'idade_max' => 7, 'sexo' => 'M', 'faixa_inicial' => 'amarela', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 8 a 10 anos - branca a amarela (PCD)', 'idade_min' => 8, 'idade_max' => 10, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => 'pcd', 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 8 a 9 anos - branca a azul', 'idade_min' => 8, 'idade_max' => 9, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 8 a 9 anos - amarela acima', 'idade_min' => 8, 'idade_max' => 9, 'sexo' => 'M', 'faixa_inicial' => 'amarela', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 10 a 11 anos - branca a azul', 'idade_min' => 10, 'idade_max' => 11, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 10 a 11 anos - amarela acima', 'idade_min' => 10, 'idade_max' => 11, 'sexo' => 'M', 'faixa_inicial' => 'amarela', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 12 e 13 anos - branca a amarela', 'idade_min' => 12, 'idade_max' => 13, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 12 e 13 anos - laranja acima', 'idade_min' => 12, 'idade_max' => 13, 'sexo' => 'M', 'faixa_inicial' => 'laranja', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 14 e 15 anos - branca a amarela', 'idade_min' => 14, 'idade_max' => 15, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 14 e 15 anos - laranja acima', 'idade_min' => 14, 'idade_max' => 15, 'sexo' => 'M', 'faixa_inicial' => 'laranja', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 16 e 17 anos - branca a amarela', 'idade_min' => 16, 'idade_max' => 17, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 16 e 17 anos - laranja acima', 'idade_min' => 16, 'idade_max' => 17, 'sexo' => 'M', 'faixa_inicial' => 'laranja', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 18 a 21 anos - branca a laranja', 'idade_min' => 18, 'idade_max' => 21, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'laranja', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 18 a 21 anos - verde acima', 'idade_min' => 18, 'idade_max' => 21, 'sexo' => 'M', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 18 acima - verde acima (PCD)', 'idade_min' => 18, 'idade_max' => 99, 'sexo' => 'M', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => 'pcd', 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 22 a 40 anos - branca a laranja', 'idade_min' => 22, 'idade_max' => 40, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'laranja', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 22 a 40 anos - verde e roxa', 'idade_min' => 22, 'idade_max' => 40, 'sexo' => 'M', 'faixa_inicial' => 'verde', 'faixa_final' => 'roxa', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - 22 a 40 anos - marrom e preta', 'idade_min' => 22, 'idade_max' => 40, 'sexo' => 'M', 'faixa_inicial' => 'marrom', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kata', 'nome' => 'Kata individual masculino - Master - roxa a preta', 'idade_min' => 41, 'idade_max' => 99, 'sexo' => 'M', 'faixa_inicial' => 'roxa', 'faixa_final' => 'preta', 'especial' => 'master', 'ativo' => true],

            // KUMITE FEMININO / TIRA FITA / KIHON IPPON
            ['tipo' => 'tira_fita', 'nome' => 'Tira fita feminino - até 7 anos - branca a azul', 'idade_min' => 0, 'idade_max' => 7, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'tira_fita', 'nome' => 'Tira fita feminino - 8 a 9 anos - branca a azul', 'idade_min' => 8, 'idade_max' => 9, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kihon_ippon', 'nome' => 'Kihon ippon feminino - 8 a 9 anos - amarela acima', 'idade_min' => 8, 'idade_max' => 9, 'sexo' => 'F', 'faixa_inicial' => 'amarela', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kihon_ippon', 'nome' => 'Kihon ippon feminino - 10 a 11 anos - branca a azul', 'idade_min' => 10, 'idade_max' => 11, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kihon_ippon', 'nome' => 'Kihon ippon feminino - 10 a 11 anos - amarela acima', 'idade_min' => 10, 'idade_max' => 11, 'sexo' => 'F', 'faixa_inicial' => 'amarela', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kihon_ippon', 'nome' => 'Kihon ippon feminino - 12 a 13 anos - branca a amarela', 'idade_min' => 12, 'idade_max' => 13, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual feminino - 14 e 15 anos - laranja acima', 'idade_min' => 14, 'idade_max' => 15, 'sexo' => 'F', 'faixa_inicial' => 'laranja', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual feminino - 16 e 17 anos - verde acima', 'idade_min' => 16, 'idade_max' => 17, 'sexo' => 'F', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual feminino - 17 anos acima - branca a laranja', 'idade_min' => 17, 'idade_max' => 99, 'sexo' => 'F', 'faixa_inicial' => 'branca', 'faixa_final' => 'laranja', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual feminino - 17 anos acima - verde e roxa', 'idade_min' => 17, 'idade_max' => 99, 'sexo' => 'F', 'faixa_inicial' => 'verde', 'faixa_final' => 'roxa', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual feminino - 18 acima - verde acima', 'idade_min' => 18, 'idade_max' => 99, 'sexo' => 'F', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],

            // KUMITE MASCULINO / TIRA FITA / KIHON IPPON
            ['tipo' => 'tira_fita', 'nome' => 'Tira fita masculino - até 5 anos - branca acima', 'idade_min' => 0, 'idade_max' => 5, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'tira_fita', 'nome' => 'Tira fita masculino - 6 e 7 anos - branca acima', 'idade_min' => 6, 'idade_max' => 7, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'tira_fita', 'nome' => 'Tira fita masculino - 8 a 9 anos - branca a azul', 'idade_min' => 8, 'idade_max' => 9, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'tira_fita', 'nome' => 'Tira fita masculino - 8 a 10 anos - branca a amarela (PCD)', 'idade_min' => 8, 'idade_max' => 10, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => 'pcd', 'ativo' => true],
            ['tipo' => 'kihon_ippon', 'nome' => 'Kihon ippon masculino - 8 a 9 anos - amarela acima', 'idade_min' => 8, 'idade_max' => 9, 'sexo' => 'M', 'faixa_inicial' => 'amarela', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kihon_ippon', 'nome' => 'Kihon ippon masculino - 10 a 11 anos - branca a azul', 'idade_min' => 10, 'idade_max' => 11, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'azul', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kihon_ippon', 'nome' => 'Kihon ippon masculino - 10 a 11 anos - amarela acima', 'idade_min' => 10, 'idade_max' => 11, 'sexo' => 'M', 'faixa_inicial' => 'amarela', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kihon_ippon', 'nome' => 'Kihon ippon masculino - 12 e 13 anos - branca a amarela', 'idade_min' => 12, 'idade_max' => 13, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kihon_ippon', 'nome' => 'Kihon ippon masculino - 18 acima - verde acima (PCD)', 'idade_min' => 18, 'idade_max' => 99, 'sexo' => 'M', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => 'pcd', 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual masculino - 12 e 13 anos - laranja acima', 'idade_min' => 12, 'idade_max' => 13, 'sexo' => 'M', 'faixa_inicial' => 'laranja', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual masculino - 14 e 15 anos - branca a amarela', 'idade_min' => 14, 'idade_max' => 15, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'amarela', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual masculino - 14 e 15 anos - laranja acima', 'idade_min' => 14, 'idade_max' => 15, 'sexo' => 'M', 'faixa_inicial' => 'laranja', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual masculino - 16 e 17 anos - laranja acima', 'idade_min' => 16, 'idade_max' => 17, 'sexo' => 'M', 'faixa_inicial' => 'laranja', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual masculino - 18 a 21 anos - branca a laranja', 'idade_min' => 18, 'idade_max' => 21, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'laranja', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual masculino - 18 a 21 anos - verde acima', 'idade_min' => 18, 'idade_max' => 21, 'sexo' => 'M', 'faixa_inicial' => 'verde', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual masculino - 22 a 40 anos - branca a laranja', 'idade_min' => 22, 'idade_max' => 40, 'sexo' => 'M', 'faixa_inicial' => 'branca', 'faixa_final' => 'laranja', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual masculino - 22 a 40 anos - verde e roxa', 'idade_min' => 22, 'idade_max' => 40, 'sexo' => 'M', 'faixa_inicial' => 'verde', 'faixa_final' => 'roxa', 'especial' => null, 'ativo' => true],
            ['tipo' => 'kumite', 'nome' => 'Kumite individual masculino - 22 a 40 anos - marrom e preta', 'idade_min' => 22, 'idade_max' => 40, 'sexo' => 'M', 'faixa_inicial' => 'marrom', 'faixa_final' => 'preta', 'especial' => null, 'ativo' => true],
        ];

        foreach ($categorias as $categoria) {
            Categoria::updateOrCreate($categoria);
        }
    }
}
