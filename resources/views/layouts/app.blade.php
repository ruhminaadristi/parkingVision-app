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

    <style>
        [x-cloak] { display: none !important; }

        /* Kustomisasi scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 2px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col">
        @auth
            @include('layouts.sidebar')
            <main class="flex-1 flex flex-col transition-all duration-300 lg:ml-72">
                <!-- Header/Navbar mobile -->
                <header class="lg:hidden bg-white shadow-sm p-4 mb-4 flex items-center justify-center">
                    <h1 class="text-lg font-medium text-gray-800">
                        {{ config('app.name', 'Laravel') }}
                    </h1>
                </header>

                <div class="flex-1 flex flex-col p-4 pt-16 lg:pt-6">
                    <!-- Breadcrumb pada desktop -->
                    <div class="hidden lg:flex mb-6 text-sm">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700"></a>
                        @hasSection('breadcrumb')
                            <span class="mx-2 text-gray-400">/</span>
                            @yield('breadcrumb')
                        @endif
                    </div>

                    @yield('content')
                </div>
                @include('layouts.footer')
            </main>
        @else
            <main class="flex-1 flex flex-col">
                @yield('content')
            </main>
        @endauth
    </div>
    @stack('scripts')
</body>
</html>
