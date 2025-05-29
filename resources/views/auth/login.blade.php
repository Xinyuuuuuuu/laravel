@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-center mb-4">Login</h2>

        @if(session('error'))
            <p class="text-red-500 text-sm mb-4">{{ session('error') }}</p>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Emaila</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none"
                    required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                Iniciar sesión
            </button>
        </form>
        <div class="mt-4 text-center">
            <a href="{{ route('register.form') }}" class="text-blue-500 hover:underline">
                ¿No tienes cuenta? Regístrate aquí
            </a>
        </div>

    </div>
@endsection