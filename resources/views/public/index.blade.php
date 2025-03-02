@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                Parking Availability
            </h1>
            <a href="{{ route('admin.login') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                Admin Area
            </a>
        </div>
    </header>

    <!-- Real-time Parking Status -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="parkingContent">
            <!-- Content akan diupdate via JavaScript -->
        </div>
    </div>
</div>

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

    document.getElementById('parkingContent').innerHTML = `
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Total Vehicles</h3>
                    <p class="text-3xl font-bold text-blue-600">${data.total_objects || 0}</p>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>Cars: ${data.Car || 0}</p>
                        <p>Motorcycles: ${data.Motorcycle || 0}</p>
                        <p>Bicycles: ${data.Bicycle || 0}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Vehicles in Parking</h3>
                    <p class="text-3xl font-bold text-green-600">${data.total_in_parking || 0}</p>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>Cars: ${data.Car_in_parking || 0}</p>
                        <p>Motorcycles: ${data.Motorcycle_in_parking || 0}</p>
                        <p>Bicycles: ${data.Bicycle_in_parking || 0}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Last Updated</h3>
                    <p class="text-lg font-medium text-gray-600">${data.timestamp || 'No Data'}</p>
                </div>
            </div>
        </div>

        <!-- Parking Area Visualization -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-900">Parking Area Status</h2>
                <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
                    ${Array.from({length: 6}, (_, i) => {
                        const status = data[`parking_spot_${i}`] || 'empty';
                        return `
                            <div class="aspect-square ${status === 'occupied' ? 'bg-red-500' : 'bg-green-500'} rounded-lg flex items-center justify-center">
                                <span class="text-white font-medium">${i + 1}</span>
                            </div>
                        `;
                    }).join('')}
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
    }
});
</script>
@endpush
@endsection
