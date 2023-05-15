<?php

namespace App\Http\Controllers;

use App\Exports\TentativasExport;
use App\Models\Tentativas;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    // Exporta os dados de uma Submissão/Tentativa de um Utilizador
    public function export(Request $request)
    {
        $tentativa = $request->session()->get('dadosTentativas');
        $dataTentativa = date('d-m-Y_His', strtotime($tentativa->first()->created_at));
        $idTentativa = $tentativa->first()->tentativa;
        $idUser = Tentativas::where('id', $idTentativa)->first()->user;
        $nomeUser = User::where('id', $idUser)->first()->name;
        return Excel::download(new TentativasExport($tentativa), $nomeUser . '_' . $dataTentativa . '.xlsx');
    }
}
