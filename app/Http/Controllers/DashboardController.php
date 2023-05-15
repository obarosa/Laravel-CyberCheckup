<?php

namespace App\Http\Controllers;

use App\Imports\DadosImport;
use App\Models\Email;
use App\Models\Tentativas;
use App\Models\User;
use App\Models\Tipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('backoffice/dashboard');
    }

    //User actions
    // Na vista dos Utilizadores mostra uma tabela com Utilizadores e outra tabela com as Submissões/Tentativas dos Utilizadores não autenticados
    public function usersIndex()
    {
        $users = User::all();
        $usersNotAuth = Tentativas::where('user', null)->orderBy('created_at', 'DESC')->get();
        return view('backoffice/users', compact('users', 'usersNotAuth'));
    }

    // Vai buscar todos os Tipos de Utilizador para mostrar no Modal
    public function getTiposUser()
    {
        $tipos = Tipos::all();

        return $tipos;
    }

    // Vai buscar os dados do Utilizador selecionado para mostrar no Modal de Editar
    public function getUser(User $id)
    {
        $username = $id->name;
        $email = $id->email;
        $usertipo = $id->tipo;

        $tipos = $this->getTiposUser();

        return [$username, $email, $usertipo, $tipos];
    }

    // Vai buscar os dados da Tentativa de utilizador não autenticado
    public function getUserNotAuth(Tentativas $id)
    {
        $nome = $id->nome;
        $email = $id->email;

        return [$nome, $email];
    }

    // Guarda o Utilizador
    // Se não encontrar ID do Utilizador, Cria um novo. Se encontrar ID, Edita esse Utilizador
    public function userSave(Request $request)
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $pass = $request->get('pass');
        $tipo = $request->get('tipo');
        if ($request->get('guest') != null) {
            $guest = $request->get('guest');
        }

        if ($request->get('userId') == null) {
            $user = new User();
            $user->name = $username;
            $user->email = $email;
            $user->password = Hash::make($pass);
            if (intval($tipo) == 2) {
                $user->perfil = 'admin';
            } else {
                $user->perfil = 'cliente';
            }
            $user->tipo = intval($tipo);
            $user->save();
            if (isset($guest)) {
                $tentativas = Tentativas::all()->where('email', $email)->where('nome', $username);
                foreach ($tentativas as $tentativa) {
                    $tentativa->user = $user->id;
                    $tentativa->save();
                }
            }
        } else {
            $userId = $request->get('userId');
            $user = User::find($userId);
            $user->name = $username;
            $user->email = $email;
            $user->password = Hash::make($pass);
            if ($tipo == 1) {
                $user->perfil = 'admin';
            } else {
                $user->perfil = 'cliente';
            }
            $user->tipo = $tipo;
            $user->save();
        }
    }

    // DASHBOARD
    // Importa dados do ficheiro Excel
    public function import(Request $request)
    {
        Excel::import(new DadosImport, $request->file('file'));
        return redirect('/categorias')->withStatus('Ficheiro Importado!');
    }

    public function getEmail()
    {
        $inputEmail = Email::find(1);
        return $inputEmail;
    }

    public function postEmail()
    {
        Email::updateOrCreate(
            ['id' =>  1],
            ['nome' =>  request('email'),]
        );
        return 1;
    }
}
