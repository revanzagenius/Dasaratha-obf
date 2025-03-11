<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class OTXController extends Controller
{
    private $apiKey = "ff22daa1e66463916add9e0dcc9b1f911f8474d04143fcdd5c44ce1165c0efe6";

    // Menampilkan daftar pulses yang sudah di-subscribe atau hasil pencarian
    public function index(Request $request)
    {
        $searchResults = null;
        if ($request->has('q')) {
            $searchResults = $this->search($request->input('q'));
            return view('otx.index', compact('searchResults'))->with('pulses', ['results' => []]);
        }

        $response = Http::withHeaders([
            'X-OTX-API-KEY' => $this->apiKey
        ])->get('https://otx.alienvault.com/api/v1/pulses/subscribed', [
            'limit' => 10, // Ambil hingga 50 pulses dalam satu permintaan
            'page' => request()->get('page', 1) // Ambil halaman pertama jika tidak ada parameter
        ]);

        $pulses = $response->successful() ? $response->json() : ['results' => []];

        return view('otx.index', compact('pulses', 'searchResults'));
    }

    // Fungsi pencarian menggunakan API
    private function search($query)
    {
        $response = Http::withHeaders([
            'X-OTX-API-KEY' => $this->apiKey
        ])->get("https://otx.alienvault.com/api/v1/search/pulses", [
            'q' => $query,
            'limit' => 50 // Menampilkan hingga 50 data
        ]);

        return $response->successful() ? $response->json() : ['results' => []];
    }

    // Menampilkan detail pulse berdasarkan ID
    public function show($id)
    {
        $response = Http::withHeaders([
            'X-OTX-API-KEY' => $this->apiKey
        ])->get("https://otx.alienvault.com/api/v1/pulses/{$id}");

        if ($response->successful()) {
            $pulse = $response->json();
            return view('otx.detail', compact('pulse'));
        }

        return back()->with('error', 'Pulse tidak ditemukan.');
    }

    // Download Pulse dalam bentuk PDF
    public function downloadPdf($id)
    {
        $response = Http::withHeaders([
            'X-OTX-API-KEY' => $this->apiKey
        ])->get("https://otx.alienvault.com/api/v1/pulses/{$id}");

        if (!$response->successful()) {
            return back()->with('error', 'Pulse tidak ditemukan.');
        }

        $pulse = $response->json();
        $pdf = Pdf::loadView('otx.pdf', compact('pulse'));
        $filename = 'Pulse_' . ($pulse['id'] ?? 'Unknown') . '.pdf';

        return $pdf->download($filename);
    }
}
