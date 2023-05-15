<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\Medias;
use App\Models\Questoes;
use App\Models\Respostas;
use App\Models\Categorias;
use App\Models\Tentativas;
use App\Models\Respondidas;
use App\Mail\guestTentativa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PdfController;
use App\Models\Email;

class FrontendController extends PdfController
{
    // HOME
    public function indexHome()
    {
        // Se o Utilizador não estiver autenticado, o tipo é sempre 'guest'
        if (Auth::user()) {
            $userTipo = Auth::user()->tipo;
        } else {
            $userTipo = 1;
        }

        // Procura o ID de cada Questão Associada ao Tipo do Utilizador
        $getQuestByTipo = DB::table('questoes_tipos')->where('tipos_id', $userTipo)->get();
        $allIdQuestsByTipo = [];
        foreach ($getQuestByTipo as $questByTipo) {
            array_push($allIdQuestsByTipo, $questByTipo->questoes_id);
        }

        // Vai buscar todas as Categorias relacionadas com cada Questão
        $allIdCategoria = [];
        for ($i = 0; $i < count($allIdQuestsByTipo); $i++) {

            $getQuestao = Questoes::find($allIdQuestsByTipo[$i]);
            array_push($allIdCategoria, $getQuestao->categoria);
        }
        $allIdCategoria = array_unique($allIdCategoria);

        // Valida Categoria para saber qual pode ser mostrada na vista Home
        $categValida = 0;
        // Procura todas as Categorias que podem ser visíveis ao Utilizador conforme o seu Tipo
        foreach ($allIdCategoria as $key => $eachCategs) {
            $categ = Categorias::find($eachCategs);
            if ($categ->visivel) {
                foreach ($categ->Questoes as $questao) {
                    if (count($questao->Respostas) > 1) {
                        $categValida = 1;
                    }
                }
                if ($categValida == 0) {
                    unset($allIdCategoria[$key]);
                }
                $categValida = 0;
            } else {
                unset($allIdCategoria[$key]);
            }
        }

        $categorias = Categorias::find($allIdCategoria)->sortBy('ordem');
        return view('frontoffice.home', compact('categorias'));
    }

    // QUESTÕES
    // Botão para começar o Questionário
    public function indexQuestoes($checados)
    {
        // Encontra todas as Categorias selecionadas pelo Utilizador
        $categorias = array_map('intval', explode(',', $checados));
        $arrCateg = [];
        for ($i = 0; $i < count($categorias); $i++) {
            $categoria = Categorias::find($categorias[$i]);
            array_push($arrCateg, $categoria);
        }

        if (Auth::user()) {
            $userTipo = Auth::user()->tipo;
        } else {
            $userTipo = 1;
        }

        // Conta Questoes por Categoria de acordo com o Tipo do Utilizador
        $questoesPorCateg = 0;
        $countQuestForCat = [];
        for ($j = 0; $j < count($arrCateg); $j++) {
            foreach ($arrCateg[$j]->Questoes as $questao) {
                if (count($questao->Respostas) > 1 && $questao->checkTipo($userTipo)) {
                    $questoesPorCateg++;
                }
            }
            array_push($countQuestForCat, sprintf('%02d', $questoesPorCateg));
            $questoesPorCateg = 0;
        }
        return view('frontoffice.questoes', compact('arrCateg', 'countQuestForCat'));
    }

    // Calcular a Média da pontuação das Respostas submetidas pelo Utilizador
    public function calcularMedia($respostas)
    {
        // Procura todas as Categorias relacionadas com as Respostas
        // Conta o número de Questões por Categoria
        $arrIdQuest = [];
        $contagem = [];
        for ($i = 0; $i < count($respostas); $i++) {
            $resposta = $respostas[$i]->Questao->Categoria->id;
            $contagem[$respostas[$i]->Questao->id] = $respostas[$i]->Questao->Categoria->id;
            array_push($arrIdQuest, $resposta);
        }
        $countQuests = array_count_values($contagem);

        // Calcula a média de pontos
        $categorias = array_unique($arrIdQuest);
        $pontosPorCateg = [];
        foreach ($categorias as $categoria) {
            $pontos = 0;
            $respostasPorCateg = 0;
            foreach ($respostas as $resposta) {
                if ($categoria == $resposta->Questao->Categoria->id) {
                    if ($resposta->Questao->pontuacao) {
                        $respostasPorCateg++;
                        $pontos += $resposta->pontos;
                    }
                }
            }
            if ($respostasPorCateg == 0) {
                $media = 0;
            } else {
                $media = $pontos / $respostasPorCateg;
            }
            // Guarda a Média de Pontos por Categoria
            $pontosPorCateg[$categoria] = $media;
        }

        return [$countQuests, $pontosPorCateg];
    }

