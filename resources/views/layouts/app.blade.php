

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- @yield('title'): espera que una vista hija tenga title -->
    <title>@yield('title','2. erronkako Azterketa - Jone Martinez')</title> 
    @vite('resources/css/app.css') <!-- Asegura que Tailwind se cargue -->
</head>
<body class="bg-gray-100 text-gray-800">
    

  @if (!request()->routeIs('login.form'))
    @include('partials.menu')
  @endif


    <!-- Contenido de la página -->
    <main class="p-6">
        @yield('content')
    </main>
  @include('partials.footer')
</body>
</html>
