@extends('frontoffice.master')
@section('title', 'HLink CyberCheckup')
@section('content')
    <nav class="navbar fixed-top navbar-light bg-hlink px-5" style="height: 70px;padding-left:4rem!important">
        <a href="{{ route('feHome.index') }}" class="btn btn-sm-hlink btnSair" type="button">Sair</a>
        <div class="d-flex align-items-center pe-5">
            @if (Route::has('login'))
                @auth
                    @if (Auth::user() && Auth::user()->isAdmin())
                        <a href="{{ url('/dashboard') }}" class="btn btn-sm-hlink">Dashboard</a>
                    @elseif (Auth::user())
                        <a href="{{ url('/perfil') }}" class="btn btn-sm-hlink">Perfil Utilizador</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="ps-2">
                        @csrf
                        <a href="route('logout')" class="btn navLogoutIcon"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fa-solid fa-right-from-bracket" style="color: white"></i>
                        </a>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="me-2 btn btn-sm-hlink">Login</a>
                @endauth
            @endif
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 bg-questoes-left">
                <div class="d-flex flex-column min-vh-100 justify-content-center sticky-top"
                    style="height: 100vh; width: 100%;">
                    <div class="text-center pb-5 titleHlink">Categorias</div>
                    <div class="row mx-auto resultCategoriasDisplay py-3">
                        @for ($i = 0; $i < count($arrCateg); $i++)
                            <a href="#divCategoria_{{ $arrCateg[$i]->id }}" style="scroll-padding-top: 4rem;"
                                class="btn btn-Cathlink btnQuestoes mb-2 px-3" id="categoria_id{{ $arrCateg[$i]->id }}"
                                id-Categ={{ $arrCateg[$i]->id }}>
                                {{ $arrCateg[$i]->nome }}
                            </a>
                        @endfor
                    </div>
                    <div class="align-self-center pt-3 text-muted fs-6">
                        <span style="color: red">*</span>
                        Resposta Obrigatória
                    </div>
                </div>

            </div>
            <div class="col-lg-9 columnQuestoes">
                <a href="https://hlink.pt/" target="_blank">
                    <img class="float-end pe-5" src="{{ asset('assets/imgs/logo-hlink.png') }}" alt=""
                        style="width: 200px;">
                </a>
                <div class="d-flex mt-4 mb-4 align-items-center">
                    <div class="titleHlink me-5">Questões</div>
                </div>
                @for ($i = 0; $i < count($arrCateg); $i++)
                    <div class="rowCatGeral" id="divCategoria_{{ $arrCateg[$i]->id }}">
                        <div class="mb-2 px-3 questoesCatNome" id="categoria_id{{ $arrCateg[$i]->id }}">
                            {{ $arrCateg[$i]->nome }}
                        </div>
                        <div class="linhaQuestoes"></div>
                        @php
                            $countQuest = 1;
                            if (Auth::user()) {
                                $userTipo = Auth::user()->tipo;
                            } else {
                                $userTipo = 1;
                            }
                            $questoes = $arrCateg[$i]->Questoes;
                        @endphp
                        @foreach ($questoes as $questao)
                            @php
                                $respostas = $questao->Respostas;
                                $tipoExiste = $questao->checkTipo($userTipo);
                            @endphp
                            @if ($tipoExiste)
                                @if (count($questao->Respostas) > 1)
                                    <div class="ps-3 pt-3 {{ $questao->obrigatoria != 0 ? 'obgt' : '' }} {{ $questao->multiresposta != 0 ? 'multi' : '' }}"
                                        id="divPerguntas" idPer="{{ $questao->id }}">
                                        <div class="text-muted">
                                            {{ sprintf('%02d', $countQuest++) }}/{{ $countQuestForCat[$i] }}
                                        </div>
                                        <div class="d-flex">
                                            <div class="color-hlink tituloPergunta pe-2"
                                                id="questao_id{{ $questao->id }}">
                                                {{ $questao->nome }}
                                                @if ($questao->obrigatoria == 0)
                                                @else
                                                    <span style="color: red">*</span>
                                                @endif
                                            </div>
                                            @if ($questao->info == null)
                                            @else
                                                <button type="button" class="btn infoTooltip" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ $questao->info }}">
                                                    <i class="fa-solid fa-circle-question" style="color: #ada4fe;"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <div class="mt-3 ps-4 allRespostasFromQuestion"
                                            id="opcoesResposta_id{{ $questao->id }}">
                                            @foreach ($respostas as $resposta)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input resposta" type="{{ !$questao->multiresposta ? 'radio' : 'checkbox'}}"
                                                        value="{{ $resposta->id }}"
                                                        name="respostas_quest{{ $questao->id }}"
                                                        id="resposta_{{ $resposta->id }}" />
                                                    <label class="form-check-label" for="resposta_{{ $resposta->id }}">
                                                        {{ $resposta->nome }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endfor
                <div class="row py-4">
                    <span class="col-6">
                        <span class="p-3 spanSubmitQuestButton disabledBtn">
                            <form method="POST" action="{{ route('feResultado.store') }}">
                                @csrf
                                <input type="hidden" name="idsRespostas" value="" id="inputHidden">
                                <input type="submit" value="SUBMETER" class="btn btn-primary submitQuestButton disabled">
                            </form>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/questionario.js') }}"></script>
@endsection
