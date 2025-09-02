@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-white">
        Dashboard
        <div>
            Bem-vindo, {{ auth()->user()->name }} ({{ auth()->user()->email }})
            <form method="POST" action="{{ route('logout') }}" class="">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">Sair</button>
            </form>
        </div>
    </h1>
@endsection