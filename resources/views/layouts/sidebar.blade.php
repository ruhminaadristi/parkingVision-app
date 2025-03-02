<aside class="fixed left-0 top-0 w-64 h-full bg-white shadow-lg">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="p-4 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                Parking Vision
            </h1>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                <span>Dashboard</span>
            </a>

            <div class="pt-4 border-t">
                <h5 class="px-4 text-sm font-medium text-gray-500">Parking Management</h5>
                <a href="#" class="flex items-center px-4 py-2 mt-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <span>Manajemen Data Petugas</span>
                </a>
            </div>

            {{-- <div class="pt-4 border-t">
                <h5 class="px-4 text-sm font-medium text-gray-500">Reports</h5>
                <a href="#" class="flex items-center px-4 py-2 mt-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <span>Usage Reports</span>
                </a>
            </div> --}}
        </nav>

        <!-- User Profile -->
        <div class="p-4 border-t">
            <div class="flex items-center space-x-3">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-700">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        Administrator
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
