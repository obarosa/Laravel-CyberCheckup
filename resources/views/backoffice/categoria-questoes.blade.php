@extends('backoffice.master')
@section('title', $categoria->nome)
@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a id="voltar" href="{{ route('categorias.index') }}" class="btn btn-secondary mr-2">Voltar</a>
                {{ __('Categoria: ' . $categoria->nome) }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <a id="createQuestaoModal" class="btn btn-primary mb-4" data-bs-toggle="modal"
                                data-bs-target="#modalQuestao">Criar Questão</a>
                        </div>
                        <div id="alertSemRespostas" class="alert alert-warning" role="alert" style="display:none">
                            Atenção: Questões com menos de 2 Respostas não serão vistas pelos utilizadores!
                        </div>
                        <table id="tableQuestoes" class="table caption-top">
                            <caption>Lista de Questões</caption>
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nome</th>
                                    <th>Nº de Respostas</th>
                                    <th>Obrigatória</th>
                                    <th>Multi Respostas</th>
                                    <th>Pontuação</th>
                                    <th>Info.</th>
                                    <th style="max-width: 4em!important;">Tipos</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="row_position">
                                @foreach ($questoes as $questao)
                                    <tr id={{ $questao->id }} class="linhaOrdemQuest">
                                        <td class="text-center align-middle">
                                            <i class="fa-solid fa-bars pe-grab">{{ $questao->ordem }}</i>
                                        </td>
                                        <td class="align-middle">{{ $questao->nome }}</td>
                                        <td style="min-width:6em!important;" class="align-middle">{{ count($questao->Respostas) }}</td>
                                        <td style="min-width:6em">{{ $questao->obrigatoria == 1 ? 'Sim' : 'Não' }}</td>
                                        <td style="min-width:6em">{{ $questao->multiresposta == 1 ? 'Sim' : 'Não' }}</td>
                                        <td style="min-width:6em">{{ $questao->pontuacao == 1 ? 'Sim' : 'Não' }}</td>
                                        <td>
                                            @if ($questao->info != null)
                                                <button type="button" data-container="body" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ $questao->info }}">
                                                    <i class="fa-solid fa-info"></i>
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="tdTipos">
                                            @if (count($questao->Tipos) != 0)
                                                <button type="button" data-container="body" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-html="true" style=""
                                                    title=" @foreach ($questao->Tipos as $tipo) {{ $tipo->tipo . '<br>' }} @endforeach">
                                                    @foreach ($questao->Tipos as $tipo)
                                                        <span class="badge bg-light text-dark">{{ $tipo->tipo }}</span>
                                                    @endforeach
                                                    {{-- <i class="fa-solid fa-circle-check"></i> --}}
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="min-width:8em!important;">
                                            <a id="showquestao_{{ $questao->id }}"
                                                href="{{ route('questoes.show', $questao->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                            <a id="editquestao_{{ $questao->id }}"
                                                class="btn btn-sm btn-success bteditquest" data-bs-toggle="modal"
                                                data-bs-target="#modalQuestao"><i class="fa fa-pencil"></i></a>
                                            <a id="deletequestao_{{ $questao->id }}"
                                                class="btn btn-sm btn-danger btdeletequest"><i
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
        <div class="modal" id="modalQuestao" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalQuestao"></span> para a
                            categoria: {{ $categoria->nome }}</h5>
                    </div>
                    <div class="modal-body">
                        <label id="categoriaLabel" style="display:none" catId="{{ $categoria->id }}"></label>
                        <label id="questaoLabel" style="display:none" questId=""></label>
                        <label for="criarQuestaoNome">Nome: </label>
                        <textarea id="criarQuestaoNome" type="text" class="form-control mb-2"></textarea>
                        <label for="criarQuestaoInfo">Informações Adicionais: </label>
                        <textarea id="criarQuestaoInfo" class="form-control mb-2"></textarea>
                        <label for="checkObrigatoria">Obrigatória: </label>
                        <input id="checkObrigatoria" type="checkbox" class="mb-2">
                        <label for="checkMultiresposta">Multi Resposta: </label>
                        <input id="checkMultiresposta" type="checkbox" class="mb-2">
                        <label style="margin-left: 20px;" for="checkPontuacao">Pontuação: </label>
                        <input id="checkPontuacao" type="checkbox" class="mb-2">
                        <br>
                        <label for="questaoTipos">Tipos:</label>
                        <div id="questaoTipos" class="d-flex align-items-center flex-wrap"></div>
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarGuardarQuestao" class="btn btn-secondary close" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button id="btnGuardarQuestao" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script src="{{ asset('/js/questoes.js') }}"></script>
@endsection
