<?php

namespace App\Http\Controllers;

use PDF;
use QuickChart;
use Illuminate\Http\Request;

class PdfController extends DashboardController
{
    //criar PDF nos Resultados
    public function create(Request $request)
    {
        //Buscar categorias
        $respostas = request()->session()->get('respostas');
        $eachCat = [];
        foreach ($respostas as $resposta) {
            $idEachResp = $resposta->Questao->Categoria;
            array_push($eachCat, $idEachResp);
        }
        $eachCat = (array_unique($eachCat));

        $pontosPorCateg = request()->session()->get('pontosPorCateg');

        // array dos NOMES e IDS das Categorias Selecionadas
        $nomesCategsSelected = [];
        $mediaPorCateg = [];
        foreach ($eachCat as $categs) {
            $nomeCategs = $categs->nome;
            $idsCategs = $categs->id;
            array_push($nomesCategsSelected, $nomeCategs);
            array_push($mediaPorCateg, floor($pontosPorCateg[$idsCategs]));
        }

        //Ids das Categs por resposta
        $arrIdQuest = [];
        $contagem = [];
        for ($i = 0; $i < count($respostas); $i++) {
            $resposta = $respostas[$i]->Questao->Categoria->id;
            $contagem[$respostas[$i]->Questao->id] = $respostas[$i]->Questao->Categoria->id;
            array_push($arrIdQuest, $resposta);
        }

        //contar Questoes por Categoria
        $countQuests = array_count_values($contagem);

        // gráfico com no minimo 5 Pontas
        switch (count($nomesCategsSelected)) {
            case 1:
                array_push($nomesCategsSelected, '', '', '', '');
                break;
            case 2:
                array_push($nomesCategsSelected, '', '', '');
                break;
            case 3:
                array_push($nomesCategsSelected, '', '');
                break;
            case 4:
                array_push($nomesCategsSelected, '');
                break;
            default:
                break;
        }

        // Criar Url do Chart para enviar na Vista
        $chart = new QuickChart([
            'width' => 500,
            'height' => 300,
        ]);
        $chart->setConfig("{
            type: 'radar',
            data: {
                labels: " . json_encode($nomesCategsSelected)  . ",
                datasets: [{
                    data: " . json_encode($mediaPorCateg) . ",
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            display: false
                        },
                        suggestedMin: 0,
                        suggestedMax: 5
                    }
                }
            }
        }");
        $pngChart = $chart->getUrl();

        $pdf = PDF::loadView('pdf', compact('respostas', 'countQuests', 'pontosPorCateg', 'pngChart'));
        return $pdf->download('avaliacaoseguranca_resultados.pdf');
    }

    //enviar pdf para o controlador do Email
    public function toEmail()
    {
        //
        $respostas = request()->session()->get('respostas');
        $eachCat = [];
        foreach ($respostas as $resposta) {
            $idEachResp = $resposta->Questao->Categoria;
            array_push($eachCat, $idEachResp);
        }
        $eachCat = (array_unique($eachCat));

        $pontosPorCateg = request()->session()->get('pontosPorCateg');

        // array dos NOMES e IDS das Categorias Selecionadas
        $nomesCategsSelected = [];
        $mediaPorCateg = [];
        foreach ($eachCat as $categs) {
            $nomeCategs = $categs->nome;
            $idsCategs = $categs->id;
            array_push($nomesCategsSelected, $nomeCategs);
            array_push($mediaPorCateg, floor($pontosPorCateg[$idsCategs]));
        }
        $nomeCategSingle = $nomesCategsSelected;

        $arrIdQuest = [];
        for ($i = 0; $i < count($respostas); $i++) {
            $resposta = $respostas[$i]->Questao->Categoria->id;
            array_push($arrIdQuest, $resposta);
        }
        $countQuests = array_count_values($arrIdQuest);

        // no minimo um Pentágono no Chart
        switch (count($nomesCategsSelected)) {
            case 1:
                array_push($nomesCategsSelected, '', '', '', '');
                break;
            case 2:
                array_push($nomesCategsSelected, '', '', '');
                break;
            case 3:
                array_push($nomesCategsSelected, '', '');
                break;
            case 4:
                array_push($nomesCategsSelected, '');
                break;
            default:
                break;
        }

        // criar URL PNG do gráfico
        $chart = new QuickChart([
            'width' => 500,
            'height' => 300,
        ]);
        $chart->setConfig("{
            type: 'radar',
            data: {
                labels: " . json_encode($nomesCategsSelected)  . ",
                datasets: [{
                    data: " . json_encode($mediaPorCateg) . ",
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: none
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            display: false
                        },
                        suggestedMin: 0,
                        suggestedMax: 5
                    }
                }
            }
        }");
        $pngChart = $chart->getUrl();

        $pdf = PDF::loadView('pdf', compact('respostas', 'countQuests', 'pontosPorCateg', 'pngChart'));
        return [$pdf, $pngChart, $nomeCategSingle, $mediaPorCateg];
    }
}
