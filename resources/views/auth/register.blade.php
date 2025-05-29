@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-center mb-4">Registro</h2>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Nombre</label>
                <input type="text" name="name" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Contraseña</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">
                Registrarse
            </button>
        </form>
    </div>
@endsection
