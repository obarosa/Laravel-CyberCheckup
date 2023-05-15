<?php

namespace App\Http\Controllers;

use App\Models\Questoes;
use App\Models\Tipos;
use Illuminate\Http\Request;

class QuestoesController extends Controller
{
    // Vai buscar todos os Tipos para serem escolhidos ao Criar ou Editar uma Questão
    public function getTipos($id)
    {
        $tipos = Tipos::all();
        if ($id == 'criar') {
            $atribuidos = null;
        }
        else {
            $questao = Questoes::find($id);
            $atribuidos = $questao->Tipos;
        }
        return [$tipos, $atribuidos];
    }

    // Vai buscar os dados da Questão para aparecer no Modal para Editar
    public function getQuestao($id)
    {
        $questao = Questoes::find($id);

        return [$questao->nome, $questao->info, $questao->obrigatoria, $questao->multiresposta, $questao->pontuacao, $this->getTipos($id)];
    }

    // Guarda a Questão
    // Se não encontrar o ID, Cria uma nova Questão. Se encontrar ID, Edita a Questão
    public function save(Request $request)
    {
        $categoriaId = $request->get('categoria');
        $nomeQuestao = $request->get('nome');
        $infoQuestao = $request->get('informacao');
        $obrigatoria = $request->get('obrigatoria');
        $multiresposta = $request->get('multiresposta');
        $pontuacao = $request->get('pontuacao');
        $tipos = $request->get('tipos');

        if ($request->get('questaoId') == null) {
            $questao = new Questoes();
            $questao->obrigatoria = $obrigatoria;
            $questao->multiresposta = $multiresposta;
            $questao->pontuacao = $pontuacao;
            $questao->nome = $nomeQuestao;
            $questao->info = $infoQuestao;
            $questao->categoria = $categoriaId;
            $questao->save();
            $questao->ordem = count($questao->Categoria->Questoes);
            $questao->save();
            for ($i = 0; $i < count($tipos); $i++) {
                $questao->Tipos()->attach($tipos[$i]);
            }
        } else {
            $questaoId = $request->get('questaoId');

            $questao = Questoes::find($questaoId);
            $questao->obrigatoria = $obrigatoria;
            $questao->multiresposta = $multiresposta;
            $questao->pontuacao = $pontuacao;
            //Se a Questão for Editada para não ter Pontuação, irá Retirar os Pontos de Todas as Respostas Associadas
            if ($pontuacao == 0 && !$questao->Respostas->isEmpty()) {
                foreach ($questao->Respostas as $resposta){
                    $resposta->pontos = null;
                    $resposta->save();
                }
            // Se acontecer o contrário, serão atribuidos pontos a cada Resposta automaticamente
            } elseif ($pontuacao == 1 && !$questao->Respostas->isEmpty()) {
                $contaPontos = 1;
                foreach ($questao->Respostas as $resposta){
                    if ($resposta->pontos == null){
                        $resposta->pontos = $contaPontos;
                        $resposta->save();
                        $contaPontos++;
                    } elseif($resposta->pontos = $contaPontos) {
                        $contaPontos++;
                    }
                }
            }
            $questao->nome = $nomeQuestao;
            $questao->info = $infoQuestao;
            $questao->save();
            $questao->Tipos()->detach();
            for ($i = 0; $i < count($tipos); $i++) {
                $questao->Tipos()->attach($tipos[$i]);
            }
        }
    }

    // Entra numa nova página com todas as Respostas Relacionadas com a Questão
    public function show(Questoes $questao)
    {
        $categoria = $questao->Categoria;
        $respostas = $questao->Respostas;

        return view('backoffice/questao-respostas', compact('categoria', 'questao', 'respostas'));
    }

    // ELIMINA a Questão e TODAS AS Respostas Associadas
    public function delete($id)
    {
        $questao = Questoes::find($id);
        $questao->Tipos()->detach();
        $respostas = $questao->Respostas;
        foreach ($respostas as $resposta) {
            $resposta->delete();
        }
        $questao->delete();
    }

    // Guarda na BD a Ordem de todas as Questões cada vez que uma Questão muda de posição na tabela
    public function order(Request $request)
    {
        $questoesIds = $request->get('allData');
        $i = 1;
        foreach ($questoesIds as $questaoId) {
            $questao = Questoes::find($questaoId);
            $questao->ordem = $i;
            $questao->save();
            $i++;
        }
    }
}
