@extends('layouts.app')

@section('content')
<div class="px-6 pb-6 pt-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Dashboard</h1>
            <p class="text-gray-500 text-sm">Ringkasan data parkir dan statistik kendaraan</p>
        </div>

        <div class="mt-3 sm:mt-0">
            <div class="bg-white flex items-center rounded-lg shadow-sm px-3 py-2 text-sm">
                <span id="currentDateTime" class="text-gray-600 font-medium"></span>
                <span class="mx-2 text-gray-400">|</span>
                <span id="currentDay" class="text-gray-600"></span>
            </div>
        </div>
    </div>

    <!-- Dashboard content -->
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
                                <h3 class="text-4xl font-bold text-emerald-600">9</h3>
                                <span class="ml-2 text-xs py-0.5 px-1.5 rounded-full bg-emerald-100 text-emerald-700 font-medium">Tersedia</span>
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
                                <h3 class="text-4xl font-bold text-blue-600">9</h3>
                                <span class="ml-2 text-xs py-0.5 px-1.5 rounded-full bg-blue-100 text-blue-700 font-medium">Tersedia</span>
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
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-100 transition-all duration-300 hover:shadow-md relative overflow-hidden group">
                    <div class="flex items-center">
                        <div class="z-10">
                            <p class="text-gray-500 mb-1 text-sm font-medium">Total Pengguna</p>
                            <div class="flex items-baseline">
                                <h3 class="text-4xl font-bold text-amber-600">2</h3>
                                <span class="ml-2 text-xs py-0.5 px-1.5 rounded-full bg-amber-100 text-amber-700 font-medium">Admin</span>
                            </div>
                        </div>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-amber-100 group-hover:bg-amber-200 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-amber-300"></div>
                </div>
            </div>

            <!-- Statistik Kendaraan Masuk -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <!-- Kendaraan Masuk Hari Ini -->
                <div class="bg-white shadow-sm rounded-xl p-4 border border-gray-100 hover:border-blue-200 hover:shadow transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Kendaraan Masuk Hari Ini</p>
                            <div class="text-3xl font-bold text-gray-800 flex items-baseline">
                                <span>0</span>
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
                        <span class="ml-1 text-gray-600" id="lastUpdateToday"></span>
                    </div>
                </div>

                <!-- Kendaraan Masuk Bulan Ini -->
                <div class="bg-white shadow-sm rounded-xl p-4 border border-gray-100 hover:border-blue-200 hover:shadow transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Kendaraan Masuk Bulan Ini</p>
                            <div class="text-3xl font-bold text-gray-800 flex items-baseline">
                                <span>0</span>
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
                        <span class="ml-1 text-gray-600" id="currentMonth"></span>
                    </div>
                </div>

                <!-- Total Kendaraan Masuk -->
                <div class="bg-white shadow-sm rounded-xl p-4 border border-gray-100 hover:border-blue-200 hover:shadow transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Kendaraan Masuk</p>
                            <div class="text-3xl font-bold text-gray-800 flex items-baseline">
                                <span>13</span>
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
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Semua waktu</span>
                        </div>
                    </div>
                </div>
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
                                <div class="w-3 h-3 rounded-full bg-blue-500 mr-1"></div>
                                <span class="text-xs text-gray-600">Motor</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-purple-500 mr-1"></div>
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
                                <div class="w-3 h-3 rounded-full bg-blue-500 mr-1"></div>
                                <span class="text-xs text-gray-600">Motor</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-purple-500 mr-1"></div>
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
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Plat</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Ketika tidak ada data aktivitas -->
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p>Belum ada aktivitas kendaraan terbaru</p>
                                        <p class="mt-1 text-xs text-gray-400">Aktivitas parkir akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                            <!-- Contoh data -->
                            <!--
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M20 14a8 8 0 01-16 0m8-12a2 2 0 100 4 2 2 0 000-4z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Motor</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">B 1234 XYZ</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Masuk
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>20 Nov 2023, 08:15</span>
                                    </div>
                                </td>
                            </tr>
                            -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tanggal & Waktu
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { day: 'numeric', month: 'long', year: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit' };

        const dateTimeElement = document.getElementById('currentDateTime');
        const dayElement = document.getElementById('currentDay');
        const lastUpdateElement = document.getElementById('lastUpdateToday');
        const currentMonthElement = document.getElementById('currentMonth');

        dateTimeElement.textContent = now.toLocaleTimeString('id-ID', timeOptions) + ', ' +
                                     now.toLocaleDateString('id-ID', dateOptions);

        const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        dayElement.textContent = dayNames[now.getDay()];

        lastUpdateElement.textContent = now.toLocaleTimeString('id-ID', timeOptions);

        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        currentMonthElement.textContent = monthNames[now.getMonth()] + ' ' + now.getFullYear();
    }

    updateDateTime();
    setInterval(updateDateTime, 60000); // Update setiap menit

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
    function createGradient(ctx, color, opacity) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, `rgba(${color}, ${opacity})`);
        gradient.addColorStop(1, `rgba(${color}, 0)`);
        return gradient;
    }

    // 1. Daily Vehicle Chart (7 hari terakhir)
    const dailyCtx = document.getElementById('dailyVehicleChart').getContext('2d');

    // Gradient untuk data motor (blue)
    const blueGradient = createGradient(dailyCtx, '59, 130, 246', 0.5);

    // Gradient untuk data mobil (purple)
    const purpleGradient = createGradient(dailyCtx, '139, 92, 246', 0.5);

    const dailyVehicleChart = new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: getDatesForLastWeek(),
            datasets: [
                {
                    label: 'Motor',
                    data: [45, 58, 80, 95, 68, 55, 82],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: blueGradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Mobil',
                    data: [20, 35, 45, 38, 32, 40, 43],
                    borderColor: 'rgb(139, 92, 246)',
                    backgroundColor: purpleGradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(139, 92, 246)',
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

    // Gunakan gradient yang sama
    const monthlyBlueGradient = createGradient(monthlyCtx, '59, 130, 246', 0.5);
    const monthlyPurpleGradient = createGradient(monthlyCtx, '139, 92, 246', 0.5);

    const monthlyVehicleChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: getIndonesianMonths(),
            datasets: [
                {
                    label: 'Motor',
                    data: [850, 980, 1200, 950, 1500, 1300, 1700, 1900, 1600, 1450, 1950, 2100],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: monthlyBlueGradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Mobil',
                    data: [350, 420, 550, 400, 680, 590, 750, 820, 740, 650, 820, 900],
                    borderColor: 'rgb(139, 92, 246)',
                    backgroundColor: monthlyPurpleGradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(139, 92, 246)',
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

    // Animasi untuk card saat halaman dimuat
    function animateCards() {
        const cards = document.querySelectorAll('.grid > div');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('opacity-100', 'translate-y-0');
                card.classList.remove('opacity-0', 'translate-y-4');
            }, 100 * index);
        });
    }

    // Tambahkan kelas untuk animasi
    const cards = document.querySelectorAll('.grid > div');
    cards.forEach(card => {
        card.classList.add('transition-all', 'duration-500', 'opacity-0', 'translate-y-4');
    });

    // Jalankan animasi setelah halaman dimuat
    setTimeout(animateCards, 100);

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

    // Simulasi real-time data (aktifkan untuk demo)
    simulateRealTimeData();

    // Fungsi untuk menghasilkan data aktivitas terbaru secara acak (untuk demonstrasi)
    function generateRecentActivity() {
        const activityTable = document.querySelector('tbody');
        const emptyRow = activityTable.querySelector('tr');

        // Hapus baris kosong jika ada
        if (emptyRow) {
            emptyRow.remove();
        }

        // Data contoh
        const vehicleTypes = ['Motor', 'Mobil'];
        const plateNumbers = ['B 1234 XYZ', 'D 5678 ABC', 'F 9101 DEF', 'AB 2345 GHI'];
        const statuses = ['Masuk', 'Keluar'];
        const statusColors = {
            'Masuk': 'bg-green-100 text-green-800',
            'Keluar': 'bg-red-100 text-red-800'
        };
        const vehicleIcons = {
            'Motor': '<svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M20 14a8 8 0 01-16 0m8-12a2 2 0 100 4 2 2 0 000-4z" /></svg>',
            'Mobil': '<svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 16l-4-4m0 0L11 8m4 4H3" /></svg>'
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

        // Buat 5 baris aktivitas acak
        for (let i = 0; i < 5; i++) {
            const vehicleType = vehicleTypes[Math.floor(Math.random() * vehicleTypes.length)];
            const plateNumber = plateNumbers[Math.floor(Math.random() * plateNumbers.length)];
            const status = statuses[Math.floor(Math.random() * statuses.length)];
            const time = getRandomTime();

            const newRow = document.createElement('tr');
            newRow.classList.add('hover:bg-gray-50', 'transition-colors', 'duration-150');
            newRow.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-${vehicleType === 'Motor' ? 'blue' : 'purple'}-100 flex items-center justify-center">
                            ${vehicleIcons[vehicleType]}
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${vehicleType}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${plateNumber}</div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColors[status]}">
                        ${status}
                    </span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>${time}</span>
                    </div>
                </td>
            `;

            activityTable.appendChild(newRow);
        }
    }

    // Aktifkan untuk demo data aktivitas
    generateRecentActivity();

    // Tambahkan event listener untuk tombol refresh jika ada
    const refreshButton = document.getElementById('refreshDashboard');
    if (refreshButton) {
        refreshButton.addEventListener('click', function() {
            // Animasi loading
            this.classList.add('animate-spin');

            // Simulasi refresh data
            setTimeout(() => {
                updateDateTime();
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
});
</script>
@endpush