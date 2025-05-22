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
    protected $totalCarSpots = 7; // Slot 0-6 untuk mobil
    protected $totalMotorSpots = 8; // Slot 7-14 untuk motor
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
        
        // Ambil data dan urutkan berdasarkan waktu masuk terbaru
        $parkingHistories = $query->orderBy('entry_time', 'desc')
                                 ->paginate(10);
        
        return view('admin.manajemenDataParkir', compact('parkingHistories'));
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
            ])->get("{$this->firebaseUrl}/parking_detection.json");
            
            if ($response->successful()) {
                $parkingData = $response->json();
                
                // Proses data yang diperoleh
                $this->processSlotChanges($parkingData);
                
                return redirect()->route('admin.parkir.index')
                                ->with('success', 'Data berhasil disinkronkan dari Firebase');
            } else {
                return redirect()->route('admin.parkir.index')
                                ->with('error', 'Gagal mengambil data dari Firebase: ' . $response->status());
            }
        } catch (\Exception $e) {
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
     */
    protected function processSlotChanges($parkingData)
    {
        // Ambil data status slot sebelumnya dari cache atau database
        $previousData = cache('previous_parking_data', []);
        $timestamp = isset($parkingData['timestamp']) 
            ? Carbon::parse($parkingData['timestamp'])
            : now();
        
        // Loop melalui semua slot parkir
        for ($i = 0; $i < ($this->totalCarSpots + $this->totalMotorSpots); $i++) {
            $slotKey = "parking_spot_{$i}";
            
            // Pastikan data untuk slot ini ada
            if (!isset($parkingData[$slotKey])) {
                continue;
            }
            
            $currentStatus = $parkingData[$slotKey];
            $previousStatus = $previousData[$slotKey] ?? null;
            
            // Jika status sebelumnya tersedia dan berbeda dengan status saat ini
            if ($previousStatus !== null && $previousStatus !== $currentStatus) {
                // Jika slot sebelumnya kosong dan sekarang terisi, berarti ada kendaraan masuk
                if ($previousStatus === 'empty' && $currentStatus === 'occupied') {
                    ParkingHistory::create([
                        'slot_index' => $i,
                        'slot_label' => $this->getParkingSlotLabel($i),
                        'vehicle_type' => $this->getVehicleType($i),
                        'entry_time' => $timestamp,
                        'status' => 'Parkir'
                    ]);
                } 
                // Jika slot sebelumnya terisi dan sekarang kosong, berarti kendaraan keluar
                else if ($previousStatus === 'occupied' && $currentStatus === 'empty') {
                    $record = ParkingHistory::where('slot_index', $i)
                                         ->where('status', 'Parkir')
                                         ->whereNull('exit_time')
                                         ->latest()
                                         ->first();
                    
                    if ($record) {
                        $record->exit_time = $timestamp;
                        $record->status = 'Selesai';
                        $record->save();
                    }
                }
            }
        }
        
        // Simpan data saat ini untuk perbandingan berikutnya
        cache(['previous_parking_data' => $parkingData], now()->addHours(24));
    }
    
    /**
     * Mengembalikan label slot parkir berdasarkan indeks
     */
    protected function getParkingSlotLabel($slotIndex)
    {
        if ($slotIndex < $this->totalCarSpots) {
            return "M" . ($slotIndex + 1); // Mobil: M1, M2, ...
        } else {
            return "R" . ($slotIndex - $this->totalCarSpots + 1); // Motor: R1, R2, ...
        }
    }
    
    /**
     * Mengembalikan jenis kendaraan berdasarkan indeks slot
     */
    protected function getVehicleType($slotIndex)
    {
        if ($slotIndex < $this->totalCarSpots) {
            return "Mobil";
        } else {
            return "Motor";
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
