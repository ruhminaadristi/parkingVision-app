<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index()
    {
        // Test koneksi terlebih dahulu
        $isConnected = $this->firebaseService->testConnection();

        if (!$isConnected) {
            Log::error('Failed to connect to Firebase');
            return view('public.index', ['parkingData' => null, 'connectionError' => true]);
        }

        $parkingData = $this->firebaseService->getParkingData();
        return view('public.index', [
            'parkingData' => $parkingData,
            'connectionError' => false
        ]);
    }
}
