@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-center mb-4">Editar perfil</h2>

        <!-- muestra la imagen de perfil si existe -->
        @if ($user->image)
            <img src="{{ asset('images/' . $user->image) }}" alt="Perfil" class="w-12 h-12 rounded-full mx-auto mb-4">
        @endif


        <form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block text-gray-700">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none">
            </div>

            <!-- Subir foto perfil -->
            <div class="mb-4">
                <label class="block text-gray-700">Foto de perfil</label>
                <input type="file" name="image" class="w-full px-3 py-2 border rounded-lg focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                Guardar cambios
            </button>
        </form>
    </div>
@endsection