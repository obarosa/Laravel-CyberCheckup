@extends('frontoffice.master')
@section('title', 'HLink CyberCheckup')
@section('content')
    <div class="container-fluid">
        <div class="row mx-auto">
            <img class="float-end pe-5 pb-4" src="{{ asset('assets/imgs/logo-hlink.png') }}" alt=""
                 style="width: 200px;">
            <div class="d-flex mt-4 mb-4 align-items-center">
                <div class="titleHlink ps-3">Análise Detalhada</div>
            </div>
            @for ($i = 0; $i < count($respostas); $i++)
                <div class="rowCatGeral">
                    @if ($i == 0)
                        <div class="mb-2 mt-4 questoesCatNome pdfLay">
                            {{ $respostas[$i]->Questao->Categoria->nome }}
                            <span class="ms-3">
                                {{ floor($pontosPorCateg[$respostas[$i]->Questao->Categoria->id]) }}

                            </span>
                        </div>
                    @elseif ($respostas[$i]->Questao->Categoria->id != $respostas[$i - 1]->Questao->Categoria->id)
                        <div class="mb-2 mt-4 questoesCatNome pdfLay">
                            {{ $respostas[$i]->Questao->Categoria->nome }}
                            <span class="ms-3">
                                {{ floor($pontosPorCateg[$respostas[$i]->Questao->Categoria->id]) }}
                            </span>
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
                        <div class="">
                            <div class="text-muted">
                                {{ sprintf('%02d', $count += 1) }}/{{ sprintf('%02d', $questCount) }}
                            </div>
                        </div>
                        <div class="color-hlink tituloPergunta">{{ $respostas[$i]->Questao->nome }}</div>
                        <div>{{ $respostas[$i]->nome }}</div>
                    @else
                        <div class="">
                            <div class="text-muted">
                            @if($i == 0)
                                    {{ sprintf('%02d', $count += 1) }}/{{ sprintf('%02d', $questCount) }}
                                </div>
                            </div>
                            <div class="color-hlink tituloPergunta">{{ $respostas[$i]->Questao->nome }}</div>
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
                </div>
            @endfor
        </div>
        <img class="mt-3" src={{ $pngChart }} alt="">
    </div>
    <script src="{{ asset('js/resultado.js') }}"></script>
@endsection
