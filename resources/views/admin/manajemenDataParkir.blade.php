@extends('layouts.app')

@section('content')
<div class="px-4 pb-6 pt-2 sm:px-6">
    <!-- Header Section -->
    <div class="flex flex-col space-y-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-1">History Parkir</h1>
            <p class="text-gray-500 text-sm">Riwayat keluar masuk kendaraan di area parkir</p>
        </div>

        <!-- Action Buttons - Mobile First Design -->
        <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3">
            <!-- Tombol Unduh Data -->
            <a href="{{ route('admin.parkir.export') }}" class="flex items-center justify-center px-4 py-2 mb-2 sm:mb-0 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-sm text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Unduh Data
            </a>
            
            <!-- Tombol Sinkronisasi dari Firebase -->
            <a href="{{ route('admin.parkir.sync') }}" class="flex items-center justify-center px-4 py-2 mb-2 sm:mb-0 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-sm text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Sinkronisasi
            </a>
            
            <!-- Tombol Test Koneksi -->
            <a href="{{ route('admin.parkir.test-connection') }}" class="flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-sm text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Test Koneksi
            </a>
        </div>

        <!-- Date/Time Display - Responsive -->
        <div class="bg-white flex flex-col sm:flex-row sm:items-center rounded-lg shadow-sm px-3 py-2 text-sm space-y-1 sm:space-y-0">
            <span id="currentDateTime" class="text-gray-600 font-medium text-center sm:text-left"></span>
            <span class="hidden sm:inline mx-2 text-gray-400">|</span>
            <span id="currentDay" class="text-gray-600 text-center sm:text-left text-xs sm:text-sm"></span>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mb-6 border border-gray-100">
        <!-- Notification Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 text-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <!-- Debug Information (Only visible to admins) -->
        <div class="bg-gray-100 border border-gray-300 rounded-lg p-3 mb-4 text-xs">
            <div class="flex justify-between items-center">
                <h4 class="font-semibold text-gray-700">Debug Info</h4>
                <button onclick="document.getElementById('debugDetails').classList.toggle('hidden')" class="text-blue-600 hover:text-blue-800">Toggle Details</button>
            </div>
            <div id="debugDetails" class="hidden mt-2 space-y-2">
                <p><span class="font-medium">Total Records:</span> {{ $parkingHistories->total() }}</p>
                @if(isset($totalRecords))
                <p><span class="font-medium">Database Total:</span> {{ $totalRecords }}</p>
                @endif
                <p><span class="font-medium">Current Page:</span> {{ $parkingHistories->currentPage() }}</p>
                <p><span class="font-medium">Per Page:</span> {{ $parkingHistories->perPage() }}</p>
                <p><span class="font-medium">Has More Pages:</span> {{ $parkingHistories->hasMorePages() ? 'Yes' : 'No' }}</p>
                <p><span class="font-medium">First Item:</span> {{ $parkingHistories->firstItem() ?? 'None' }}</p>
                <p><span class="font-medium">Last Item:</span> {{ $parkingHistories->lastItem() ?? 'None' }}</p>
                <p><span class="font-medium">URL:</span> {{ url()->current() . '?' . http_build_query(request()->query()) }}</p>
            </div>
        </div>
        
        <form action="{{ route('admin.parkir.index') }}" method="GET">
            <div class="space-y-4">
                <!-- Date Filter Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="date-from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" id="date-from" name="date_from" value="{{ request('date_from') }}" class="border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 block w-full p-2 text-sm">
                    </div>
                    <div>
                        <label for="date-to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" id="date-to" name="date_to" value="{{ request('date_to') }}" class="border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 block w-full p-2 text-sm">
                    </div>
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1 sm:invisible">Filter</label>
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition text-sm">
                            Filter
                        </button>
                    </div>
                </div>

                <!-- Search Section -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Kendaraan</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Masukkan jenis kendaraan..." class="border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 block w-full p-2 pl-10 text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Mobile Card View -->
        <div class="block lg:hidden mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Parkir</h3>
            @forelse($parkingHistories as $index => $history)
                <div class="bg-gray-50 rounded-lg p-4 mb-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-500">#{{ $parkingHistories->firstItem() + $index }}</span>
                            <span class="px-2 py-1 {{ $history->vehicle_type == 'Mobil' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }} rounded-full text-xs font-medium">
                                {{ $history->vehicle_type }}
                            </span>
                        </div>
                        <span class="px-2 py-1 {{ $history->status == 'Parkir' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }} rounded-full text-xs font-medium">
                            {{ $history->status }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-500 block">Slot Parkir:</span>
                            <span class="px-2 py-1 {{ $history->vehicle_type == 'Mobil' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full text-xs font-medium">
                                {{ $history->slot_label }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Tanggal:</span>
                            <span class="font-medium">{{ $history->entry_time->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Jam Masuk:</span>
                            <span class="font-medium">{{ $history->entry_time->format('H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Jam Keluar:</span>
                            <span class="font-medium">{{ $history->exit_time ? $history->exit_time->format('H:i') : '-' }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-500 block">Durasi:</span>
                            <span class="font-medium">{{ $history->getFormattedDuration() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">Belum ada data parkir yang terekam</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block mt-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-t-lg">
                        <tr>
                            <th scope="col" class="py-3 px-4">No</th>
                            <th scope="col" class="py-3 px-4">Jenis</th>
                            <th scope="col" class="py-3 px-4">Slot Parkir</th>
                            <th scope="col" class="py-3 px-4">Tanggal</th>
                            <th scope="col" class="py-3 px-4">Jam Masuk</th>
                            <th scope="col" class="py-3 px-4">Jam Keluar</th>
                            <th scope="col" class="py-3 px-4">Durasi</th>
                            <th scope="col" class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parkingHistories as $index => $history)
                            <tr class="bg-white border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4">{{ $parkingHistories->firstItem() + $index }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 {{ $history->vehicle_type == 'Mobil' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }} rounded-full text-xs">
                                        {{ $history->vehicle_type }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 {{ $history->vehicle_type == 'Mobil' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full text-xs">
                                        {{ $history->slot_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">{{ $history->entry_time->format('d F Y') }}</td>
                                <td class="py-3 px-4">{{ $history->entry_time->format('H:i') }}</td>
                                <td class="py-3 px-4">{{ $history->exit_time ? $history->exit_time->format('H:i') : '-' }}</td>
                                <td class="py-3 px-4">{{ $history->getFormattedDuration() }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 {{ $history->status == 'Parkir' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }} rounded-full text-xs">
                                        {{ $history->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="8" class="py-6 px-4 text-center text-gray-500">Belum ada data parkir yang terekam</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-6 space-y-3 sm:space-y-0">
            <div class="text-sm text-gray-600 text-center sm:text-left">
                Menampilkan {{ $parkingHistories->firstItem() ?? 0 }}-{{ $parkingHistories->lastItem() ?? 0 }} dari {{ $parkingHistories->total() }} data
                @if(isset($totalRecords))
                <span class="text-xs text-gray-500 ml-1">(Total di database: {{ $totalRecords }})</span>
                @endif
            </div>
            <div class="flex justify-center sm:justify-end">
                {{ $parkingHistories->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Script untuk menampilkan tanggal dan waktu saat ini
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit' };

        document.getElementById('currentDateTime').textContent = now.toLocaleTimeString('id-ID', timeOptions);
        document.getElementById('currentDay').textContent = now.toLocaleDateString('id-ID', dateOptions);
    }

    // Update setiap detik
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
@endpush