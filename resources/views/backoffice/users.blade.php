@extends('backoffice.master')
@section('title', 'Utilizadores')
@section('content')
    <x-app-layout>
        <div class="app"></div>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Utilizadores') }}
            </h2>
        </x-slot>

        {{-- UTILIZADORES --}}
        <div class="pt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="row">
                            <div class="col-4">
                                <a id="createUserModal" class="btn btn-primary mb-4" data-bs-toggle="modal"
                                    data-bs-target="#modalUser">Criar Utilizador</a>
                            </div>
                        </div>
                        <table id="tableUsers" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo de Utilizador</th>
                                    <th>Data</th>
                                    <th style="padding: 1.1rem !important;">Ações</th>
                                </tr>
                            </thead>
                            {{-- <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo de Utilizador</th>
                                </tr>
                            </tfoot> --}}
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        @if ($user->tipo != null)
                                            <td>{{ $user->Tipo->tipo }}</td>
                                        @else
                                            <td>--</td>
                                        @endif
                                        @if ($user->Tentativas->last() == null)
                                            <td>-</td>
                                        @else
                                            <td>{{ date('d/m/Y', strtotime($user->Tentativas->last()->created_at)) }}</td>
                                        @endif

                                        <td>
                                            <a id="showtentativas_{{ $user->id }}"
                                                href="{{ route('tentativas.index', $user->id) }}"
                                                class="btn btn-sm btn-primary btshowtent"><i class="fa fa-eye"></i></a>
                                            <a id="edituser_{{ $user->id }}" class="btn btn-sm btn-success btedituser"
                                                data-bs-toggle="modal" data-bs-target="#modalUser"><i
                                                    class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- UTILIZADORES NÃO AUTENTICADOS --}}
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="btn btn-primary bg-gradient mb-4" style="cursor: auto!important;">
                                    Utilizadores Não Registados
                                </h4>
                            </div>
                        </div>
                        <table id="tableUsersNotAuth" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telemóvel</th>
                                    <th>Data</th>
                                    <th style="padding: 1.1rem !important;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usersNotAuth as $userNotAuth)
                                    <tr>
                                        <td>{{ $userNotAuth->nome }}</td>
                                        <td>{{ $userNotAuth->email }}</td>
                                        <td>{{ $userNotAuth->contacto != null ? $userNotAuth->contacto : '-' }}</td>
                                        <td>{{ date('d/m/Y', strtotime($userNotAuth->created_at)) }}
                                        </td>
                                        <td>
                                            <a id="showtentativas_{{ $userNotAuth->id }}"
                                                href="{{ route('tentativas.show', $userNotAuth->id) }}"
                                                class="btn btn-sm btn-primary btshowtent">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a id="userNotAuth_{{ $userNotAuth->id }}"
                                                class="btn btn-sm btn-success btnUserNotAuth" data-bs-toggle="modal"
                                                data-bs-target="#modalUser">
                                                <i class="fa-solid fa-unlock-keyhole"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL UTILIZADORES --}}
        <div class="modal" id="modalUser" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalUser"></span></h5>
                    </div>
                    <div class="modal-body">
                        <label id="userLabel" style="display:none" userId=""></label>
                        <label for="criarUserNome">Nome: </label>
                        <input id="criarUserNome" type="text" class="form-control mb-2">
                        <label for="criarUserEmail">Email: </label>
                        <input id="criarUserEmail" type="email" class="form-control mb-2">
                        <label id="warningpass" style="display: none"><strong>Atenção: as palavras-passe têm de
                                coincidir.</strong></label>
                        <label for="criarUserPass" id="labelPass">Password: </label>
                        <input id="criarUserPass" type="password" class="form-control mb-2">
                        <label for="userConfirmPass" id="labelConfirm">Confirmar Password: </label>
                        <input id="userConfirmPass" type="password" class="form-control mb-2">
                        <label for="selectUserTipo" id="labelTipo">Tipo: </label>
                        <div id="radios" class="form-check mb-2 d-flex"
                            style="width: 100%;flex-wrap: wrap;max-width: 25em;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarGuardarUser" class="btn btn-secondary close"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button id="btnGuardarUser" class="btn btn-primary">Guardar</button>
                        <button id="btnTranferirUserNotAuth" class="btn btn-primary">
                            Registar Utilizador
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>

    <script src="{{ asset('/js/utilizadores.js') }}"></script>
@endsection
