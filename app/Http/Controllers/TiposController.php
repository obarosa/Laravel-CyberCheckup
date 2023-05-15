<?php

namespace App\Http\Controllers;

use App\Models\Questoes;
use App\Models\Tipos;
use App\Models\User;
use Illuminate\Http\Request;

class TiposController extends Controller
{

    // Mostra a vista com a tabela dos Tipos
    public function getTipos()
    {
        $tipos = Tipos::all();
        return view('backoffice/tipos', compact('tipos'));
    }

    // Vai buscar os dados do Tipo para aparecer no Modal para Editar
    public function getTipo($id)
    {
        $tipo = Tipos::find($id);

        return $tipo;
    }

    // Guarda o Tipo
    // Se não encontrar o ID, Cria um novo Tipo. Se encontrar ID, Edita o Tipo com esse ID
    public function save(Request $request)
    {
        $tipoNome = $request->get('tipo');

        if ($request->get('tipoId') == null){
            $tipo = new Tipos();
            $tipo->tipo = $tipoNome;
            $tipo->save();
        } else {
            $tipoId = $request->get('tipoId');
            $tipo = Tipos::find($tipoId);
            $tipo->tipo = $tipoNome;
            $tipo->save();
        }
    }

    // Elimina o Tipo de Utilizador e todos os Utilizadores com esse tipo passam a ter o Tipo 'Guest'
    public function delete($id)
    {
        $tipo = Tipos::find($id);
        $tipo->Questoes()->detach();
        foreach ($tipo->Users as $user){
            $user->tipo = 1;
            $user->save();
        }
        $tipo->delete();
    }
}
