@extends('backoffice.master')
@section('title', 'Perfil')
@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Painel do Utilizador') }}
            </h2>

        </x-slot>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        As minhas submissões
                        <table id="tableTentativas" class="table">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tentativas as $tentativa)
                                <tr>
                                    <td>{{ date('d/m/Y H:i', strtotime($tentativa->created_at)) }}</td>
                                    <td>
                                        <a id="tentativa_{{$tentativa->id}}" href="{{ route('utilizador.tentativa', $tentativa->id) }}" class="btn btn-sm btn-primary btshowtentativa"><i class="fa fa-eye"></i></a>
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
@endsection
