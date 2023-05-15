<?php

namespace App\Imports;

use App\Models\Categorias;
use App\Models\Questoes;
use App\Models\Respostas;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DadosImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        //colocar em array
        $excel = [];
        foreach ($rows as $row) {
            if ($row[1] == null && $row[0] == null) {
            } else {
                array_push($excel, [$row[0], $row[1], $row[2]]);
            };
        }
        array_push($excel, '#');

        //separar por Categorias em arrays
        $allDadosPorCateg = [];
        $eachDados = [];
        foreach ($excel as $linha) {
            if (Str::contains($linha[0], '#')) {
                if (count($eachDados) != 0) {
                    array_push($allDadosPorCateg, $eachDados);
                    $eachDados = [];
                }
            }
            array_push($eachDados, $linha);
        }

        //Lê os dados do Ficheiro Excel e coloca-os na BD
        $j = count(Categorias::all());
        foreach ($allDadosPorCateg as $cadaCategoria) {
            $q = 1;
            $r = 1;
            $j++;
            for ($i = 0; $i < count($cadaCategoria); $i++) {
                // Cada categoria está separada por '#'
                if (Str::contains($cadaCategoria[$i][0], '#')) {
                    if (!Categorias::where('nome', $cadaCategoria[$i][1])->get()->isEmpty()) {
                        // Se existir categoria com nome igual apaga a existente e cria uma Completamente Nova
                        if ($cadaCategoria[$i][1] == Categorias::where('nome', $cadaCategoria[$i][1])->get()[0]->nome) {
                            $catRepetida = Categorias::where('nome', $cadaCategoria[$i][1])->get()[0];
                            $questoesCatRepetida = Questoes::all()->where('categoria', $catRepetida->id);
                            foreach ($questoesCatRepetida as $questao) {
                                $respostas = $questao->Respostas;
                                foreach ($respostas as $resposta) {
                                    $resposta->delete();
                                }
                                $questao->Tipos()->detach();
                                $questao->delete();
                            }
                            $catRepetida->delete();
                        }
                    }
                    $novaCategoria = new Categorias();
                    $novaCategoria->nome = $cadaCategoria[$i][1];
                    $novaCategoria->ordem = $j;
                    $novaCategoria->save();
                }
                // Cada Questão está separada por 'Pergunta:'
                if (Str::contains($cadaCategoria[$i][0], 'Pergunta:')) {
                    $novaQuestao = new Questoes();
                    $novaQuestao->nome = $cadaCategoria[$i][1];
                    if ($cadaCategoria[$i][2] != null) {
                        $novaQuestao->info = $cadaCategoria[$i][2];
                    }
                    $novaQuestao->obrigatoria = 0;
                    $novaQuestao->categoria = $novaCategoria->id;
                    $novaQuestao->ordem = $q++;
                    $novaQuestao->save();
                    $novaQuestao->Tipos()->attach(1);
                    $r = 1;
                }
                // Cada Resposta está separada por '*'
                if (Str::contains($cadaCategoria[$i][1], '*')) {
                    $retirarString = ltrim($cadaCategoria[$i][1], '*');
                    $novaResposta = new Respostas();
                    $retirarString = ucfirst($retirarString);
                    $novaResposta->nome = $retirarString;
                    if ($cadaCategoria[$i][0] != null) {
                        $novaResposta->pontos = $cadaCategoria[$i][0];
                    } else {
                        $novaResposta->pontos = 0;
                    }
                    $novaResposta->ordem = $r++;
                    $novaResposta->questao = $novaQuestao->id;
                    $novaResposta->save();
                }
            }
        }
    }
}
