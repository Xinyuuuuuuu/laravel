<nav class="bg-blue-500 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Kategorien Menua -->
        <ul class="flex space-x-4">
            <li><a href="{{ route('challenges.index', ['category_id' => 0]) }}">Todos</a></li>

            <!-- $categories se obtiene en App\Providers\AppServiceProvider.php -->
            @foreach ($categories as $cat)
                <!-- genera url /1 con id -->
                <!-- muestra name de cada categoria en el menu -->
                <li><a href="{{ route('challenges.index', ['category_id' => $cat->id]) }}">{{ $cat->name }}</a></li>
            @endforeach

        </ul>

        <!-- Login/Logout atala-->
        <div>
            @auth
                <span class="mr-4 text-white">
                    Ongi etorri, <a
                        href="{{ route('user.challenges', auth()->user()->id) }}"><strong>{{ auth()->user()->name }}</strong></a>
                </span>


                <a href="{{ route('challenges.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 mr-2">
                    Subir reto
                </a>

                <a href="{{ route('user.edit', auth()->user()->id) }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 mr-2">
                    Editar perfil
                </a>

                <!-- Cerrar sesión con metodo POST, post es de <form> -->
                <form action="{{ route('logout') }}" method="POST" class="inline">

                    @csrf

                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                        Logout
                    </button>
                </form>

            @else
                <a href="{{ route('login.form') }}"
                    class="bg-yellow-400 text-gray-800 px-4 py-2 rounded-lg hover:bg-yellow-500">
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>