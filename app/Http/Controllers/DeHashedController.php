<?php

namespace App\Http\Controllers;

use App\Models\Breach;
use App\Models\DehashedResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeHashedController extends Controller
{
    public function index()
    {
        $domain = 'obf.id';
        $data = $this->search($domain);
        $vip_list = Breach::all();

        // Mengambil semua data dan memastikan 'updated_at' adalah objek Carbon
        $allData = DehashedResult::all()->map(function ($entry) {
            $entry->updated_at = Carbon::parse($entry->updated_at); // Konversi ke objek Carbon
            return $entry;
        });

        return view('dehashed.index', compact('data', 'allData', 'vip_list'));
    }

    public function getAllData()
    {
        return DehashedResult::all()->map(function ($entry) {
            $entry->updated_at = Carbon::parse($entry->updated_at);
            return $entry;
        });
    }


    public function search($domain)
    {
        $lastScan = DehashedResult::where('domain', $domain)->latest()->first();

        if ($lastScan && $lastScan->last_scanned_at) {
            $lastScannedAt = Carbon::parse($lastScan->last_scanned_at);

            if ($lastScannedAt->isToday()) {
                return [];
            }

            if ($lastScannedAt->diffInDays(Carbon::now()) < 1) {
                return [];
            }
        }

        $url = 'https://api.dehashed.com/v2/search';
        $query = 'domain:' . $domain;

        $apiKey = env('DEHASHED_API_KEY');

        // Kirim POST request ke Dehashed v2
        $response = Http::withHeaders([
            'Dehashed-Api-Key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post($url, [
            'query' => $domain, // Misalnya: 'bri.co.id'
            'page' => 1,
            'size' => 100,
            'regex' => false,
            'wildcard' => false,
            'de_dupe' => false
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['entries']) && count($data['entries']) > 0) {
                foreach ($data['entries'] as $entry) {
                    DehashedResult::create([
                        'domain' => $domain,
                        'username' => $entry['username'][0] ?? null,
                        'email' => $entry['email'][0] ?? null,
                        'password' => $entry['password'][0] ?? null,
                        'status' => 'found',
                        'last_scanned_at' => now(),
                    ]);
                }
            } else {
                DehashedResult::create([
                    'domain' => $domain,
                    'username' => null,
                    'email' => null,
                    'password' => null,
                    'status' => 'null',
                    'last_scanned_at' => now(),
                ]);
            }

            return $data;
        }

        Log::error('API request failed for domain: ' . $domain . ' | Response: ' . $response->body());
        return null;
    }
}
