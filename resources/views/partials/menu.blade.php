<nav class="bg-blue-500 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Kategorien Menua -->
        <ul class="flex space-x-4">
            <li>
                <a href="{{ route('challenges.index', ['category_id' => 0]) }}" class="text-white hover:text-blue-200">Guztiak</a>
            </li>
           
            <li>
                <a href="{{ route('challenges.index', ['category_id' => 1]) }}" class="text-white hover:text-blue-200">
                    Aisialdia *
                </a>
                <a href="{{ route('challenges.index', ['category_id' => 2]) }}" class="text-white hover:text-blue-200">
                    Irakurketa *
                </a>
                <a href="{{ route('challenges.index', ['category_id' => 3]) }}" class="text-white hover:text-blue-200">
                    Kirola *
                </a>
                <a href="{{ route('challenges.index', ['category_id' => 4]) }}" class="text-white hover:text-blue-200">
                    Kultura *
                </a>
                <a href="{{ route('challenges.index', ['category_id' => 5]) }}" class="text-white hover:text-blue-200">
                    Osasuna *
                </a>
            </li>
           
        </ul>

        <!-- Login/Logout atala-->
        <div>
            @auth
                <span class="mr-4 text-white">
                    Ongi etorri, <a href="{{ route('user.challenges', auth()->user()->id) }}"><strong>{{ auth()->user()->name }}</strong></a>
                </span>

                
                <a href="" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 mr-2">
                    Erronka Igo
                </a>

                <span class="mr-2 text-white">
                        Logout
                    </button>
                </span>
            @else
                <a href="{{ route('login.form') }}" class="bg-yellow-400 text-gray-800 px-4 py-2 rounded-lg hover:bg-yellow-500">
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>




