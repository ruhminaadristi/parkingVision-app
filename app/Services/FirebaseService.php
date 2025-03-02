<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $client;
    protected $databaseUrl;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);

        $this->databaseUrl = rtrim(config('firebase.database.url'), '/');
    }

    public function testConnection()
    {
        try {
            $response = $this->client->request('GET', $this->databaseUrl . '/.json', [
                'http_errors' => false
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                if (isset($data['parking_detection'])) {
                    Log::info('Firebase connected successfully');
                    return true;
                }
            }

            Log::warning('Firebase connection test failed', [
                'status_code' => $response->getStatusCode()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Firebase connection error', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function getParkingData()
    {
        try {
            $response = $this->client->get($this->databaseUrl . '/parking_detection.json');
            $data = json_decode($response->getBody(), true);

            if (!$data) {
                return $this->getEmptyDataStructure();
            }

            return [
                'vehicles' => [
                    'Bicycle' => [
                        'total' => $data['Bicycle'] ?? 0,
                        'in_parking' => $data['Bicycle_in_parking'] ?? 0
                    ],
                    'Car' => [
                        'total' => $data['Car'] ?? 0,
                        'in_parking' => $data['Car_in_parking'] ?? 0
                    ],
                    'Motorcycle' => [
                        'total' => $data['Motorcycle'] ?? 0,
                        'in_parking' => $data['Motorcycle_in_parking'] ?? 0
                    ]
                ],
                'total_objects' => $data['total_objects'] ?? 0,
                'total_in_parking' => $data['total_in_parking'] ?? 0,
                'timestamp' => $data['timestamp'] ?? 'No Data',
                'parking_spots' => array_map(function($i) use ($data) {
                    $key = "parking_spot_" . $i;
                    return [
                        'number' => $i,
                        'status' => $data[$key] ?? 'empty'
                    ];
                }, range(0, 5))
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get parking data:', [
                'message' => $e->getMessage()
            ]);
            return $this->getEmptyDataStructure();
        }
    }

    private function getEmptyDataStructure()
    {
        return [
            'vehicles' => [
                'Bicycle' => ['total' => 0, 'in_parking' => 0],
                'Car' => ['total' => 0, 'in_parking' => 0],
                'Motorcycle' => ['total' => 0, 'in_parking' => 0]
            ],
            'total_objects' => 0,
            'total_in_parking' => 0,
            'timestamp' => 'System not running',
            'parking_spots' => array_map(function($i) {
                return [
                    'number' => $i,
                    'status' => 'empty'
                ];
            }, range(0, 5))
        ];
    }
}
