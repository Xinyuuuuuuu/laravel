@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">{{ $user->name }} erabiltzailearen Erronkak</h1>

        <!-- Filtro de estados -->
        <form method="GET" class="mb-6">
            <label for="status" class="font-semibold mr-2">Filtrar por estado:</label>
            <select name="status" id="status" onchange="this.form.submit()" class="border rounded px-2 py-1">
                <option value="">-- Todos --</option>
                @foreach ($availableStatuses as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </form>


        <!-- Lista de retos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($challenges as $challenge)
                <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-700">{{ $challenge->title }}</h2>
                    <p class="text-gray-500 mt-2">{{ $challenge->description ?? 'No description available' }}</p>

                    <!-- Estado del reto -->
                    <div class="mt-4">
                        <span
                            class="text-sm font-medium {{ $challenge->pivot->status === 'completado' ? 'text-green-600' : ($challenge->pivot->status === 'fallido' ? 'text-red-600' : 'text-yellow-600') }}">
                            {{ ucfirst($challenge->pivot->status) }}
                        </span>

                        @if ($challenge->pivot->status === 'completado')
                            <p class="text-green-500 text-sm mt-1 italic">
                                Amaituta: {{ date('Y-m-d H:i', strtotime($challenge->pivot->completed_at)) }}
                            </p>
                        @endif
                    </div>

                    <!-- Botones para cambiar el estado -->
                    @if ($challenge->pivot->status === 'pendiente')
                        <div class="mt-4 flex gap-2">
                            <form action="{{ route('user.challengestatus', ['user' => $user->id, 'challenge' => $challenge->id]) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completado">
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                    Completado
                                </button>
                            </form>

                            <form action="{{ route('user.challengestatus', ['user' => $user->id, 'challenge' => $challenge->id]) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="fallido">
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                    Fallido
                                </button>
                            </form>
                        </div>
                    @endif

                    @if ($challenge->pivot->status === 'fallido')
                        <div class="mt-4 flex gap-2">
                            <!-- Volver a apuntar -->
                            <form action="{{ route('user.challengeretry', ['user' => $user->id, 'challenge' => $challenge->id]) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                                    Volver a apuntar
                                </button>
                            </form>

                            <!-- Eliminar reto -->
                            <form
                                action="{{ route('user.challengeDestroy', [$user, $challenge]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @endif


                    <!-- Enlace a los detalles del reto -->
                    <a href="{{ route('challenges.show', $challenge) }}"
                        class="mt-4 inline-block text-blue-500 hover:underline">
                        Erronka ikusi →
                    </a>
                </div>
            @endforeach
        </div>

        <br>
        <!-- Badges -->
        @if ($badges->isNotEmpty())
            <h2 class="text-2xl font-bold text-blue-600 mt-8 mb-4">Badges</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($badges as $badge)
                    <div class="bg-white shadow-md rounded-lg p-6 text-center border border-gray-200">
                        <img src="{{ asset('images/' . $badge->image) }}" alt="{{ $badge->name }}" class="w-20 h-20 mx-auto mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $badge->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $badge->description }}</p>
                    </div>
                @endforeach
            </div>
        @endif
        <!-- Si no ponemos el else, por default no muestra nada -->


    </div>
@endsection