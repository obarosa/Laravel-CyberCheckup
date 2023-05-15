<?php

namespace App\Http\Controllers;
use App\Models\Medias;
use App\Models\Tentativas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilUtilizadorController extends Controller
{

    // Mostra a vista das Tentativas do Utilizador caso não seja Admin
    public function index()
    {
        $tentativas = Tentativas::where('user', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        return view('backoffice.perfilutilizador', compact('tentativas'));
    }

    // Mostra Individualmente os dados de uma Tentativa
    public function getTentativa($id)
    {
        $categorias = Medias::all()->where('tentativa', $id);
        request()->session()->put('dadosTentativas', $categorias);

        return view('backoffice/respostasutilizador', compact('categorias'));
    }
}
