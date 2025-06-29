<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\ParkingHistory;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ManagementDataParkirController extends Controller
{
    // Konfigurasi slot parkir
    protected $totalMotorSpots = 5; // Slot 0-6 untuk mobil
    protected $totalCarSpots = 6; // Slot 7-14 untuk motor
    protected $firebaseUrl; // URL Firebase Realtime Database
    
    public function __construct()
    {
        $this->firebaseUrl = config('firebase.database.url');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        // Query awal
        $query = ParkingHistory::query();
        
        // Filter berdasarkan tanggal
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('entry_time', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('entry_time', '<=', $request->date_to);
        }
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('vehicle_type', 'like', "%{$search}%")
                  ->orWhere('slot_label', 'like', "%{$search}%");
            });
        }
        
        // Log total records untuk debugging
        $totalRecords = ParkingHistory::count();
        
        // Ambil data dan urutkan berdasarkan waktu masuk terbaru
        // Meningkatkan jumlah data per halaman menjadi 10
        $parkingHistories = $query->orderBy('entry_time', 'desc')
                                 ->paginate(10);
        
        // Pastikan data terambil dengan benar
        if ($parkingHistories->isEmpty() && $totalRecords > 0 && !$request->has('page')) {
            // Jika tidak ada data yang ditampilkan tapi ada data di database, coba refresh cache
            $parkingHistories = $query->orderBy('entry_time', 'desc')
                                     ->paginate(10, ['*'], 'page', 1);
        }
        
        return view('admin.manajemenDataParkir', compact('parkingHistories', 'totalRecords'));
    }
    
    /**
     * Endpoint untuk menerima webhook dari Firebase
     */
    public function handleFirebaseWebhook(Request $request)
    {
        $currentData = $request->all();
        
        // Validasi data yang diterima
        if (!isset($currentData['parking_detection'])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data format'], 400);
        }
        
        $parkingData = $currentData['parking_detection'];
        
        // Proses perubahan status slot parkir
        $this->processSlotChanges($parkingData);
        
        return response()->json(['status' => 'success']);
    }
    
    /**
     * Secara manual memperbarui data dari Firebase
     */
    public function syncFromFirebase()
    {
        try {
            // Ambil konfigurasi SSL dari config
            $sslVerify = config('firebase.database.ssl_verify', false);
            
            // Ambil data dari Firebase dengan konfigurasi SSL yang sesuai
            $response = Http::withOptions([
                'verify' => $sslVerify,
                'timeout' => 30, // Meningkatkan timeout untuk memastikan data terambil lengkap
            ])->get("{$this->firebaseUrl}/parking_detection.json");
            
            if ($response->successful()) {
                $parkingData = $response->json();
                
                // Log data yang diterima untuk debugging
                logger('Firebase data received: ' . json_encode($parkingData));
                
                // Proses data yang diperoleh
                $result = $this->processSlotChanges($parkingData);
                
                // Clear cache untuk memastikan data terbaru ditampilkan
                cache()->forget('parking_histories_page_1');
                
                return redirect()->route('admin.parkir.index')
                                ->with('success', 'Data berhasil disinkronkan dari Firebase. ' . $result);
            } else {
                logger('Firebase sync failed: ' . $response->status());
                return redirect()->route('admin.parkir.index')
                                ->with('error', 'Gagal mengambil data dari Firebase: ' . $response->status());
            }
        } catch (\Exception $e) {
            logger('Firebase sync exception: ' . $e->getMessage());
            return redirect()->route('admin.parkir.index')
                            ->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Ekspor data ke CSV
     */
    public function exportCsv(Request $request)
    {
        // Query awal
        $query = ParkingHistory::query();
        
        // Filter berdasarkan tanggal jika ada
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('entry_time', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('entry_time', '<=', $request->date_to);
        }
        
        // Ambil semua data yang sesuai dengan filter
        $parkingHistories = $query->orderBy('entry_time', 'desc')->get();
        
        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set header
        $headers = [
            'No', 'Jenis Kendaraan', 'Slot Parkir', 'No. Slot', 'Tanggal',
            'Jam Masuk', 'Jam Keluar', 'Durasi', 'Status'
        ];
        
        // Tulis header
        foreach ($headers as $key => $header) {
            $sheet->setCellValue(chr(65 + $key) . '1', $header);
        }
        
        // Tulis data
        foreach ($parkingHistories as $index => $history) {
            $row = $index + 2;
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $history->vehicle_type);
            $sheet->setCellValue('C' . $row, $history->slot_label);
            $sheet->setCellValue('D' . $row, $history->slot_index);
            $sheet->setCellValue('E' . $row, $history->entry_time->format('d F Y'));
            $sheet->setCellValue('F' . $row, $history->entry_time->format('H:i'));
            $sheet->setCellValue('G' . $row, $history->exit_time ? $history->exit_time->format('H:i') : '-');
            $sheet->setCellValue('H' . $row, $history->getFormattedDuration());
            $sheet->setCellValue('I' . $row, $history->status);
        }
        
        // Auto-size kolom
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Buat nama file
        $filename = 'history_parkir_' . date('Y-m-d') . '.xlsx';
        
        // Buat writer
        $writer = new Xlsx($spreadsheet);
        
        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Output file
        $writer->save('php://output');
        exit;
    }
    
    /**
     * Proses perubahan status slot parkir
     * @return string Informasi tentang hasil pemrosesan
     */
    protected function processSlotChanges($parkingData)
    {
        // Inisialisasi counter untuk tracking perubahan
        $created = 0;
        $updated = 0;
        $errors = 0;
        
        // Ambil data status slot sebelumnya dari cache atau database
        $previousData = cache('previous_parking_data', []);
        $timestamp = isset($parkingData['timestamp']) 
            ? Carbon::parse($parkingData['timestamp'])
            : now();
        
        // Log untuk debugging
        logger('Processing parking changes. Previous data: ' . json_encode($previousData));
        logger('Total slots to process: ' . ($this->totalMotorSpots + $this->totalCarSpots));
        
        try {
            // Jika tidak ada data sebelumnya, anggap semua slot kosong
            if (empty($previousData)) {
                logger('No previous data found, initializing all slots');
                for ($i = 0; $i < ($this->totalMotorSpots + $this->totalCarSpots); $i++) {
                    $slotKey = "parking_spot_{$i}";
                    if (isset($parkingData[$slotKey]) && $parkingData[$slotKey] === 'occupied') {
                        try {
                            ParkingHistory::create([
                                'slot_index' => $i,
                                'slot_label' => $this->getParkingSlotLabel($i),
                                'vehicle_type' => $this->getVehicleType($i),
                                'entry_time' => $timestamp,
                                'status' => 'Parkir'
                            ]);
                            $created++;
                            logger("Created new parking record for slot {$i}");
                        } catch (\Exception $e) {
                            logger("Error creating parking record for slot {$i}: " . $e->getMessage());
                            $errors++;
                        }
                    }
                }
            }
            
            // Loop melalui semua slot parkir
            for ($i = 0; $i < ($this->totalMotorSpots + $this->totalCarSpots); $i++) {
                $slotKey = "parking_spot_{$i}";
                
                // Pastikan data untuk slot ini ada
                if (!isset($parkingData[$slotKey])) {
                    logger("Slot {$i} data not found in Firebase data");
                    continue;
                }
                
                $currentStatus = $parkingData[$slotKey];
                $previousStatus = $previousData[$slotKey] ?? null;
                
                logger("Processing slot {$i}: previous={$previousStatus}, current={$currentStatus}");
                
                // Jika status sebelumnya tersedia dan berbeda dengan status saat ini
                if ($previousStatus !== null && $previousStatus !== $currentStatus) {
                    // Jika slot sebelumnya kosong dan sekarang terisi, berarti ada kendaraan masuk
                    if ($previousStatus === 'empty' && $currentStatus === 'occupied') {
                        try {
                            ParkingHistory::create([
                                'slot_index' => $i,
                                'slot_label' => $this->getParkingSlotLabel($i),
                                'vehicle_type' => $this->getVehicleType($i),
                                'entry_time' => $timestamp,
                                'status' => 'Parkir'
                            ]);
                            $created++;
                            logger("Created new parking entry for slot {$i}");
                        } catch (\Exception $e) {
                            logger("Error creating parking entry for slot {$i}: " . $e->getMessage());
                            $errors++;
                        }
                    } 
                    // Jika slot sebelumnya terisi dan sekarang kosong, berarti kendaraan keluar
                    else if ($previousStatus === 'occupied' && $currentStatus === 'empty') {
                        try {
                            $record = ParkingHistory::where('slot_index', $i)
                                                ->where('status', 'Parkir')
                                                ->whereNull('exit_time')
                                                ->latest()
                                                ->first();
                            
                            if ($record) {
                                $record->exit_time = $timestamp;
                                $record->status = 'Selesai';
                                $record->save();
                                $updated++;
                                logger("Updated parking exit for slot {$i}, record ID: {$record->id}");
                            } else {
                                logger("No active parking record found for slot {$i} to mark as exited");
                            }
                        } catch (\Exception $e) {
                            logger("Error updating parking exit for slot {$i}: " . $e->getMessage());
                            $errors++;
                        }
                    }
                }
            }
            
            // Simpan data saat ini untuk perbandingan berikutnya
            cache(['previous_parking_data' => $parkingData], now()->addHours(24));
            
            // Bersihkan cache pagination untuk memastikan data terbaru ditampilkan
            for ($i = 1; $i <= 5; $i++) {
                cache()->forget("parking_histories_page_{$i}");
            }
            
            return "Berhasil memproses data: {$created} baru, {$updated} diperbarui" . ($errors > 0 ? ", {$errors} error" : "");
        } catch (\Exception $e) {
            logger("Error in processSlotChanges: " . $e->getMessage());
            return "Error memproses data: " . $e->getMessage();
        }
    }
    
    /**
     * Mengembalikan label slot parkir berdasarkan indeks
     */
    protected function getParkingSlotLabel($slotIndex)
    {
        if ($slotIndex < $this->totalMotorSpots) {
            return "R" . ($slotIndex + 1); // Mobil: M1, M2, ...
        } else {
            return "M" . ($slotIndex - $this->totalMotorSpots + 1); // Motor: R1, R2, ...
        }
    }
    
    /**
     * Mengembalikan jenis kendaraan berdasarkan indeks slot
     */
    protected function getVehicleType($slotIndex)
    {
        if ($slotIndex < $this->totalMotorSpots) {
            return "Motor";
        } else {
            return "Mobil";
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Memeriksa koneksi ke Firebase
     */
    public function checkFirebaseConnection()
    {
        try {
            // Ambil konfigurasi SSL dari config
            $sslVerify = config('firebase.database.ssl_verify', false);
            
            // Coba ambil data sederhana dari Firebase
            $response = Http::withOptions([
                'verify' => $sslVerify,
            ])->get("{$this->firebaseUrl}/test.json");
            
            $data = $response->json();
            
            if ($response->successful() && $data) {
                return [
                    'success' => true,
                    'message' => 'Koneksi ke Firebase berhasil',
                    'data' => $data
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Koneksi gagal: ' . $response->status(),
                    'data' => null
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
    
    /**
     * Halaman untuk memeriksa status koneksi Firebase
     */
    public function testConnection()
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        $connectionStatus = $this->checkFirebaseConnection();
        
        return view('admin.testFirebaseConnection', compact('connectionStatus'));
    }
}
