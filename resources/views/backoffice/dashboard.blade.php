@extends('backoffice.master')
@section('title', 'Dashboard')
@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
        {{-- ---- ALERTAS ---- --}}
        @if (session('status'))
            <div class="alert alert-success col-6 mt-2" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="alert alert-success col-9 mt-2 m-auto" role="alert" id="alertSucessoCustom" style="display: none">
        </div>
        @if (session('erro'))
            <div class="alert alert-danger col-6 mt-2" role="alert">
                {{ session('erro') }}
            </div>
        @endif

        <div class="pt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form action="{{ route('importar.excel') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="formFile" class="form-label">Importar ficheiro excel:</label>
                            <div class="d-flex">
                                <div class="col-4">
                                    <input type="file" class="form-control" name="file" id="formFile" accept=".xlsx">
                                </div>
                                <button type="submit" id="btnSubmitExcel" class="btn btn-primary ms-3"
                                    style="display: none">Importar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <label for="exampleInputEmail1" class="form-label">Email para receber dados:</label>
                        <div class="d-flex">
                            <div class="col-4">
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <button type="submit" class="btn btn-primary ms-3" id="alterarEmail">Alterar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>
    <script src="{{ asset('/js/dashboard.js') }}"></script>
@endsection
