<?php

namespace App\Http\Controllers;

use App\Models\Respostas;
use Illuminate\Http\Request;

class RespostasController extends Controller
{
    // Guarda a Resposta
    // Se não encontrar o ID, Cria uma nova Resposta. Se encontrar ID, Edita a Resposta
    public function save(Request $request)
    {
        $questaoId = $request->get('questao');
        $nomeResposta = $request->get('nome');
        if ($request->get('pontos') !== null){
            $pontos = $request->get('pontos');
        } else {
            $pontos = null;
        }

        if ($request->get('respostaId') == null){
            $resposta = new Respostas();
            $resposta->nome = $nomeResposta;
            $resposta->pontos = $pontos;
            $resposta->questao = $questaoId;
            $resposta->save();
            $resposta->ordem = count($resposta->Questao->Respostas);
            $resposta->save();
            return 'Resposta Criada';
        } else {
            $respostaId = $request->get('respostaId');

            $resposta = Respostas::find($respostaId);
            $resposta->nome = $nomeResposta;
            $resposta->pontos = $pontos;
            $resposta->save();
            return 'Resposta Editada';
        }
    }

    // ELIMINA a Resposta
    public function delete($id)
    {
        $resposta = Respostas::find($id);
        $resposta->delete();
    }

    // Guarda na BD a Ordem de todas as Respostas cada vez que uma Resposta muda de posição na tabela
    public function order(Request $request)
    {
        $respostasIds = $request->get('allData');
        $i = 1;
        foreach ($respostasIds as $respostaId) {
            $resposta = Respostas::find($respostaId);
            $resposta->ordem = $i;
            $resposta->save();
            $i++;
        }
    }
}
