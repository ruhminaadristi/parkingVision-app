@extends('layouts.app')

@section('content')
<div class="px-6 pb-6 pt-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Test Koneksi Firebase</h1>
            <p class="text-gray-500 text-sm">Memeriksa koneksi ke Firebase Realtime Database</p>
        </div>

        <div class="mt-3 sm:mt-0 flex items-center gap-3">
            <a href="{{ route('admin.parkir.index') }}" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Hasil Test Koneksi -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Status Koneksi</h2>
        
        <div class="mb-6 p-4 {{ $connectionStatus['success'] ? 'bg-green-50 border-l-4 border-green-500' : 'bg-red-50 border-l-4 border-red-500' }} rounded">
            <div class="flex items-center">
                @if($connectionStatus['success'])
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-green-800">{{ $connectionStatus['message'] }}</p>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-red-800">{{ $connectionStatus['message'] }}</p>
                @endif
            </div>
        </div>

        @if($connectionStatus['success'] && $connectionStatus['data'])
            <div class="mt-4">
                <h3 class="text-md font-medium text-gray-700 mb-2">Data yang diterima:</h3>
                <div class="p-4 bg-gray-50 rounded overflow-auto max-h-60">
                    <pre class="text-sm text-gray-800">{{ json_encode($connectionStatus['data'], JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        @endif

        <div class="mt-6">
            <h3 class="text-md font-medium text-gray-700 mb-2">Konfigurasi Firebase:</h3>
            <div class="p-4 bg-gray-50 rounded">
                <p class="mb-2"><span class="font-semibold">URL Database:</span> {{ config('firebase.database.url') }}</p>
                <p><span class="font-semibold">SSL Verify:</span> {{ config('firebase.database.ssl_verify') ? 'Aktif' : 'Nonaktif' }}</p>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-center">
            <a href="{{ route('admin.parkir.test-connection') }}" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Coba Lagi
            </a>
        </div>
    </div>
    
    <!-- Troubleshooting -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Troubleshooting</h2>
        
        <div class="space-y-4">
            <div>
                <h3 class="text-md font-medium text-gray-700">1. Nonaktifkan SSL Verification</h3>
                <p class="text-gray-600">
                    Jika terjadi error SSL, kami sudah menonaktifkan verifikasi SSL secara otomatis untuk lingkungan pengembangan.
                </p>
            </div>
            
            <div>
                <h3 class="text-md font-medium text-gray-700">2. Cek URL Firebase</h3>
                <p class="text-gray-600">
                    Pastikan URL Firebase yang dikonfigurasi sudah benar: <code class="px-2 py-1 bg-gray-100 rounded text-sm">{{ config('firebase.database.url') }}</code>
                </p>
            </div>
            
            <div>
                <h3 class="text-md font-medium text-gray-700">3. Periksa Aturan Keamanan Firebase</h3>
                <p class="text-gray-600">
                    Pastikan aturan keamanan Firebase memperbolehkan akses baca dan tulis dari aplikasi Anda.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection 