<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Niveis;
use App\Models\Questoes;
use App\Models\Respostas;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Categorias::all();
        // return [$categorias];
        return view('backoffice/categorias', compact('categorias'));
    }

    // Vai buscar os dados da Categoria para aparecer no Modal para Editar
    public function getCategoria($id)
    {
        $categoria = Categorias::find($id);

        return [$categoria->nome, $categoria->visivel];
    }

    // Guarda a Categoria
    // Se não encontrar o ID, Cria uma nova Categoria. Se encontrar ID, Edita a Categoria com esse ID
    public function save(Request $request)
    {
        $nome = $request->get('nome');
        $visivel = $request->get('visivel');

        if ($request->get('categoriaId') == null) {
            $categoria = new Categorias();
            $categoria->nome = $nome;
            $categoria->visivel = $visivel;
            $categoria->ordem = Categorias::max('ordem') + 1;
            $categoria->save();
        } else {
            $categoriaId = $request->get('categoriaId');
            $categoria = Categorias::find($categoriaId);
            $categoria->nome = $nome;
            $categoria->visivel = $visivel;
            $categoria->save();
        }
    }

    // Entra numa nova página com todas as Questões Relacionadas com a Categoria
    public function show(Categorias $categoria)
    {
        $questoes = $categoria->Questoes;

        return view('backoffice/categoria-questoes', compact('categoria', 'questoes'));
    }

    // ELIMINA a Categoria e TODAS AS Questões E Respostas Associadas
    public function delete($id)
    {
        $categoria = Categorias::find($id);

        $questoes = Questoes::all()->where('categoria', $categoria->id);

        foreach ($questoes as $questao) {
            $respostas = $questao->Respostas;
            foreach ($respostas as $resposta) {
                $resposta->delete();
            }
            $questao->Tipos()->detach();
            $questao->delete();
        }
        $categoria->delete();
    }

    // Guarda na BD a Ordem de todas as Categorias cada vez que uma Categoria muda de posição na tabela
    public function order(Request $request)
    {
        $categoriasIds = $request->get('allData');
        $i = 1;
        foreach ($categoriasIds as $categoriaId) {
            $categoria = Categorias::find($categoriaId);
            $categoria->ordem = $i;
            $categoria->save();
            $i++;
        }
    }
}
