@extends('backoffice.master')
@section('title', 'Tentativas')
@section('content')
    <x-app-layout>
        <div class="app"></div>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a id="voltar" href="{{ route('users.index') }}" class="btn btn-secondary mr-2">Voltar</a>
                {{ __('Tentativas') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table id="tableTentativas" class="table">
                            <thead>
                                <tr>
                                    <th>ID Tentativa</th>
                                    <th>Tipo de Utilizador</th>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tentativas as $tentativa)
                                    <tr>
                                        <td>{{ $tentativa->id }}</td>
                                        <td>{{ $tentativa->usertipo }}</td>
                                        <td>{{ date('d/m/Y', strtotime($tentativa->created_at)) }}</td>
                                        <td>{{ date('H:i', strtotime($tentativa->created_at)) }}</td>
                                        <td>
                                            <a id="tentativa_{{ $tentativa->id }}"
                                                href="{{ route('tentativas.show', $tentativa->id) }}"
                                                class="btn btn-sm btn-primary btshowtentativa"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>
    <script src="{{ asset('/js/tentativas.js') }}"></script>
@endsection
