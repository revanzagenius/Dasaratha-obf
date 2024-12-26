<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DehashedResult;
use Illuminate\Support\Facades\Http;

class DeHashedController extends Controller
{

    public function showForm()
    {
        // Menampilkan view untuk form input
        return view('dehashed.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'domain' => 'required|string',
        ]);

        $url = 'https://api.dehashed.com/search';
        $query = 'domain:' . $request->input('domain');
        $username = 'andris@sthree.co.id';
        $password = '0ewmxewc19o9fmohw46p7fb69ia86lbg';

        $response = Http::withBasicAuth($username, $password)
            ->accept('application/json')
            ->get($url, ['query' => $query]);

        if ($response->successful()) {
            $data = $response->json();

            // Simpan hasil ke database
            if (isset($data['entries']) && is_array($data['entries'])) {
                foreach ($data['entries'] as $entry) {
                    DehashedResult::create([
                        'domain' => $request->input('domain'),
                        'username' => $entry['username'] ?? null,
                        'email' => $entry['email'] ?? null,
                        'password' => $entry['password'] ?? null,
                        'hash' => $entry['hash'] ?? null,
                    ]);
                }
            }

            return view('dehashed.results', compact('data'));
        } else {
            return response()->json([
                'error' => 'Failed to fetch data',
                'status' => $response->status(),
            ]);
        }
}
}
