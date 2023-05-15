@extends('frontoffice.master')
@section('title', 'HLink CyberCheckup')
@section('content')
    <section id="esconder" class="bghide">
        <nav class="navbar fixed-top navbar-light bg-hlink px-5" style="height: 70px;padding-left:5rem!important">
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
                <div class="col-lg-8 px-5 pb-5" style="padding-top: 7rem!important;padding-left:5rem!important">
                    <a href="https://hlink.pt/" target="_blank">
                        <img class="float-end pe-5" src="{{ asset('assets/imgs/logo-hlink.png') }}" alt=""
                            style="width: 200px;">
                    </a>
                    <div class="d-flex mt-4 mb-4 align-items-center">
                        <div class="titleHlink me-5">Análise Detalhada</div>
                        <form method="POST" action="{{ route('pdf.create') }}">
                            @csrf
                            <input type="submit" value="Exportar PDF" class="btn btn-sm-hlink">
                        </form>
                    </div>
                    @for ($i = 0; $i < count($respostas); $i++)
                        <div class="rowCatGeral">
                            @if ($i == 0)
                                <div class="btn btn-Cathlink resultCategoriasDisplay mb-3 px-3"
                                    id="categoria_id{{ $respostas[$i]->Questao->Categoria->id }}">
                                    {{ $respostas[$i]->Questao->Categoria->nome }} <span
                                        class="text-right">{{ round($pontosPorCateg[$respostas[$i]->Questao->Categoria->id], 0, PHP_ROUND_HALF_DOWN) }}</span>
                                </div>
                            @elseif ($respostas[$i]->Questao->Categoria->id != $respostas[$i - 1]->Questao->Categoria->id)
                                <div class="btn btn-Cathlink resultCategoriasDisplay mb-3 px-3"
                                    id="categoria_id{{ $respostas[$i]->Questao->Categoria->id }}">
                                    {{ $respostas[$i]->Questao->Categoria->nome }} <span
                                        class="text-right">{{ round($pontosPorCateg[$respostas[$i]->Questao->Categoria->id], 0, PHP_ROUND_HALF_DOWN) }}</span>
                                </div>
                            @endif
                            @php
                                $questCount = $countQuests[$respostas[$i]->Questao->Categoria->id];

                                if ($i == 0) {
                                    $count = 0;
                                } elseif ($respostas[$i]->Questao->Categoria->id != $respostas[$i - 1]->Questao->Categoria->id) {
                                    $count = 0;
                                }
                            @endphp
                            @if (!$respostas[$i]->Questao->multiresposta)
                                <div class="ps-3">
                                    <div class="text-muted contagemPerguntas">
                                        {{ sprintf('%02d', $count += 1) }}/{{ sprintf('%02d', $questCount) }}</div>
                                    <div class="color-hlink tituloPergunta">{{ $respostas[$i]->Questao->nome }}</div>
                                    <div>{{ $respostas[$i]->nome }}</div>
                                </div>
                            @else
                                <div class="ps-3">
                                    <div class="text-muted contagemPerguntas">
                                        @if ($i == 0)
                                            {{ sprintf('%02d', $count += 1) }}/{{ sprintf('%02d', $questCount) }}
                                    </div>
                                    <div class="color-hlink tituloPergunta">
                                        {{ $respostas[$i]->Questao->nome }}
                                    </div>
                                @elseif($respostas[$i]->Questao->id != $respostas[$i - 1]->Questao->id)
                                    {{ sprintf('%02d', $count += 1) }}/{{ sprintf('%02d', $questCount) }}
                                </div>
                                <div class="color-hlink tituloPergunta">{{ $respostas[$i]->Questao->nome }}</div>
                            @else
                        </div>
                    @endif
                    <div>{{ $respostas[$i]->nome }}</div>
                </div>
                @endif
            </div>
            @endfor
        </div>

        {{-- Gráfico --}}
        <div class="col-lg-4 bg-resultados-right" style="margin-top: 4em!important;">
            <div class="d-flex flex-column justify-content-center sticky-top overflow-auto"
                style=" height: 100vh; width: 100%;">
                <div class="text-center pb-3 titleHlink">Resultados</div>
                <div class="d-flex justify-content-center">
                    <canvas class="mb-2" id="myChart" style="max-height: 25em!important;max-width: 25em!important;">
                    </canvas>
                </div>
                <div class="row mx-auto resultCategoriasDisplay py-3">
                    @for ($i = 0; $i < count($respostas); $i++)
                        @if ($i == 0)
                            <a href="#categoria_id{{ $respostas[$i]->Questao->Categoria->id }}"
                                class="btn btn-Cathlink mb-2 px-3" style="cursor: pointer">
                                {{ $respostas[$i]->Questao->Categoria->nome }} <span
                                    class="text-right">{{ round($pontosPorCateg[$respostas[$i]->Questao->Categoria->id], 0, PHP_ROUND_HALF_DOWN) }}</span>
                            </a>
                        @elseif ($respostas[$i]->Questao->Categoria->id != $respostas[$i - 1]->Questao->Categoria->id)
                            <a href="#categoria_id{{ $respostas[$i]->Questao->Categoria->id }}"
                                class="btn btn-Cathlink mb-2 px-3" style="cursor: pointer">
                                {{ $respostas[$i]->Questao->Categoria->nome }} <span
                                    class="text-right">{{ round($pontosPorCateg[$respostas[$i]->Questao->Categoria->id], 0, PHP_ROUND_HALF_DOWN) }}</span>
                            </a>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>

    {{-- MODAL --}}
    <div class="modal" data-bs-backdrop="static" data-bs-keyboard="false" id="modalSubmeter" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Por favor preencha os seguintes campos para poder ver os seus resultados</h5>
                </div>
                <div class="modal-body">
                    <label for="guestName">Primeiro Nome e Apelido:<span style="color: red">*</span></label>
                    <input id="guestName" type="text" class="form-control">
                    <label for="guestContacto" class="mt-2">Contacto: </label>
                    <input id="guestContacto" type="number" class="form-control">
                    <label for="guestEmail" class="mt-2">Email:<span style="color: red">*</span></label>
                    <input id="guestEmail" type="email" class="form-control">
                    <div class="mt-2"><span style="color: red">*</span><span class="text-muted fs-6">Obrigatório</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="cancelarResultadoGuest" href="{{ route('feHome.index') }}"
                        class="btn btn-secondary close">Cancelar</a>
                    <button id="btnGuardarResultadoGuest" class="btn btn-primary">Submeter</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/resultado.js') }}"></script>
@endsection
