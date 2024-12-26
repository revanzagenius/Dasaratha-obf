<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DehashedResult;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DeHashedController extends Controller
{
    public function index()
    {
        $domain = 'obf.id';
        $data = $this->search($domain);

        // Mengambil semua data dan memastikan 'updated_at' adalah objek Carbon
        $allData = DehashedResult::all()->map(function($entry) {
            $entry->updated_at = Carbon::parse($entry->updated_at); // Konversi ke objek Carbon
            return $entry;
        });

        return view('dehashed.index', compact('data', 'allData'));
    }

    public function search($domain)
{
    $lastScan = DehashedResult::where('domain', $domain)->latest()->first();

    // Jika sudah dipindai dalam 24 jam terakhir, jangan lakukan scan lagi
    if ($lastScan && $lastScan->last_scanned_at) {
        // Pastikan last_scanned_at adalah objek Carbon
        $lastScannedAt = Carbon::parse($lastScan->last_scanned_at);

        if ($lastScannedAt->isToday()) {
            return []; // Return empty jika sudah dipindai hari ini
        }

        // Jika sudah lebih dari 24 jam, lakukan scan lagi
        if ($lastScannedAt->diffInDays(Carbon::now()) < 1) {
            return []; // Tidak melakukan scan jika sudah dipindai dalam 24 jam terakhir
        }
    }

    // Lanjutkan dengan proses pemindaian jika belum dipindai hari ini
    $url = 'https://api.dehashed.com/search';
    $query = 'domain:' . $domain;
    $username = env('DEHASHED_USERNAME');
    $password = env('DEHASHED_PASSWORD');

    // Send HTTP GET request
    $response = Http::withBasicAuth($username, $password)
        ->accept('application/json')
        ->get($url, [
            'query' => $query,
        ]);

    if ($response->successful()) {
        $data = $response->json();

        if (isset($data['entries']) && count($data['entries']) > 0) {
            foreach ($data['entries'] as $entry) {
                DehashedResult::create([
                    'domain' => $domain,
                    'username' => $entry['username'] ?? null,
                    'email' => $entry['email'] ?? null,
                    'password' => $entry['password'] ?? null,
                    'status' => 'found',
                    'last_scanned_at' => now(), // Set waktu pemindaian
                ]);
            }
        } else {
            DehashedResult::create([
                'domain' => $domain,
                'username' => null,
                'email' => null,
                'password' => null,
                'status' => 'null',
                'last_scanned_at' => now(), // Set waktu pemindaian
            ]);
        }

        return $data;
    }

    Log::error('API request failed for domain: ' . $domain);
    return null;
}
}
