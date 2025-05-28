@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Crear nuevo reto</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('challenges.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold" for="title">Título</label>
            <input type="text" name="title" id="title" class="w-full border px-3 py-2" value="{{ old('title') }}" required>
        </div>

        <div>
            <label class="block font-semibold" for="description">Descripción</label>
            <textarea name="description" id="description" class="w-full border px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block font-semibold" for="points">Puntos</label>
            <input type="number" name="points" id="points" class="w-full border px-3 py-2" value="{{ old('points') }}" required>
        </div>

        <div>
            <label class="block font-semibold" for="start_date">Fecha de inicio</label>
            <input type="date" name="start_date" id="start_date" class="w-full border px-3 py-2" value="{{ old('start_date') }}" required>
        </div>

        <div>
            <label class="block font-semibold" for="end_date">Fecha de fin</label>
            <input type="date" name="end_date" id="end_date" class="w-full border px-3 py-2" value="{{ old('end_date') }}" required>
        </div>

        <div>
            <label class="block font-semibold" for="category_id">Categoría</label>
            <select name="category_id" id="category_id" class="w-full border px-3 py-2" required>
                <option value="">Selecciona una categoría</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Guardar reto
            </button>
        </div>
    </form>
</div>
@endsection
