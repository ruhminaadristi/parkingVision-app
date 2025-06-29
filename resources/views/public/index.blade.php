@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-green-500 to-green-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-center">
                <div class="mb-6 lg:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight">
                        Parking Vision
                    </h1>
                    <p class="mt-2 text-green-100 max-w-2xl">
                        Pantau ketersediaan tempat parkir secara real-time. Hemat waktu dan cepat mengetahui area parkir yang kosong.
                    </p>
                </div>
                <div class="flex space-x-4">
                    <a href="#availability" class="bg-white text-green-700 hover:bg-gray-100 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Cek Ketersediaan
                    </a>
                    <a href="{{ route('admin.login') }}" class="bg-green-700 hover:bg-green-800 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Area Admin
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Loading State -->
    <div id="loadingState" class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-green-500"></div>
            <p class="mt-4 text-gray-600">Memuat data parkir terkini...</p>
        </div>
    </div>

    <!-- Real-time Parking Status -->
    <section id="availability" class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" id="parkingContent">
            <!-- Content akan diupdate via JavaScript -->
        </div>
    </section>

    <!-- Info Section -->
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Cara Menggunakan</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-100 text-center">
                    <div class="rounded-full bg-green-100 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Cek Ketersediaan</h3>
                    <p class="text-gray-600">Lihat area parkir yang tersedia secara real-time melalui dashboard visual.</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-100 text-center">
                    <div class="rounded-full bg-green-100 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Pantau Jumlah Kendaraan</h3>
                    <p class="text-gray-600">Lihat informasi lengkap tentang jumlah dan jenis kendaraan di area parkir.</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-100 text-center">
                    <div class="rounded-full bg-green-100 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Pembaruan Real-time</h3>
                    <p class="text-gray-600">Informasi diperbarui secara real-time, sehingga Anda selalu mendapatkan data terkini.</p>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<footer class="bg-gray-800 text-gray-300">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <h2 class="text-xl font-bold text-white">Parking Vision</h2>
                <p class="text-sm text-gray-400">Sistem Deteksi Parkir Cerdas</p>
            </div>
            <div class="flex space-x-4">
                <a href="#availability" class="hover:text-white transition-colors duration-200">Ketersediaan</a>
                <a href="{{ route('admin.login') }}" class="hover:text-white transition-colors duration-200">Login Admin</a>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-700 text-center text-sm text-gray-400">
            Â© {{ date('Y') }} Parking Vision. Seluruh hak cipta dilindungi.
        </div>
    </div>
</footer>

