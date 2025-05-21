@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <!-- Título del reto -->
    <h1 class="text-3xl font-bold text-blue-600 mb-4">{{ $challenge->title }}</h1>

    <!-- Descripción del reto -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <p class="text-gray-700">{{ $challenge->description }}</p>
    </div>

    <!-- Detalles adicionales -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Puntos -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold text-gray-700">Puntuak</h2>
            <p class="text-gray-500">{{ $challenge->points }} puntuak</p>
        </div>

        <!-- Fechas -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold text-gray-700">Datak</h2>
            <p class="text-gray-500">
                <strong>Hasiera data:</strong> {{ $challenge->start_date }}<br>
                <strong>Bukaera data:</strong> {{ $challenge->end_date }}
            </p>
        </div>
    </div>

    <!-- Categorías -->
    <div class="mt-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Kategoria</h2>
        <div class="flex flex-wrap gap-2">
          
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ $challenge->category->name }}
                </span>
          
        </div>
    </div>

    @auth
    @if (!$challenge->users->contains(auth()->user()))
        <form action="{{ route('challenges.join', $challenge->id) }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                Erronkan apuntatu
            </button>
        </form>
    @else
        {{-- <p class="mt-4 text-green-600 font-semibold">Erronkan apuntatuta zaude.</p> --}}

        @php
            $userChallenge = $challenge->users->where('id', auth()->id())->first();
            $status = $userChallenge ? $userChallenge->pivot->status : 'pendiente';

        @endphp

        <div class="mt-4 flex items-center">
            @if ($status === 'completado')
                <img src="{{ asset('images/completed.png') }}" alt="Completado" class="w-12 h-12 mr-2">
                <p class="text-green-600 font-semibold">Erronka osatuta dago. {{ date('Y-m-d H:i', strtotime($userChallenge->pivot->completed_at)) }}</p>
            @elseif ($status === 'fallido')
                <img src="{{ asset('images/failed.png') }}" alt="Fallido" class="w-12 h-12 mr-2">
                <p class="text-red-600 font-semibold">Erronka huts eginda dago.</p>
            @else
                <img src="{{ asset('images/pending.png') }}" alt="Pendiente" class="w-12 h-12 mr-2">
                <p class="text-yellow-600 font-semibold">Erronka oraindik egin gabe dago.</p>
            @endif
        </div>

    @endif
@endauth

    <!-- Botón para volver -->
    <div class="mt-6">
        <a href="{{ route('challenges.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            ← Erronken zerrendara bueltatu
        </a>
    </div>
</div>
@endsection