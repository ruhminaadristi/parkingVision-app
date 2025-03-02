<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @auth
            @include('layouts.sidebar')
            <main class="lg:ml-64">
                <div class="p-4">
                    @yield('content')
                </div>
                @include('layouts.footer')
            </main>
        @else
            <main>
                @yield('content')
                @include('layouts.footer')
            </main>
        @endauth
    </div>
    @stack('scripts')
</body>
</html>
