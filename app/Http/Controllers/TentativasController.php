<?php

namespace App\Http\Controllers;

use App\Models\Medias;
use App\Models\Tentativas;
use Illuminate\Http\Request;

class TentativasController extends Controller
{

    // Mostra a vista das Tentativas do Utilizador selecionado
    public function userTentativas($id)
    {
        $tentativas = Tentativas::where('user', $id)->orderBy('created_at', 'DESC')->get();
        return view('backoffice/tentativas', compact('tentativas'));
    }

    // Mostra Individualmente os dados de uma Tentativa
    public function showTentativa($id)
    {
        $categorias = Medias::all()->where('tentativa', $id);
        request()->session()->put('dadosTentativas', $categorias);
        return view('backoffice/respondidas', compact('categorias'));
    }
}
