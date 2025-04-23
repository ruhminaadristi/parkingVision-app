<footer class="bg-white border-t mt-auto lg:fixed bottom-0 right-0 left-0 py-2 lg:left-72 z-50">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4">
            <!-- Bagian Bawah Footer -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <p class="text-sm text-gray-600">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                    </p>
                    <span class="hidden md:inline text-gray-300">|</span>
                    <div class="text-sm text-gray-600">
                        Developed by
                        <a href="#" class="text-green-600 hover:text-green-700 font-medium transition-colors duration-200">
                            Ruhmina Adristi
                        </a>
                    </div>
                </div>

                <!-- Versi Aplikasi -->
                <div class="mt-2 md:mt-0">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        Version 1.0.0
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
