@extends('backoffice.master')
@section('title', $questao->nome)
@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a id="voltar" href="{{ route('categorias.show', $categoria->id) }}"
                    class="btn btn-secondary mr-2">Voltar</a>
                {{ __('Questão: ' . $questao->nome) }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <a id="createRespostaModal" href="#" class="btn btn-primary mb-4" data-bs-toggle="modal"
                                data-bs-target="#modalResposta">Criar Resposta</a>
                        </div>
                        <table id="tableRespostas" class="table caption-top">
                            <caption>Lista de Respostas</caption>
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Pontuação</th>
                                    <th>Nome</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="row_position">
                                @foreach ($respostas as $resposta)
                                    <tr id="{{ $resposta->id }}" class="linhaOrdemResp">
                                        <td class="text-center align-middle">
                                            <i class="fa-solid fa-bars pe-grab">{{ $resposta->ordem }}</i>
                                        </td>
                                        <td class="align-middle">{{ $resposta->pontos }}</td>
                                        <td class="align-middle">{{ $resposta->nome }}</td>
                                        <td style="min-width:8em!important;">
                                            <a id="editresposta_{{ $resposta->id }}"
                                                class="btn btn-sm btn-success bteditresp" data-bs-toggle="modal"
                                                data-bs-target="#modalResposta"><i class="fa fa-pencil"></i></a>
                                            <a id="deleteresposta_{{ $resposta->id }}"
                                                class="btn btn-sm btn-danger btdeleteresp"><i
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
        <div class="modal" id="modalResposta" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalResposta"></span> para a questao:
                            {{ $questao->nome }}</h5>
                    </div>
                    <div class="modal-body">
                        <label id="questaoLabel" style="display:none" questId="{{ $questao->id }}"></label>
                        <label id="respostaLabel" style="display:none"></label>
                        @if($questao->pontuacao == 1)
                        <label for="criarRespostaPontuacao">Pontos: </label>
                        <input id="criarRespostaPontuacao" type="number" min="0" class="form-control" value="0">
                        @endif
                        <label for="criarRespostaNome">Nome: </label>
                        <textarea id="criarRespostaNome" type="text" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarGuardarResposta" class="btn btn-secondary close"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button id="btnGuardarResposta" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>

    <script src="{{ asset('/js/respostas.js') }}"></script>
@endsection
