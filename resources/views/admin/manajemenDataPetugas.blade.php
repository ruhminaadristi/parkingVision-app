@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Card Header dengan gradien hijau -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-t-lg p-4">
            <h2 class="text-xl md:text-2xl font-semibold text-white">Manajemen Data Petugas</h2>
            <p class="mt-1 text-green-100 text-sm md:text-base">Kelola data petugas dan admin sistem</p>
        </div>

        <div class="bg-white overflow-hidden shadow-xl rounded-b-lg">
            <div class="p-4 md:p-6">
                <!-- Button dan Alert Section -->
                <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
                    <div class="w-full md:w-auto">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" class="w-full md:w-auto pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="Cari petugas...">
                        </div>
                    </div>
                    <button type="button" onclick="openModal('tambahPetugasModal')" class="w-full md:w-auto px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Petugas
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert-message mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-message mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <!-- Tabel User Card - Tampilan Mobile -->
                <div class="block md:hidden space-y-4" id="mobileUserCards">
                    @foreach($users as $index => $user)
                    <div class="user-card bg-white rounded-lg shadow border border-green-100 p-4 hover:shadow-md transition-shadow duration-200"
                         data-name="{{ strtolower($user->name) }}">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                    <span class="text-sm font-medium text-green-800">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h3 class="text-base font-medium text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div>
                                @if($user->is_admin)
                                    <span class="px-2.5 py-0.5 text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Admin
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Petugas
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mb-3">
                            Terdaftar: {{ $user->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="flex items-center space-x-2 justify-end mt-2 border-t pt-3">
                            <button type="button" onclick="openModal('editPetugasModal{{ $user->id }}')"
                                class="flex items-center justify-center px-3 py-1.5 bg-yellow-50 text-yellow-600 rounded-md hover:bg-yellow-100">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Tabel Desktop dengan border hijau -->
                <div class="hidden md:block overflow-x-auto bg-white rounded-lg border border-green-200">
                    <table class="min-w-full divide-y divide-green-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Tanggal Registrasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-100" id="userTableBody">
                            @foreach($users as $index => $user)
                            <tr class="hover:bg-green-50 transition-colors duration-200 user-row" data-name="{{ strtolower($user->name) }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-green-800">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->is_admin)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Admin
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Petugas
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <button type="button" onclick="openModal('editPetugasModal{{ $user->id }}')"
                                            class="flex items-center text-yellow-600 hover:text-yellow-900">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                            Edit
                                        </button>
                                        
                                        <!-- Tombol hapus di samping tombol edit -->
                                        <form action="{{ route('admin.petugas.destroy', $user->id) }}" method="POST" class="inline-block" id="deletePetugasForm{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="openModal('confirmDeleteModal{{ $user->id }}')" 
                                                class="flex items-center text-red-600 hover:text-red-900">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pesan tidak ada data -->
                <div id="noResults" class="hidden py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada petugas ditemukan</h3>
                    <p class="mt-1 text-sm text-gray-500">Coba kata kunci pencarian lain.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Petugas -->
<div id="tambahPetugasModal" class="modal fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity modal-backdrop" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full max-w-[95%] w-full">
            <div class="bg-white">
                <!-- Header dengan warna hijau untuk konsistensi dengan tema aplikasi -->
                <div class="flex justify-between items-center p-4 bg-green-500 text-white">
                    <h5 class="text-lg font-semibold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Tambah Petugas Baru
                    </h5>
                    <button type="button" onclick="closeModal('tambahPetugasModal')" class="text-white hover:text-gray-200 p-2">
                        <span class="sr-only">Tutup</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Instruksi pengguna -->
                <div class="p-4 bg-green-50 text-green-700 text-sm border-b border-green-100">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Silakan lengkapi informasi berikut untuk menambahkan petugas baru. Semua field yang ditandai dengan <span class="text-red-500">*</span> wajib diisi.</span>
                    </div>
                </div>

                <form action="{{ route('admin.petugas.store') }}" method="POST" id="formTambahPetugas" class="form-with-validation">
                    @csrf
                    <div class="p-6 space-y-6">
                        <!-- Bagian Informasi Pribadi -->
                        <div class="space-y-4">
                            <h6 class="text-sm font-medium text-gray-700 uppercase tracking-wider">Informasi Pribadi</h6>

                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <input type="text" class="pl-10 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" id="name" name="name" required autocomplete="name" placeholder="Masukkan nama lengkap" aria-describedby="name-help">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500" id="name-help">Nama lengkap petugas atau admin</p>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Informasi Akun -->
                        <div class="space-y-4">
                            <h6 class="text-sm font-medium text-gray-700 uppercase tracking-wider">Informasi Akun</h6>

                            <div class="space-y-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="email" class="pl-10 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" id="email" name="email" required autocomplete="email" placeholder="contoh@email.com">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Email akan digunakan untuk login</p>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <input type="password" class="pl-10 pr-10 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" id="password" name="password" required minlength="8" placeholder="Minimal 8 karakter" aria-describedby="password-strength">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm">
                                            <button type="button" class="toggle-password text-gray-500 hover:text-gray-700 focus:outline-none" tabindex="-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Indikator kekuatan password -->
                                    <div class="mt-2 password-strength hidden" id="password-strength">
                                        <div class="flex space-x-1 mb-1">
                                            <div class="h-1 w-1/4 rounded-full bg-gray-200 strength-indicator" data-level="1"></div>
                                            <div class="h-1 w-1/4 rounded-full bg-gray-200 strength-indicator" data-level="2"></div>
                                            <div class="h-1 w-1/4 rounded-full bg-gray-200 strength-indicator" data-level="3"></div>
                                            <div class="h-1 w-1/4 rounded-full bg-gray-200 strength-indicator" data-level="4"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 strength-text">Password harus memiliki minimal 8 karakter</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Hak Akses -->
                        <div>
                            <h6 class="text-sm font-medium text-gray-700 uppercase tracking-wider mb-4">Hak Akses</h6>

                            <div class="flex items-center p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex-1">
                                    <label for="is_admin" class="font-medium text-gray-700 text-sm flex items-center cursor-pointer">
                                        <input type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded mr-2" id="is_admin" name="is_admin" value="1">
                                        Status Admin
                                    </label>
                                    <p class="mt-1 ml-6 text-xs text-gray-500">Admin memiliki akses penuh untuk mengelola semua data dan petugas</p>
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Opsional
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer form dengan tombol-tombol aksi -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Data
                        </button>
                        <button type="button" onclick="closeModal('tambahPetugasModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:w-auto sm:text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Petugas -->
@foreach($users as $user)
<div id="editPetugasModal{{ $user->id }}" class="modal fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity modal-backdrop" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full max-w-[95%] w-full">
            <div class="bg-white">
                <!-- Header dengan warna kuning untuk indikasi edit data -->
                <div class="flex justify-between items-center p-4 bg-yellow-500 text-white">
                    <h5 class="text-lg font-semibold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Petugas: {{ $user->name }}
                    </h5>
                    <button type="button" onclick="closeModal('editPetugasModal{{ $user->id }}')" class="text-white hover:text-gray-200 p-2">
                        <span class="sr-only">Tutup</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Instruksi pengguna -->
                <div class="p-4 bg-yellow-50 text-yellow-700 text-sm border-b border-yellow-100">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="mb-1">Anda sedang mengedit informasi untuk petugas <strong>{{ $user->name }}</strong>.</p>
                            <p>Kosongkan field password jika tidak ingin mengubah password.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.petugas.update', $user->id) }}" method="POST" id="formEditPetugas{{ $user->id }}" class="form-with-validation">
                    @csrf
                    @method('PUT')
                    <div class="p-6 space-y-6">
                        <!-- Bagian Informasi Pribadi -->
                        <div class="space-y-4">
                            <h6 class="text-sm font-medium text-gray-700 uppercase tracking-wider">Informasi Pribadi</h6>

                            <div>
                                <label for="name{{ $user->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" class="pl-10 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500" id="name{{ $user->id }}" name="name" value="{{ $user->name }}" required autocomplete="name">
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Informasi Akun -->
                        <div class="space-y-4">
                            <h6 class="text-sm font-medium text-gray-700 uppercase tracking-wider">Informasi Akun</h6>

                            <div>
                                <label for="email{{ $user->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="email" class="pl-10 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" required autocomplete="email">
                                </div>
                            </div>

                            <div>
                                <label for="password{{ $user->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                    Password <span class="text-gray-400">(opsional)</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input type="password" class="pl-10 pr-10 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500" id="password{{ $user->id }}" name="password" minlength="8" placeholder="Kosongkan jika tidak ingin mengubah">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm">
                                        <button type="button" class="toggle-password text-gray-500 hover:text-gray-700 focus:outline-none" tabindex="-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter jika diisi</p>
                            </div>
                        </div>

                        <!-- Bagian Hak Akses dengan indikasi status saat ini -->
                        <div>
                            <h6 class="text-sm font-medium text-gray-700 uppercase tracking-wider mb-4">Hak Akses</h6>

                            <div class="flex items-center p-4 border border-gray-200 rounded-lg {{ $user->is_admin ? 'bg-green-50' : 'bg-gray-50' }}">
                                <div class="flex-1">
                                    <label for="is_admin{{ $user->id }}" class="font-medium text-gray-700 text-sm flex items-center cursor-pointer">
                                        <input type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded mr-2" id="is_admin{{ $user->id }}" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}>
                                        Status Admin
                                    </label>
                                    <p class="mt-1 ml-6 text-xs text-gray-500">Admin memiliki akses penuh untuk mengelola semua data dan petugas</p>
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_admin ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $user->is_admin ? 'Admin' : 'Petugas' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal registrasi - informasi tambahan -->
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>Terdaftar pada:</span>
                                <time datetime="{{ $user->created_at }}">{{ $user->created_at->format('d M Y, H:i') }}</time>
                            </div>
                        </div>
                    </div>

                    <!-- Footer form dengan tombol-tombol aksi -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeModal('editPetugasModal{{ $user->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:mt-0 sm:w-auto sm:text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Petugas -->
<div id="confirmDeleteModal{{ $user->id }}" class="modal fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity modal-backdrop" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full max-w-[95%] w-full">
            <div class="bg-white">
                <!-- Header dengan warna merah untuk indikasi bahaya -->
                <div class="flex justify-between items-center p-4 bg-red-500 text-white">
                    <h5 class="text-lg font-semibold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" onclick="closeModal('confirmDeleteModal{{ $user->id }}')" class="text-white hover:text-gray-200 p-2">
                        <span class="sr-only">Tutup</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Konten modal konfirmasi -->
                <div class="p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Petugas</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus petugas <strong>{{ $user->name }}</strong>? Tindakan ini tidak dapat dibatalkan dan semua data terkait petugas ini akan dihapus secara permanen.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer konfirmasi -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                    <form action="{{ route('admin.petugas.destroy', $user->id) }}" method="POST" id="deletePetugasForm{{ $user->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Ya, Hapus Petugas
                        </button>
                    </form>
                    <button type="button" onclick="closeModal('confirmDeleteModal{{ $user->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Konfirmasi Hapus Petugas -->
<div id="confirmDeleteModal{{ $user->id }}" class="modal fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity modal-backdrop" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full max-w-[95%] w-full">
            <div class="bg-white">
                <!-- Header dengan warna merah untuk indikasi bahaya -->
                <div class="flex justify-between items-center p-4 bg-red-500 text-white">
                    <h5 class="text-lg font-semibold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" onclick="closeModal('confirmDeleteModal{{ $user->id }}')" class="text-white hover:text-gray-200 p-2">
                        <span class="sr-only">Tutup</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Konten modal konfirmasi -->
                <div class="p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Petugas</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus petugas <strong>{{ $user->name }}</strong>? Tindakan ini tidak dapat dibatalkan dan semua data terkait petugas ini akan dihapus secara permanen.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer konfirmasi -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                    <form action="{{ route('admin.petugas.destroy', $user->id) }}" method="POST" id="deletePetugasForm{{ $user->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Ya, Hapus Petugas
                        </button>
                    </form>
                    <button type="button" onclick="closeModal('confirmDeleteModal{{ $user->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk mengatur modal
    const Modal = {
        show(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        },

        hide(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        },

        init() {
            // Menutup modal ketika mengklik di luar modal
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('modal-backdrop')) {
                    const modalId = e.target.closest('.modal').id;
                    this.hide(modalId);
                }
            });

            // Menutup modal dengan tombol ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal:not(.hidden)').forEach(modal => {
                        this.hide(modal.id);
                    });
                }
            });
        }
    };

    // Fungsi pencarian
    function searchUsers() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
        const userRows = document.querySelectorAll('.user-row');
        const userCards = document.querySelectorAll('.user-card');
        let foundResults = false;

        // Search in desktop table
        if (userRows.length > 0) {
            userRows.forEach(row => {
                const userName = row.getAttribute('data-name');
                if (userName.includes(searchValue)) {
                    row.classList.remove('hidden');
                    foundResults = true;
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        // Search in mobile cards
        if (userCards.length > 0) {
            userCards.forEach(card => {
                const userName = card.getAttribute('data-name');
                if (userName.includes(searchValue)) {
                    card.classList.remove('hidden');
                    foundResults = true;
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        // Display message if no results found
        const noResultsMessage = document.getElementById('noResults');
        if (noResultsMessage) {
            if (!foundResults && searchValue !== '') {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
            }
        }
    }

    // Inisialisasi Modal
    document.addEventListener('DOMContentLoaded', function() {
        Modal.init();

        // Pencarian petugas
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', searchUsers);
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchUsers();
                }
            });
        }

        // Reset form ketika modal tambah dibuka
        const tambahPetugasModal = document.getElementById('tambahPetugasModal');
        if (tambahPetugasModal) {
            tambahPetugasModal.querySelector('form')?.reset();
        }

        // Validasi password
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        passwordInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length > 0 && this.value.length < 8) {
                    this.setCustomValidity('Password harus minimal 8 karakter');
                } else {
                    this.setCustomValidity('');
                }
            });
        });

        // Toggle password visibility
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                const passwordInput = this.closest('.relative').querySelector('input');
                const eyeOpen = this.querySelector('.eye-open');
                const eyeClosed = this.querySelector('.eye-closed');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            });
        });

        // Loading state saat submit form
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    `;
                }
            });
        });

        // Swipe gesture untuk card mobile
        const userCards = document.querySelectorAll('.user-card');
        let touchStartX = 0;
        let touchEndX = 0;

        function handleSwipeGesture(card) {
            card.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            }, {passive: true});

            card.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe(card);
            }, {passive: true});
        }

        function handleSwipe(card) {
            const swipeThreshold = 100;
            if (touchEndX < touchStartX - swipeThreshold) {
                // Swipe left - menampilkan tombol aksi
                card.querySelector('.card-actions')?.classList.add('card-actions-visible');
            }
            if (touchEndX > touchStartX + swipeThreshold) {
                // Swipe right - menyembunyikan tombol aksi
                card.querySelector('.card-actions')?.classList.remove('card-actions-visible');
            }
        }

        userCards.forEach(card => handleSwipeGesture(card));

        // Auto-hide alerts setelah 3 detik
        const alerts = document.querySelectorAll('.alert-message');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease-in-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        });

        // Hapus kelas 'hidden' pada load untuk mencegah flash konten yang tidak terformat
        document.body.classList.add('content-loaded');
    });

    // Fungsi untuk membuka modal
    function openModal(modalId) {
        Modal.show(modalId);
    }

    // Fungsi untuk menutup modal
    function closeModal(modalId) {
        Modal.hide(modalId);
    }

    // Tambahkan fungsi baru untuk konfirmasi hapus yang lebih baik
    function confirmDelete(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus petugas ini?')) {
            document.getElementById('deletePetugasForm' + userId).submit();
        }
    }

    // Menambahkan fungsi untuk menilai kekuatan password
    function checkPasswordStrength(password) {
        let strength = 0;

        // Minimal 8 karakter
        if (password.length >= 8) strength += 1;

        // Mengandung huruf kecil dan huruf besar
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;

        // Mengandung angka
        if (password.match(/\d/)) strength += 1;

        // Mengandung karakter khusus
        if (password.match(/[^a-zA-Z\d]/)) strength += 1;

        return strength;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Kode yang sudah ada...

        // Menambahkan validasi dan indikator kekuatan password yang lebih baik
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        passwordInputs.forEach(input => {
            const strengthContainer = input.parentElement.nextElementSibling;

            if (strengthContainer && strengthContainer.classList.contains('password-strength')) {
                input.addEventListener('input', function() {
                    // Tampilkan indikator kekuatan jika ada input
                    if (this.value.length > 0) {
                        strengthContainer.classList.remove('hidden');

                        // Hitung dan tunjukkan kekuatan password
                        const strength = checkPasswordStrength(this.value);
                        const indicators = strengthContainer.querySelectorAll('.strength-indicator');
                        const strengthText = strengthContainer.querySelector('.strength-text');

                        // Reset semua indikator
                        indicators.forEach(indicator => {
                            indicator.className = 'h-1 w-1/4 rounded-full bg-gray-200 strength-indicator';
                        });

                        // Atur warna berdasarkan kekuatan
                        let strengthColor = '';
                        let strengthMessage = '';

                        switch(strength) {
                            case 1:
                                strengthColor = 'bg-red-400';
                                strengthMessage = 'Lemah - tambahkan kombinasi huruf besar/kecil';
                                break;
                            case 2:
                                strengthColor = 'bg-orange-400';
                                strengthMessage = 'Sedang - tambahkan angka';
                                break;
                            case 3:
                                strengthColor = 'bg-yellow-400';
                                strengthMessage = 'Cukup kuat - tambahkan karakter khusus';
                                break;
                            case 4:
                                strengthColor = 'bg-green-400';
                                strengthMessage = 'Kuat - password aman';
                                break;
                            default:
                                strengthColor = 'bg-red-400';
                                strengthMessage = 'Minimal 8 karakter diperlukan';
                        }

                        // Terapkan warna ke indikator
                        for (let i = 0; i < strength; i++) {
                            if (indicators[i]) indicators[i].classList.add(strengthColor);
                        }

                        // Update teks kekuatan
                        if (strengthText) strengthText.textContent = strengthMessage;
                    } else {
                        strengthContainer.classList.add('hidden');
                    }

                    // Validasi panjang minimum
                    if (this.value.length > 0 && this.value.length < 8) {
                        this.setCustomValidity('Password harus minimal 8 karakter');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            }
        });

        // Tambahkan auto-focus pada modal saat dibuka
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    if (mutation.attributeName === 'class' && !modal.classList.contains('hidden')) {
                        const firstInput = modal.querySelector('input:not([type="hidden"])');
                        if (firstInput) {
                            setTimeout(() => {
                                firstInput.focus();
                            }, 100);
                        }
                    }
                });
            });

            observer.observe(modal, { attributes: true });
        });
    });
</script>
@endpush