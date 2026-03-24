<?php

namespace App\Exports;

use App\Models\Atleta;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InscricoesPorCategoriaExport implements FromCollection, ShouldAutoSize, WithStyles
{
    private array $headerRows = [];

    public function collection(): Collection
    {
        $rows = collect();

        $atletas = Atleta::with(['categoria', 'inscricao'])
            ->get()
            ->sortBy([
                fn ($a, $b) => strcmp($a->categoria->nome ?? '', $b->categoria->nome ?? ''),
                fn ($a, $b) => strcmp($a->nome_completo ?? '', $b->nome_completo ?? ''),
            ])
            ->groupBy(fn ($atleta) => $atleta->categoria->nome ?? 'Sem categoria');

        $linhaAtual = 1;

        foreach ($atletas as $categoriaNome => $grupoAtletas) {
            // Título da categoria
            $this->headerRows[] = $linhaAtual;
            $rows->push([$categoriaNome]);
            $linhaAtual++;

            // Cabeçalho
            $this->headerRows[] = $linhaAtual;
            $rows->push([
                'Nº',
                'Nome do atleta',
                'Data nascimento',
                'Idade',
                'Faixa',
                'Sexo',
                'Dojo',
                'Sensei',
                'Telefone',
            ]);
            $linhaAtual++;

            $contador = 1;

            foreach ($grupoAtletas as $atleta) {
                $dataNascimento = Carbon::parse($atleta->data_nascimento);
                $idade = $dataNascimento->age;

                $rows->push([
                    $contador,
                    $atleta->nome_completo,
                    $dataNascimento->format('d/m/Y'),
                    $idade,
                    ucfirst($atleta->faixa),
                    $atleta->sexo === 'M' ? 'Masculino' : 'Feminino',
                    $atleta->inscricao->dojo_nome ?? '',
                    $atleta->inscricao->sensei_nome ?? '',
                    $atleta->inscricao->telefone ?? '',
                ]);

                $contador++;
                $linhaAtual++;
            }

            // Espaço entre categorias
            $rows->push([]);
            $linhaAtual++;
        }

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        $styles = [];

        foreach ($this->headerRows as $index => $row) {
            // Título da categoria
            if ($index % 2 === 0) {
                $sheet->mergeCells("A{$row}:I{$row}");

                $styles[$row] = [
                    'font' => [
                        'bold' => true,
                        'size' => 13,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => '7A0D0D'],
                    ],
                ];
            }
            // Cabeçalho da tabela
            else {
                $styles[$row] = [
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => 'E9ECEF'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['rgb' => 'CCCCCC'],
                        ],
                    ],
                ];
            }
        }

        return $styles;
    }
}
