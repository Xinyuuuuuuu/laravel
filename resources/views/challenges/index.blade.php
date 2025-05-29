@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">

        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6"> LISTA DE CHALLENGES - {{ $category }}</h1>

        <!-- Buscador por titulo -->
        <form method="GET" action="{{ route('challenges.index') }}" class="mb-6 flex justify-center">
            <input type="text" name="search" placeholder="Buscar por título..." value="{{ request('search') }}"
                class="border rounded-l px-4 py-2 w-1/2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600">
                Buscar
            </button>
        </form>


        <!-- Lista de Challenges -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($challenges as $challenge)
                <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-700">{{ $challenge->title }}</h2>
                    <p class="text-gray-500 mt-2">{{ $challenge->description ?? 'No description available' }}</p>

                    <a href="{{ route('challenges.show', $challenge) }}"
                        class="mt-4 inline-block text-blue-500 hover:underline">Ver reto →</a>
                </div>
            @empty
                <p class="text-center text-gray-500 col-span-full">No hay retos de esta categoría.</p>
            @endforelse
        </div>
        {{ $challenges->links() }}
    </div>
@endsection