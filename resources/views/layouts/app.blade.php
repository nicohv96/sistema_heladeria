<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/css/main.css', 'resources/js/app.js'])
    @include('layouts.head')
</head>

<body>
    
    <div class="container-fluid p-0">
        <main class="d-flex flex-row p-0">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Contenido del main -->
            <div class="d-flex flex-column flex-grow-1 p-0 overflow-hidden">
                <!-- Navbar -->
                @include('layouts.header')

                <div class="d-flex flex-column flex-grow-1 px-4 py-2 overflow-hidden">
                    <!-- Tables -->
                    @yield('content')
                </div>
            </div>
        </main>
        <!-- Footer -->
        @include('layouts.footer')

        <!-- Scripts -->
        @include('layouts.scripts')
    </div>

</body>

</html>