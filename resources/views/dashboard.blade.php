@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div>
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-white">
        Dashboard
    </h1>
    <div class="mb-6 flex flex-col items-center justify-center">
        Bem-vindo, {{ auth()->user()->name }} ({{ auth()->user()->email }})
        <form method="POST" action="{{ route('logout') }}" class="">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">Sair</button>
        </form>
    </div>
    <div class="container mx-auto">
        <div class="mt-6 flex flex-col items-center justify-center bg-white border border-gray-200 rounded-2xl shadow-md dark:bg-gray-800 dark:border-gray-700">
            <table class="table-auto">
                <thead class="text-xs text-white uppercase bg-blue-500 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Cliente</th>
                        <th scope="col" class="px-6 py-3">Produto</th>
                        <th scope="col" class="px-6 py-3">Quantidade</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Data de venda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-4">{{ $sale->user->name }}</td>
                            <td class="px-6 py-4">{{ $sale->product->name }}</td>
                            <td class="px-6 py-4">{{ $sale->quantity }}</td>
                            <td class="px-6 py-4">{{ $sale->total }}</td>
                            <td class="px-6 py-4">{{ $sale->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Nenhuma venda encontrada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection