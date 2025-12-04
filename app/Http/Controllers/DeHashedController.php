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

        $allData = DehashedResult::all()->map(function ($entry) {
            $entry->updated_at = Carbon::parse($entry->updated_at);
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
    // CEK: apakah domain sudah discan hari ini?
    $existing = DehashedResult::where('domain', $domain)
        ->whereDate('last_scanned_at', Carbon::today())
        ->first();

    if ($existing) {
        // Ambil data existing dari DB tanpa API call
        return [
            'total_results' => DehashedResult::where('domain', $domain)->count(),
            'entries'       => DehashedResult::where('domain', $domain)->get(),
            'status'        => 'cached'
        ];
    }

    // Jika BELUM discan hari ini → scan API
    $url = 'https://api.dehashed.com/v2/search';
    $apiKey = env('DEHASHED_API_KEY');

    $response = Http::withHeaders([
        'Dehashed-Api-Key' => $apiKey,
        'Content-Type' => 'application/json',
    ])->post($url, [
        'query' => "domain:$domain",
        'page' => 1,
        'size' => 100
    ]);

    if (!$response->successful()) {
        Log::error('Dehashed failed: '.$response->body());
        return null;
    }

    $data = $response->json();

    // HAPUS DATA LAMA sebelum insert data scan baru
    DehashedResult::where('domain', $domain)->delete();

    if (!empty($data['entries'])) {

        foreach ($data['entries'] as $entry) {
            DehashedResult::create([
                'domain'        => $domain,
                'username'      => $this->normalize($entry['username'] ?? null),
                'email'         => $this->normalize($entry['email'] ?? null),
                'password'      => $this->normalize($entry['password'] ?? null),
                'hash'          => $this->normalize($entry['hash'] ?? null),
                'source_url'    => $this->extractUrl($entry),
                'status'        => 'found',
                'last_scanned_at' => now(),
            ]);
        }
    } else {
        DehashedResult::create([
            'domain' => $domain,
            'status' => 'clean',
            'last_scanned_at' => now(),
        ]);
    }

    return $data;
}


private function normalize($value)
{
    if (is_array($value)) {
        return $value[0] ?? null;
    }
    return $value;
}

private function extractUrl($entry)
{
    // 1. Kalau ada field 'url' langsung dari API
    if (isset($entry['url'])) {

        $url = is_array($entry['url'])
            ? ($entry['url'][0] ?? null)
            : $entry['url'];

        if ($url) {
            // Kalau tidak ada http/https → tambahkan otomatis
            if (!preg_match('/^https?:\/\//i', $url)) {
                return "https://" . $url;
            }
            return $url;
        }
    }

    // 2. Jika tidak ada field url, scan semua kolom pakai regex
    foreach ($entry as $value) {

        if (is_array($value)) {
            $value = $value[0] ?? null;
        }

        if (!$value || !is_string($value)) continue;

        preg_match('/(https?:\/\/[^\s"]+)/i', $value, $match);

        if (!empty($match)) {
            return $match[0];
        }
    }

    return null;
}




}
