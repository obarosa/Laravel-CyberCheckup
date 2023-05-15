@extends('backoffice.master')
@section('title', 'Tentativa')
@section('content')
    <x-app-layout>
        <div class="app"></div>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a id="voltar" href="{{ url()->previous() }}" class="btn btn-secondary mr-2">Voltar</a>
                {{ __('Tentativa') }}
            </h2>
        </x-slot>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="d-flex mb-2">
                    <form method="POST" action="{{ route('excel.export') }}">
                        @csrf
                        <input type="submit" value="Exportar Excel" class="btn btn-sm-hlink">
                    </form>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @foreach ($categorias as $categoria)
                            <div class="rowCatGeral mt-4">
                                <div class="btn btn-Cathlink resultCategoriasDisplay px-3">
                                    {{ $categoria->categoria }}<span
                                        class="text-right resultMediaDisplay">{{ $categoria->media }}</span>
                                </div>
                            </div>
                            @php
                                $count = 0;
                                $categs = $categoria->Respondidas
                            @endphp
                            @foreach ($categs as $key => $respondidas)
                                <div class="ps-3 mb-2">
{{--                            Contagem<div class="text-muted contagemPerguntas">--}}
{{--                                        {{ sprintf('%02d', $count += 1) }}/{{ sprintf('%02d', count($categoria->Respondidas)) }}--}}
{{--                                    </div>--}}
                                    @if($key == 0)
                                        <div class="color-hlink tituloPergunta">{{ $respondidas->pergunta }}</div>
                                        @if ($respondidas->pontos == null)
                                            <div>{{ $respondidas->resposta }}</div>
                                        @else
                                            <div>{{ $respondidas->resposta }} <span
                                                    class="badge rounded-pill bg-info">{{ $respondidas->pontos }}</span>
                                            </div>
                                        @endif
                                    @elseif($categs[$key]->pergunta == $categs[$key - 1]->pergunta)
                                        <div>{{ $respondidas->resposta }}</div>
                                    @else
                                        <div class="color-hlink tituloPergunta">{{ $respondidas->pergunta }}</div>
                                        @if ($respondidas->pontos == null)
                                            <div>{{ $respondidas->resposta }}</div>
                                        @else
                                            <div>{{ $respondidas->resposta }} <span
                                                    class="badge rounded-pill bg-info">{{ $respondidas->pontos }}</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <canvas class="d-flex mb-2 align-self-center" id="myChart" width="500" height="500"
                                style="max-height: 25em!important;max-width: 25em!important;">
                            </canvas>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </x-app-layout>
    <script src="{{ asset('/js/respondidas.js') }}"></script>
@endsection
