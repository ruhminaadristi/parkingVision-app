@extends('layouts.app')

@section('content')
<div class="px-6 pb-6 pt-2">
    <!-- Hidden elements untuk menyimpan data -->
    <div id="dailyData" class="hidden">@json($completeDaily)</div>
    <div id="monthlyData" class="hidden">@json($completeMonthly)</div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Dashboard</h1>
            <p class="text-gray-500 text-sm">Ringkasan data parkir dan statistik kendaraan</p>
        </div>

        <div class="mt-3 sm:mt-0 flex items-center space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-full transition-colors duration-300" id="refreshDashboard" title="Refresh Data">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </a>
            <div class="bg-white flex items-center rounded-lg shadow-sm px-3 py-2 text-sm">
                <span id="currentDateTime" class="text-gray-600 font-medium"></span>
                <span class="mx-2 text-gray-400">|</span>
                <span id="currentDay" class="text-gray-600"></span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-gray-100">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Ringkasan Parkir</h2>

            <!-- Cards Dashboard Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Jumlah Mobil di Parkiran -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-100 transition-all duration-300 hover:shadow-md relative overflow-hidden group">
                    <div class="flex items-center">
                        <div class="z-10">
                            <p class="text-gray-500 mb-1 text-sm font-medium">Mobil di Parkiran</p>
                            <div class="flex items-baseline">
                                <h3 class="text-4xl font-bold text-emerald-600" id="carCount">0</h3>
                                <span class="ml-2 text-xs py-0.5 px-1.5 rounded-full bg-emerald-100 text-emerald-700 font-medium" id="carAvailable">Tersedia</span>
                            </div>
                        </div>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-emerald-100 group-hover:bg-emerald-200 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.5a1 1 0 00.8-.4l3-4a1 1 0 00.2-.6V8a1 1 0 00-1-1h-3.8L11.35 3.3a1 1 0 00-.8-.3H3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-300"></div>
                </div>

                <!-- Jumlah Motor di Parkiran -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100 transition-all duration-300 hover:shadow-md relative overflow-hidden group">
                    <div class="flex items-center">
                        <div class="z-10">
                            <p class="text-gray-500 mb-1 text-sm font-medium">Motor di Parkiran</p>
                            <div class="flex items-baseline">
                                <h3 class="text-4xl font-bold text-blue-600" id="motorCount">0</h3>
                                <span class="ml-2 text-xs py-0.5 px-1.5 rounded-full bg-blue-100 text-blue-700 font-medium" id="motorAvailable">Tersedia</span>
                            </div>
                        </div>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-blue-100 group-hover:bg-blue-200 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M20 14a8 8 0 01-16 0m8-12a2 2 0 100 4 2 2 0 000-4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-300"></div>
                </div>

                <!-- Pengguna Card -->
                <a href="{{ route('admin.petugas.index') }}" class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-100 transition-all duration-300 hover:shadow-md relative overflow-hidden group">
                    <div class="flex items-center">
                        <div class="z-10">
                            <p class="text-gray-500 mb-1 text-sm font-medium">Total Pengguna</p>
                            <div class="flex items-baseline">
                                <h3 class="text-4xl font-bold text-amber-600">{{ $totalUsers }}</h3>
                                <span class="ml-2 text-xs py-0.5 px-1.5 rounded-full bg-amber-100 text-amber-700 font-medium">{{ $totalAdmins }} Admin</span>
                            </div>
                        </div>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-amber-100 group-hover:bg-amber-200 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-amber-300"></div>
                </a>
            </div>

            <!-- Statistik Kendaraan Masuk -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <!-- Kendaraan Masuk Hari Ini -->
                <div class="bg-white shadow-sm rounded-xl p-4 border border-gray-100 hover:border-blue-200 hover:shadow transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Kendaraan Masuk Hari Ini</p>
                            <div class="text-3xl font-bold text-gray-800 flex items-baseline">
                                <span id="totalVehicles" data-value="{{ $totalVehiclesToday }}">{{ $totalVehiclesToday }}</span>
                                <span class="text-sm text-gray-500 ml-2 font-normal">kendaraan</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs">
                        <span class="text-gray-500">Terakhir diperbarui:</span>
                        <span class="ml-1 text-gray-600" id="lastUpdateData">{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                    
                    <!-- Debug info -->
                    <div class="mt-3 p-2 bg-gray-50 rounded-lg text-xs">
                        <details>
                            <summary class="cursor-pointer text-blue-500 font-medium">Debug Info</summary>
                            <div class="mt-2">
                                <p class="font-medium">Tanggal Pencarian: {{ $debugDate }}</p>
                                <p>Server Date: {{ $serverDate }}, Time: {{ $serverTime }}</p>
                                <p>Tanggal yang digunakan: {{ $searchDate }}</p>
                                <p>Query 1 (DATE): {{ $count1 }} kendaraan</p>
                                <p>Query 2 (BETWEEN): {{ $count2 }} kendaraan</p>
                                <p>Query 3 (>= AND <=): {{ $count3 }} kendaraan</p>
                                <p>Query 5 (Raw): {{ $count5 }} kendaraan</p>
                                <p>Query 6 (LIKE): {{ $count6 }} kendaraan</p>
                                <p>Query 7 (Hard-coded 2025-05-04): {{ $count7 }} kendaraan</p>
                                <p class="font-medium mt-2">Nilai yang digunakan: {{ $totalVehiclesToday }}</p>
                                
                                <p class="font-medium mt-2">Kendaraan Hari Ini ({{ count($allVehiclesForToday) }}):</p>
                                <ul class="list-disc pl-5 mt-1">
                                    @foreach($allVehiclesForToday as $vehicle)
                                        <li>
                                            ID: {{ $vehicle->id }}, 
                                            Jenis: {{ $vehicle->vehicle_type }}, 
                                            Slot: {{ $vehicle->slot_label }}, 
                                            Masuk: {{ $vehicle->entry_time }}, 
                                            Status: {{ $vehicle->status }}
                                        </li>
                                    @endforeach
                                </ul>
                                
                                <p class="font-medium mt-2">Hard-coded Results ({{ count($hardCodedResults) }}):</p>
                                <ul class="list-disc pl-5 mt-1">
                                    @foreach($hardCodedResults as $vehicle)
                                        <li>
                                            ID: {{ $vehicle->id }}, 
                                            Jenis: {{ $vehicle->vehicle_type }}, 
                                            Slot: {{ $vehicle->slot_label }}, 
                                            Masuk: {{ $vehicle->entry_time }}, 
                                            Status: {{ $vehicle->status }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </details>
                    </div>
                </div>

                <!-- Kendaraan Masuk Bulan Ini -->
                <div class="bg-white shadow-sm rounded-xl p-4 border border-gray-100 hover:border-blue-200 hover:shadow transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Kendaraan Masuk Bulan Ini</p>
                            <div class="text-3xl font-bold text-gray-800 flex items-baseline">
                                <span id="carTotal">{{ $totalVehiclesThisMonth }}</span>
                                <span class="text-sm text-gray-500 ml-2 font-normal">kendaraan</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-purple-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs">
                        <span class="text-gray-500">Bulan saat ini:</span>
                        <span class="ml-1 text-gray-600" id="currentMonth">{{ now()->format('F Y') }}</span>
                    </div>
                </div>

                <!-- Total Kendaraan Masuk -->
                <a href="{{ route('admin.parkir.index') }}" class="bg-white shadow-sm rounded-xl p-4 border border-gray-100 hover:border-blue-200 hover:shadow transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Kendaraan Masuk</p>
                            <div class="text-3xl font-bold text-gray-800 flex items-baseline">
                                <span id="motorTotal">{{ $totalVehiclesEver }}</span>
                                <span class="text-sm text-gray-500 ml-2 font-normal">kendaraan</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center text-xs">
                        <div class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800">
                            <div class="flex space-x-2">
                                <span>{{ $totalCars }} Mobil</span>
                                <span>•</span>
                                <span>{{ $totalMotorcycles }} Motor</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Grafik Section -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Grafik Kendaraan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Grafik Kendaraan Masuk Harian -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-700">Grafik Kendaraan Masuk Harian</h3>
                        <div class="flex space-x-4">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                <span class="text-xs text-gray-600">Motor</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                <span class="text-xs text-gray-600">Mobil</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="dailyVehicleChart"></canvas>
                    </div>
                </div>

                <!-- Grafik Kendaraan Masuk Per Bulan -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-700">Grafik Kendaraan Masuk Per Bulan</h3>
                        <div class="flex space-x-4">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                <span class="text-xs text-gray-600">Motor</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                <span class="text-xs text-gray-600">Mobil</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="monthlyVehicleChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Aktivitas Terbaru</h2>
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slot Parkir</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Keluar</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentParkingHistories as $index => $history)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-{{ $history->vehicle_type == 'Mobil' ? 'emerald' : 'blue' }}-100 flex items-center justify-center">
                                                @if($history->vehicle_type == 'Mobil')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.5a1 1 0 00.8-.4l3-4a1 1 0 00.2-.6V8a1 1 0 00-1-1h-3.8L11.35 3.3a1 1 0 00-.8-.3H3z" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M20 14a8 8 0 01-16 0m8-12a2 2 0 100 4 2 2 0 000-4z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <span class="px-2 py-1 {{ $history->vehicle_type == 'Mobil' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }} rounded-full text-xs">
                                                    {{ $history->vehicle_type }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 {{ $history->vehicle_type == 'Mobil' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full text-xs">
                                            {{ $history->slot_label }} ({{ $history->slot_index }})
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $history->entry_time->format('d M Y, H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            @if($history->exit_time)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ $history->exit_time->format('d M Y, H:i') }}</span>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $history->status == 'Parkir' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $history->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p>Belum ada aktivitas kendaraan terbaru</p>
                                            <p class="mt-1 text-xs text-gray-400">Aktivitas parkir akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(count($recentParkingHistories) > 0)
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.parkir.index') }}" class="inline-flex items-center text-sm text-green-600 hover:text-green-700 font-medium">
                            Lihat semua history
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan nilai totalVehicles selalu muncul dengan benar di awal load
    const totalVehiclesElement = document.getElementById('totalVehicles');
    
    // Tanggal & Waktu
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit' };

        const dateTimeElement = document.getElementById('currentDateTime');
        const dayElement = document.getElementById('currentDay');
        const lastUpdateElement = document.getElementById('lastUpdateData');
        const currentMonthElement = document.getElementById('currentMonth');

        dateTimeElement.textContent = now.toLocaleTimeString('id-ID', timeOptions);
        dayElement.textContent = now.toLocaleDateString('id-ID', dateOptions);
        lastUpdateElement.textContent = now.toLocaleString('id-ID');
        
        // Set bulan saat ini
        if (currentMonthElement) {
            currentMonthElement.textContent = now.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
        }
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Fungsi utilitas untuk membuat data dummy tanggal
    function getDatesForLastWeek() {
        const dates = [];
        for (let i = 6; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            dates.push(date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
        }
        return dates;
    }

    // Fungsi untuk mendapatkan nama bulan dalam bahasa Indonesia
    function getIndonesianMonths() {
        return ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    }

    // Fungsi untuk menghasilkan gradient fill
    function createGradient(ctx, rgb, alpha) {
        const gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);
        gradient.addColorStop(0, `rgba(${rgb}, ${alpha})`);
        gradient.addColorStop(0.5, `rgba(${rgb}, ${alpha * 0.6})`);
        gradient.addColorStop(1, `rgba(${rgb}, ${alpha * 0.1})`);
        return gradient;
    }

    // Variabel untuk menyimpan data historis
    let dailyHistoryData = {
        motor: Array(7).fill(0),
        mobil: Array(7).fill(0)
    };
    let monthlyHistoryData = {
        motor: Array(12).fill(0),
        mobil: Array(12).fill(0)
    };

    // Data dari database
    const dailyData = @json($completeDaily);
    const monthlyData = @json($completeMonthly);

    // 1. Daily Vehicle Chart (7 hari terakhir)
    const dailyCtx = document.getElementById('dailyVehicleChart').getContext('2d');

    // Gradient untuk data motor (hijau)
    const greenGradient = createGradient(dailyCtx, '34, 197, 94', 0.6);

    // Gradient untuk data mobil (kuning)
    const yellowGradient = createGradient(dailyCtx, '234, 179, 8', 0.6);

    // Format tanggal untuk label harian
    const dailyLabels = dailyData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });

    // Data motor dan mobil harian
    const dailyMotorData = dailyData.map(item => item.motor_count);
    const dailyCarData = dailyData.map(item => item.car_count);

    const dailyVehicleChart = new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [
                {
                    label: 'Motor',
                    data: dailyMotorData,
                    borderColor: 'rgb(21, 128, 61)',
                    backgroundColor: greenGradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(22, 163, 74)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Mobil',
                    data: dailyCarData,
                    borderColor: 'rgb(202, 138, 4)',
                    backgroundColor: yellowGradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(234, 179, 8)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#666',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    displayColors: true,
                    callbacks: {
                        title: function(tooltipItems) {
                            return tooltipItems[0].label;
                        },
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw;
                        }
                    }
                }
            }
        }
    });

    // 2. Monthly Vehicle Chart
    const monthlyCtx = document.getElementById('monthlyVehicleChart').getContext('2d');

    // Gunakan gradient yang lebih indah dengan opacity yang berbeda
    const monthlyGreenGradient = createGradient(monthlyCtx, '34, 197, 94', 0.5);
    const monthlyYellowGradient = createGradient(monthlyCtx, '234, 179, 8', 0.5);

    // Format bulan untuk label
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    const monthlyLabels = monthlyData.map(item => monthNames[item.month - 1]);

    // Data motor dan mobil bulanan
    const monthlyMotorData = monthlyData.map(item => item.motor_count);
    const monthlyCarData = monthlyData.map(item => item.car_count);

    const monthlyVehicleChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'Motor',
                    data: monthlyMotorData,
                    borderColor: 'rgb(21, 128, 61)',
                    backgroundColor: monthlyGreenGradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(22, 163, 74)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Mobil',
                    data: monthlyCarData,
                    borderColor: 'rgb(202, 138, 4)',
                    backgroundColor: monthlyYellowGradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(234, 179, 8)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#666',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    displayColors: true,
                    callbacks: {
                        title: function(tooltipItems) {
                            return tooltipItems[0].label;
                        },
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw;
                        }
                    }
                }
            }
        }
    });

    // Fungsi untuk memperbarui grafik saat refresh
    function updateCharts() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newDailyData = JSON.parse(doc.getElementById('dailyData').textContent);
                const newMonthlyData = JSON.parse(doc.getElementById('monthlyData').textContent);

                // Update grafik harian
                dailyVehicleChart.data.datasets[0].data = newDailyData.map(item => item.motor_count);
                dailyVehicleChart.data.datasets[1].data = newDailyData.map(item => item.car_count);
                dailyVehicleChart.update();

                // Update grafik bulanan
                monthlyVehicleChart.data.datasets[0].data = newMonthlyData.map(item => item.motor_count);
                monthlyVehicleChart.data.datasets[1].data = newMonthlyData.map(item => item.car_count);
                monthlyVehicleChart.update();
            });
    }

    // Tambahkan event listener untuk tombol refresh
    const refreshButton = document.getElementById('refreshDashboard');
    if (refreshButton) {
        refreshButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Animasi loading
            this.classList.add('animate-spin');

            // Update grafik
            updateCharts();

            // Hentikan animasi loading setelah 1 detik
            setTimeout(() => {
                this.classList.remove('animate-spin');

                // Tampilkan notifikasi sukses
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md transition-opacity duration-500 opacity-0';
                notification.innerHTML = `
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Data berhasil diperbarui!</span>
                    </div>
                `;

                document.body.appendChild(notification);

                // Tampilkan notifikasi dengan animasi
                setTimeout(() => notification.classList.add('opacity-100'), 100);

                // Hilangkan notifikasi setelah beberapa detik
                setTimeout(() => {
                    notification.classList.remove('opacity-100');
                    setTimeout(() => notification.remove(), 500);
                }, 3000);
            }, 1000);
        });
    }

    // Fungsi untuk simulasi refresh data secara real-time
    function simulateRealTimeData() {
        // Simulasi update jumlah kendaraan
        const mobileCount = document.querySelector('.grid:first-child > div:first-child .text-4xl');
        const motorCount = document.querySelector('.grid:first-child > div:nth-child(2) .text-4xl');

        // Simulasi animasi saat data diperbarui
        function animateValue(element, start, end, duration) {
            element.classList.add('scale-110', 'text-green-600');
            setTimeout(() => {
                element.textContent = end;
                element.classList.remove('scale-110', 'text-green-600');
            }, duration);
        }

        // Simulasi update secara berkala (misalnya setiap 30 detik)
        setInterval(() => {
            animateValue(mobileCount, mobileCount.textContent, Math.floor(Math.random() * 5) + 7, 500);
            animateValue(motorCount, motorCount.textContent, Math.floor(Math.random() * 8) + 6, 500);

            // Perbarui waktu update terakhir
            updateDateTime();
        }, 30000);
    }

    // Simulasi real-time data untuk demo
    // simulateRealTimeData();

    // Fungsi untuk menghasilkan data aktivitas terbaru secara acak (untuk demonstrasi)
    function generateRecentActivity() {
        // Cek apakah ada data asli, jika sudah ada, tidak perlu generate data demo
        if (!document.querySelector('tbody tr td[colspan="6"]')) {
            return; // Sudah ada data asli, tidak perlu generate demo
        }
        
        const activityTable = document.querySelector('tbody');
        const emptyRow = activityTable.querySelector('tr');

        // Hapus baris kosong jika ada
        if (emptyRow) {
            emptyRow.remove();
        }

        // Data contoh
        const vehicleTypes = ['Motor', 'Mobil'];
        const slotLabels = {
            'Mobil': ['M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'M7'],
            'Motor': ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8'] 
        };
        const slotIndexes = {
            'Mobil': [0, 1, 2, 3, 4, 5, 6],
            'Motor': [7, 8, 9, 10, 11, 12, 13, 14]
        };
        const statuses = ['Parkir', 'Selesai'];
        const statusColors = {
            'Parkir': 'bg-yellow-100 text-yellow-800',
            'Selesai': 'bg-gray-100 text-gray-800'
        };
        const vehicleIcons = {
            'Motor': '<svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M20 14a8 8 0 01-16 0m8-12a2 2 0 100 4 2 2 0 000-4z" /></svg>',
            'Mobil': '<svg class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.5a1 1 0 00.8-.4l3-4a1 1 0 00.2-.6V8a1 1 0 00-1-1h-3.8L11.35 3.3a1 1 0 00-.8-.3H3z" /></svg>'
        };

        // Fungsi untuk mendapatkan waktu acak dalam beberapa jam terakhir
        function getRandomTime() {
            const now = new Date();
            const hoursAgo = Math.floor(Math.random() * 24);
            const minutesAgo = Math.floor(Math.random() * 60);
            now.setHours(now.getHours() - hoursAgo);
            now.setMinutes(now.getMinutes() - minutesAgo);

            const options = { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
            return now.toLocaleDateString('id-ID', options);
        }

        // Buat 4 baris aktivitas acak (sesuai dengan 4 data terbaru)
        for (let i = 0; i < 4; i++) {
            const vehicleType = vehicleTypes[Math.floor(Math.random() * vehicleTypes.length)];
            const slotLabelIndex = Math.floor(Math.random() * slotLabels[vehicleType].length);
            const slotLabel = slotLabels[vehicleType][slotLabelIndex];
            const slotIndex = slotIndexes[vehicleType][slotLabelIndex];
            const status = statuses[Math.floor(Math.random() * statuses.length)];
            const entryTime = getRandomTime();
            const exitTime = status === 'Selesai' ? getRandomTime() : null;

            const newRow = document.createElement('tr');
            newRow.classList.add('hover:bg-gray-50', 'transition-colors', 'duration-150');
            newRow.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap">
                    ${i + 1}
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-${vehicleType === 'Mobil' ? 'emerald' : 'blue'}-100 flex items-center justify-center">
                            ${vehicleIcons[vehicleType]}
                        </div>
                        <div class="ml-4">
                            <span class="px-2 py-1 ${vehicleType === 'Mobil' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800'} rounded-full text-xs">
                                ${vehicleType}
                            </span>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <span class="px-2 py-1 ${vehicleType === 'Mobil' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800'} rounded-full text-xs">
                        ${slotLabel} (${slotIndex})
                    </span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>${entryTime}</span>
                    </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                    <div class="flex items-center">
                        ${exitTime ? `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>${exitTime}</span>
                        ` : '<span>-</span>'}
                    </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColors[status]}">
                        ${status}
                    </span>
                </td>
            `;

            activityTable.appendChild(newRow);
        }
        
        // Tambahkan tombol untuk melihat semua history
        const containerDiv = document.querySelector('.bg-white.border.border-gray-100.rounded-xl.shadow-sm.p-4');
        
        if (containerDiv && !document.querySelector('a[href*="admin.parkir.index"]')) {
            const linkDiv = document.createElement('div');
            linkDiv.className = 'mt-4 text-right';
            linkDiv.innerHTML = `
                <a href="{{ route('admin.parkir.index') }}" class="inline-flex items-center text-sm text-green-600 hover:text-green-700 font-medium">
                    Lihat semua history
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            `;
            containerDiv.appendChild(linkDiv);
        }
    }

    // Aktifkan hanya jika belum ada data dari database
    generateRecentActivity();

    // Inisialisasi Firebase
    const firebaseConfig = {
        databaseURL: "{{ config('firebase.database.url') }}"
    };
    
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const database = firebase.database();
    
    // Referensi ke node parking_detection di Firebase
    const parkingRef = database.ref('parking_detection');
    
    function updateVehicleCounts(data) {
    // Keluar dari fungsi jika tidak ada data untuk menghindari error
	if (!data) return;

	 // Ambil data langsung dari Firebase sesuai dengan key pada gambar Anda.
	 // Jika key tidak ditemukan, nilai defaultnya adalah 0.
	 const carCount = data.Car_in_parking || 0;
	 const motorCount = data.Motorcycle_in_parking || 0;
	    
	 // Update elemen HTML dengan nilai yang sudah diambil
	 document.getElementById('carCount').textContent = carCount;
	 document.getElementById('motorCount').textContent = motorCount;

	 // Memperbarui timestamp terakhir kali data diubah di Firebase
	 if (data.timestamp) {
	   // Contoh timestamp dari gambar: "2025-06-12 08:47:29"
	   // Kita ubah menjadi format yang lebih mudah dibaca
	   const date = new Date(data.timestamp.replace(" ", "T")); // Ganti spasi dengan 'T' agar kompatibel
	   const formattedTime = date.toLocaleString('id-ID', {
	         day: 'numeric',
	         month: 'long',
	         year: 'numeric',
	         hour: '2-digit',
	         minute: '2-digit'
	   });
	   document.getElementById('lastUpdateData').textContent = formattedTime;
	 }

    }
    
    parkingRef.on('value', (snapshot) => {
        // 1. Ambil data dari Firebase ketika ada perubahan
        const data = snapshot.val();
        
        // 2. Panggil fungsi updateVehicleCounts dan kirimkan data yang baru diterima
        updateVehicleCounts(data);
    });
});
</script>
@endpush
