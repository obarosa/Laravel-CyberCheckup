@extends('backoffice.master')
@section('title','Tipos de Utilizador')
@section('content')
    <x-app-layout>
        <div class="app"></div>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tipos De Utilizador') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <a id="createTipo" class="btn btn-primary mb-4" data-bs-toggle="modal"
                               data-bs-target="#modalTipo">Criar Tipo de Utilizador</a>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tipos as $tipo)
                                <tr>
                                    <td>{{$tipo->id}}</td>
                                    <td>{{$tipo->tipo}}</td>
                                    <td style="min-width:8em!important;">
                                        @if($tipo->id !== 1 && $tipo->id !== 2)
                                            <a id="edittipo_{{$tipo->id}}" class="btn btn-sm btn-success btedittipo" data-bs-toggle="modal" data-bs-target="#modalTipo"><i class="fa fa-pencil"></i></a>
                                            <a id="delete_{{$tipo->id}}" class="btn btn-sm btn-danger btdeletetipo"><i class="fa fa-trash-can"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{--  MODAL  --}}
        <div class="modal" id="modalTipo" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalTipo"></span> Tipo</h5>
                    </div>
                    <div class="modal-body">
                        <label id="tipoLabel" style="display:none" tipoId=""></label>
                        <label for="criarTipoNome">Nome: </label>
                        <input type="text" id="criarTipoNome" class="form-control mb-2">
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarTipo" class="btn btn-secondary close" data-bs-dismiss="modal">Cancelar
                        </button>
                        <button id="btnGuardarTipo" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>

    <script src="{{ asset('/js/tipos.js') }}"></script>
@endsection
