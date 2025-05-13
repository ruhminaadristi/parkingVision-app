@extends('layouts.app')

@section('content')
<div class="px-6 pb-6 pt-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">History Parkir</h1>
            <p class="text-gray-500 text-sm">Riwayat keluar masuk kendaraan di area parkir</p>
        </div>

        <div class="mt-3 sm:mt-0 flex items-center gap-3">
            <!-- Tombol Unduh Data -->
            <a href="{{ route('admin.parkir.export') }}" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Unduh Data
            </a>
            
            <!-- Tombol Sinkronisasi dari Firebase -->
            <a href="{{ route('admin.parkir.sync') }}" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Sinkronisasi
            </a>
            
            <!-- Tombol Test Koneksi -->
            <a href="{{ route('admin.parkir.test-connection') }}" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Test Koneksi
            </a>
            
            <div class="bg-white flex items-center rounded-lg shadow-sm px-3 py-2 text-sm">
                <span id="currentDateTime" class="text-gray-600 font-medium"></span>
                <span class="mx-2 text-gray-400">|</span>
                <span id="currentDay" class="text-gray-600"></span>
            </div>
        </div>
    </div>

    <!-- Fitur Filter & Pencarian -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-gray-100">
        <!-- Pesan Notifikasi -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <form action="{{ route('admin.parkir.index') }}" method="GET">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <!-- Filter Tanggal -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <div>
                        <label for="date-from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" id="date-from" name="date_from" value="{{ request('date_from') }}" class="border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 block w-full p-2">
                    </div>
                    <div>
                        <label for="date-to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" id="date-to" name="date_to" value="{{ request('date_to') }}" class="border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 block w-full p-2">
                    </div>
                    <div class="self-end">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                            Filter
                        </button>
                    </div>
                </div>

                <!-- Pencarian -->
                <div class="w-full md:w-1/3">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Kendaraan</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Masukkan jenis kendaraan..." class="border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 block w-full p-2 pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Tabel History Parkir -->
        <div class="overflow-x-auto relative">
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

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6">
            <div class="text-sm text-gray-600">
                Menampilkan {{ $parkingHistories->firstItem() ?? 0 }}-{{ $parkingHistories->lastItem() ?? 0 }} dari {{ $parkingHistories->total() }} data
            </div>
            <div class="flex items-center">
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