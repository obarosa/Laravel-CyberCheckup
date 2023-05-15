@extends('backoffice.master')
@section('title', 'Categorias')
@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categorias') }}
            </h2>
        </x-slot>
        {{-- ---- ALERTAS ---- --}}
        @if (session('status'))
            <div class="mx-auto alert alert-success col-9 mt-2" role="alert" style="margin-bottom: -35px!important;">
                {{ session('status') }}
            </div>
        @endif
        @if (session('erro'))
            <div class="mx-auto alert alert-danger col-9 mt-2" role="alert" style="margin-bottom: -35px!important;">
                {{ session('erro') }}
            </div>
        @endif

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <a id="createCategoriaModal" class="btn btn-primary mb-4" data-bs-toggle="modal"
                               data-bs-target="#modalCategoria">Criar Categoria</a>
                        </div>
                        <div id="alertSemQuestoes" class="alert alert-warning" role="alert" style="display:none">
                            Atenção: Categorias sem Questões não serão vistas pelos utilizadores!
                        </div>
                        <table id="tableCategorias" class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nome</th>
                                    <th>Nº de Questões</th>
                                    <th>Visível</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="row_position">
                                @foreach ($categorias as $categoria)
                                    <tr id={{ $categoria->id }} class="linhaOrdemCat">
                                        <td class="text-center align-middle">
                                            <i class="fa-solid fa-bars pe-grab">{{ $categoria->ordem }}</i>
                                        </td>
                                        <td class="align-middle">{{ $categoria->nome }}</td>
                                        <td style="min-width:10em!important;" class="align-middle">
                                            {{ count($categoria->Questoes) }}
                                        </td>
                                        <td>{{ $categoria->visivel == 1 ? 'Sim' : 'Não' }}</td>
                                        <td style="min-width:8em!important;">
                                            <a id="show_{{ $categoria->id }}"
                                                href="{{ route('categorias.show', $categoria->id) }}"
                                                class="btn btn-sm btn-primary btshowcat"><i class="fa fa-eye"></i></a>
                                            <a id="editcategoria_{{ $categoria->id }}"
                                                class="btn btn-sm btn-success bteditcat" data-bs-toggle="modal"
                                                data-bs-target="#modalCategoria"><i class="fa fa-pencil"></i></a>
                                            <a id="delete_{{ $categoria->id }}"
                                                class="btn btn-sm btn-danger btdeletecat"><i
                                                    class="fa fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- MODAL --}}
        <div class="modal" id="modalCategoria" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalCategoria"></span> Categoria</h5>
                    </div>
                    <div class="modal-body">
                        <label id="categoriaLabel" style="display:none" catId=""></label>
                        <label for="criarCategoriaNome">Nome: </label>
                        <input id="criarCategoriaNome" type="text" class="form-control mb-2">
                        <label for="categoriaVisivel">Visível: </label>
                        <input id="categoriaVisivel" type="checkbox" class="mb-2">
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarGuardarCategoria" class="btn btn-secondary close"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button id="btnGuardarCategoria" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>

    <script src="{{ asset('/js/categorias.js') }}"></script>
@endsection
