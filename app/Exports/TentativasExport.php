<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TentativasExport implements FromCollection, WithColumnWidths, WithStrictNullComparison, WithStyles
{
    protected $tentativa;

    // Define o comprimento das células do ficheiro Excel
    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 65,
            'C' => 65,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    function __construct($tentativa)
    {
        $this->tentativa = $tentativa;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // $nome = $this->tentativa->first()->Tentativa->User->name;
        // $tipoUser = $this->tentativa->first()->Tentativa->usertipo;
        $arrTentativa = [];
        // 1ª LINHA
        array_push($arrTentativa, ['CATEGORIAS', 'PERGUNTAS', 'RESPOSTAS', 'PONTOS']);
        foreach ($this->tentativa as $categoria) {
            $nomeCateg = $categoria->categoria;
            // $media = $categoria->media;
            foreach ($categoria->Respondidas as $respondidas) {
                $pergunta = $respondidas->pergunta;
                $resposta = $respondidas->resposta;
                $pontos = $respondidas->pontos;
                // 2ª LINHA
                array_push($arrTentativa, [$nomeCateg, $pergunta, $resposta, $pontos]);
            }
            array_push($arrTentativa, ['']);
        }
        return new Collection(
            $arrTentativa
        );
    }
}