    // RESULTADO
    // Botão de Submeter uma Tentativa
    public function storeResultado(Request $request)
    {
        //Recebe ID's das Respostas Submetidas
        $idsRespostas = $request->get('idsRespostas');

        //Procura as Respostas por Ordem das Categorias e das Questões
        $respostas = Respostas::find(explode(',', $idsRespostas))->sortBy(function ($q) {
            return $q->Questao->ordem;
        })->sortBy(function ($query) {
            return $query->Questao->Categoria->ordem;
        })->all();

        $respostas = array_values($respostas);

        $countQuests = $this->calcularMedia($respostas)[0];
        $pontosPorCateg = $this->calcularMedia($respostas)[1];

        $categoriaRepetida = 0;

        //Cria uma Tentativa para o Utilizador
        if (Auth::check()) {
            $user = auth()->user();
            $tentativa = new Tentativas();
            $tentativa->email = $user->email;
            $tentativa->user = $user->id;
            $tentativa->usertipo = $user->Tipo->tipo;
            $tentativa->save();
            foreach ($respostas as $key => $resposta) {
                if ($key == 0 && $categoriaRepetida == 0) {
                    $guardarCateg = new Medias();
                    $guardarCateg->categoria = $resposta->Questao->Categoria->nome;
                    $guardarCateg->media = $pontosPorCateg[$resposta->Questao->Categoria->id];
                    $guardarCateg->tentativa = $tentativa->id;
                    $guardarCateg->save();
                    $categoriaRepetida = 1;
                } else if ($respostas[$key - 1]->Questao->Categoria->id == $respostas[$key]->Questao->Categoria->id) {
                    $categoriaRepetida = 1;
                } else {
                    $categoriaRepetida = 0;
                }
                if (!$categoriaRepetida) {
                    $guardarCateg = new Medias();
                    $guardarCateg->categoria = $resposta->Questao->Categoria->nome;
                    $guardarCateg->media = $pontosPorCateg[$resposta->Questao->Categoria->id];
                    $guardarCateg->tentativa = $tentativa->id;
                    $guardarCateg->save();
                }
                $guardarRespondida = new Respondidas();
                $guardarRespondida->categoria = $guardarCateg->id;
                $guardarRespondida->pergunta = $resposta->Questao->nome;
                $guardarRespondida->resposta = $resposta->nome;
                $guardarRespondida->pontos = $resposta->pontos;
                $guardarRespondida->save();
            }
        }
        //Envia as variáveis para as Sessions para serem utilizadas noutros controladores
        request()->session()->put('respostas', $respostas);
        request()->session()->put('pontosPorCateg', $pontosPorCateg);

        return view('frontoffice.resultado', compact('respostas', 'countQuests', 'idsRespostas', 'pontosPorCateg'));
    }

    //Diz se existe um Utilizador Autenticado para enviar para o JavaScript
    public function isAuth()
    {
        return Auth::check();
    }

    // Botão de Submissão para Utilizadores Não Autenticados
    public function submissaoGuest(Request $request)
    {
        $respostas = request()->session()->get('respostas');
        $pontosPorCateg = request()->session()->get('pontosPorCateg');

        $nome = $request->get('nome');
        $contacto = $request->get('contacto');
        $useremail = $request->get('email');

        // Cria uma Tentativa sem Utilizador associado
        $categoriaRepetida = 0;
        $tentativa = new Tentativas();
        $tentativa->nome = $nome;
        $tentativa->contacto = $contacto;
        $tentativa->email = $useremail;
        $tentativa->user = null;
        $tentativa->usertipo = 'guest';
        $tentativa->save();
        foreach ($respostas as $key => $resposta) {
            if ($key == 0 && $categoriaRepetida == 0) {
                $guardarCateg = new Medias();
                $guardarCateg->categoria = $resposta->Questao->Categoria->nome;
                $guardarCateg->media = $pontosPorCateg[$resposta->Questao->Categoria->id];
                $guardarCateg->tentativa = $tentativa->id;
                $guardarCateg->save();
                $categoriaRepetida = 1;
            } else if ($respostas[$key - 1]->Questao->Categoria->id == $respostas[$key]->Questao->Categoria->id) {
                $categoriaRepetida = 1;
            } else {
                $categoriaRepetida = 0;
            }
            if (!$categoriaRepetida) {
                $guardarCateg = new Medias();
                $guardarCateg->categoria = $resposta->Questao->Categoria->nome;
                $guardarCateg->media = $pontosPorCateg[$resposta->Questao->Categoria->id];
                $guardarCateg->tentativa = $tentativa->id;
                $guardarCateg->save();
            }
            $guardarRespondida = new Respondidas();
            $guardarRespondida->categoria = $guardarCateg->id;
            $guardarRespondida->pergunta = $resposta->Questao->nome;
            $guardarRespondida->resposta = $resposta->nome;
            $guardarRespondida->pontos = $resposta->pontos;
            $guardarRespondida->save();
        }

        $this->emailResults($nome, $contacto, $useremail);
    }

    // Vista do Resultado depois da Submissão
    public function indexResultado()
    {
        // array com Todas as Categorias Selecionadas
        $respostas = request()->session()->get('respostas');
        $eachCat = [];
        foreach ($respostas as $resposta) {
            $idEachResp = $resposta->Questao->Categoria;
            array_push($eachCat, $idEachResp);
        }
        $eachCat = (array_unique($eachCat));

        //media
        $pontosPorCateg = request()->session()->get('pontosPorCateg');

        // Array dos NOMES e ID's das Categorias Selecionadas para serem mostradas no Gráfico
        $nomesCategsSelected = [];
        $mediaPorCateg = [];
        foreach ($eachCat as $categs) {
            $nomeCategs = $categs->nome;
            $idsCategs = $categs->id;
            array_push($nomesCategsSelected, $nomeCategs);
            array_push($mediaPorCateg, floor($pontosPorCateg[$idsCategs]));
        }

        return [$nomesCategsSelected, $mediaPorCateg];
    }

    //Envia um email caso seja um Utilizador não autenticado a Submeter a Tentativa
    public function emailResults($nome, $contacto, $useremail)
    {
        $dados = $this->toEmail();
        $pdf = $dados[0];
        $chart = $dados[1];
        $categs = $dados[2];
        $medias = $dados[3];
        $toEmail = Email::find(1)->nome;
        Mail::to($toEmail)->send(new guestTentativa($nome, $contacto, $useremail, $pdf, $chart, $categs, $medias));

        return back();
    }
}
