<div x-data="{ sidebarOpen: false }" class="relative">
    <!-- Mobile sidebar toggle button dengan animasi -->
    <button @click="sidebarOpen = !sidebarOpen"
            class="lg:hidden fixed top-4 left-4 z-50 p-2 rounded-md bg-green-500 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Overlay dengan animasi fade -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>

    <!-- Sidebar content dengan animasi dan scroll yang lebih baik -->
    <aside x-cloak
           :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
           class="fixed left-0 top-0 w-72 h-full bg-white shadow-xl z-40 transform transition-transform duration-300 ease-in-out lg:translate-x-0 overflow-hidden">
        <div class="flex flex-col h-full">
            <!-- Logo area dengan hover state -->
            <div class="p-4 border-b bg-green-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                        <h1 class="text-xl font-semibold text-white">
                            Parking Vision
                        </h1>
                    </div>
                    <!-- Close button mobile dengan animasi hover -->
                    <button @click="sidebarOpen = false"
                            class="text-white lg:hidden p-1 rounded-full hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation dengan ikon dan indikator aktif -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-green-500' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <div class="pt-4 border-t mt-2">
                    <h5 class="px-4 text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Parking Management</h5>
                    <a href="{{ route('admin.petugas.index') }}"
                       class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.petugas.*') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('admin.petugas.*') ? 'text-green-500' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Manajemen Data Petugas</span>
                    </a>

                    <a href="{{ route('admin.parkir.index') }}"
                       class="flex items-center px-4 py-3 mt-2 text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.parkir.*') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('admin.parkir.*') ? 'text-green-500' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10h14a2 2 0 110 4H5a2 2 0 110-4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20V4M3 20V4M21 16H3M21 8H3" />
                        </svg>
                        <span>Manajemen Data Parkir</span>
                    </a>
                </div>

                {{-- <div class="pt-4 border-t mt-2">
                    <h5 class="px-4 text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Reports</h5>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Usage Reports</span>
                    </a>
                </div> --}}
            </nav>

            <!-- User Profile dengan animasi dan interaksi yang lebih baik -->
            <div class="p-4 border-t bg-gray-50">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center shadow-sm">
                        <span class="text-sm font-medium text-green-800">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-700">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ Auth::user()->is_admin ? 'Administrator' : 'Petugas' }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-sm bg-white px-3 py-1.5 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors duration-200 shadow-sm">
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>
</div>