@push('scripts')
<script>
// Firebase configuration
const firebaseConfig = {
    databaseURL: "{{ config('firebase.database.url') }}"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const database = firebase.database();

function updateParkingDisplay(data) {
    if (!data) return;

    // Sembunyikan loading state
    document.getElementById('loadingState').classList.add('hidden');

    // Format timestamp yang lebih user-friendly
    let formattedTime = 'No Data';
    if (data.timestamp) {
        const date = new Date(data.timestamp);
        formattedTime = date.toLocaleString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Konfigurasi jumlah slot parkir
    const totalMotorSpots = 5;
    const totalCarSpots = 6; 

    // Hitung slot yang terisi untuk motor
    const occupiedMotorSpots = Array.from({length: totalMotorSpots}, (_, i) => 
        data[`parking_spot_${i + totalCarSpots}`] === 'occupied' ? 1 : 0
    ).reduce((a, b) => a + b, 0);

    // Hitung slot yang terisi untuk mobil
    const occupiedCarSpots = Array.from({length: totalCarSpots}, (_, i) => 
        data[`parking_spot_${i}`] === 'occupied' ? 1 : 0
    ).reduce((a, b) => a + b, 0);

    // Hitung ketersediaan
    const availableCarSpots = totalCarSpots - occupiedCarSpots;
    const availableMotorSpots = totalMotorSpots - occupiedMotorSpots;
    const totalSpots = totalCarSpots + totalMotorSpots;
    const totalAvailableSpots = availableCarSpots + availableMotorSpots;
    
    // Hitung persentase ketersediaan
    const availabilityPercentage = Math.round((totalAvailableSpots / totalSpots) * 100);

    document.getElementById('parkingContent').innerHTML = `
        <!-- Availability Overview -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center p-1 bg-white rounded-full mb-4">
                <div class="bg-green-500 text-white rounded-full w-24 h-24 flex flex-col items-center justify-center">
                    <span class="text-2xl font-bold">${totalAvailableSpots}</span>
                    <span class="text-xs">Tersedia</span>
                </div>
                <div class="px-4">
                    <div class="h-4 w-32 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500" style="width: ${availabilityPercentage}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">${availabilityPercentage}% Tersedia</p>
                </div>
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                ${totalAvailableSpots > 0 ? `Ada ${totalAvailableSpots} tempat parkir tersedia saat ini` : 'Semua tempat parkir penuh'}
            </h2>
            <p class="text-gray-600 mt-2">Terakhir diperbarui: ${formattedTime}</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="rounded-full bg-blue-100 p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Total Kendaraan</h3>
                            <p class="text-3xl font-bold text-blue-600">${data.total_vehicles || 0}</p>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2 text-center">
                        <div class="bg-gray-50 p-2 rounded">
                            <p class="text-xs text-gray-500">Motor</p>
                            <p class="text-lg font-semibold">${data.Motorcycle || 0}</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <p class="text-xs text-gray-500">Mobil</p>
                            <p class="text-lg font-semibold">${data.Car || 0}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="rounded-full bg-green-100 p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Kendaraan Parkir</h3>
                            <p class="text-3xl font-bold text-green-600">${data.total_in_parking || 0}</p>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2 text-center">
                        <div class="bg-gray-50 p-2 rounded">
                            <p class="text-xs text-gray-500">Motor</p>
                            <p class="text-lg font-semibold">${data.Motorcycle_in_parking || 0}</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <p class="text-xs text-gray-500">Mobil</p>
                            <p class="text-lg font-semibold">${data.Car_in_parking || 0}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="rounded-full bg-yellow-100 p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Status Terkini</h3>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">Area parkir:</p>
                            <span class="px-2 py-1 rounded-full text-xs font-medium ${totalAvailableSpots > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                ${totalAvailableSpots > 0 ? 'Tersedia' : 'Penuh'}
                            </span>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <p class="text-sm text-gray-600">Mode deteksi:</p>
                            <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-medium">
                                Real-time
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parking Area Visualization -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-8">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Denah Area Parkir
                </h2>
                <div class="bg-gray-100 p-4 rounded-lg">

                    <!-- Denah Parkir Motor -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Area Parkir Motor
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-4">
                            ${Array.from({length: totalMotorSpots}, (_, i) => {
                                const spotIndex = i;
                                const status = data[`parking_spot_${spotIndex}`] || 'empty';
                                const isOccupied = status === 'occupied';
                                const bgColor = isOccupied ? 'bg-red-500 shadow-red-200' : 'bg-green-500 shadow-green-200';
                                const statusText = isOccupied ? 'Terisi' : 'Kosong';

                                return `
                                    <div class="relative overflow-hidden rounded-lg shadow-lg ${bgColor}">
                                        <div class="absolute top-2 right-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium ${isOccupied ? 'bg-red-700' : 'bg-green-700'} text-white">
                                                ${statusText}
                                            </span>
                                        </div>
                                        <div class="p-4 flex flex-col items-center justify-center aspect-square">
                                            <span class="text-white text-2xl font-bold mb-1">R${i + 1}</span>
                                            ${isOccupied ? `<span class="text-white text-xs">Motor</span>` : ''}
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>

                    <!-- Denah Parkir Mobil -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Area Parkir Mobil
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-7 gap-4">
                            ${Array.from({length: totalCarSpots}, (_, i) => {
                                const spotIndex = i + totalMotorSpots;
                                const status = data[`parking_spot_${spotIndex}`] || 'empty';
                                const isOccupied = status === 'occupied';
                                const bgColor = isOccupied ? 'bg-red-500 shadow-red-200' : 'bg-green-500 shadow-green-200';
                                const statusText = isOccupied ? 'Terisi' : 'Kosong';

                                return `
                                    <div class="relative overflow-hidden rounded-lg shadow-lg ${bgColor}">
                                        <div class="absolute top-2 right-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium ${isOccupied ? 'bg-red-700' : 'bg-green-700'} text-white">
                                                ${statusText}
                                            </span>
                                        </div>
                                        <div class="p-4 flex flex-col items-center justify-center aspect-square">
                                            <span class="text-white text-2xl font-bold mb-1">M${i + 1}</span>
                                            ${isOccupied ? `<span class="text-white text-xs">Mobil</span>` : ''}
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap justify-center gap-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Tersedia</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Terisi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Real-time listener
const ref = firebase.database().ref('parking_detection');
ref.on('value', (snapshot) => {
    const data = snapshot.val();
    if (data) {
        updateParkingDisplay(data);
    } else {
        document.getElementById('loadingState').innerHTML = `
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-4 text-gray-600">Data parkir tidak tersedia saat ini.</p>
                <a href="#" onclick="window.location.reload()" class="inline-block mt-2 text-green-500 hover:text-green-700">Muat ulang halaman</a>
            </div>
        `;
    }
});

// Animasi scroll smooth untuk link
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 20,
                behavior: 'smooth'
            });
        }
    });
});

// Auto refresh data setiap 30 detik
setInterval(() => {
    ref.once('value').then(snapshot => {
        const data = snapshot.val();
        if (data) {
            updateParkingDisplay(data);
        }
    });
}, 30000);
</script>
@endpush
@endsection
