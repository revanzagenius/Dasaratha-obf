<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class BreachController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari request
        $search = $request->query('search');

        if ($search) {
            // Jika ada pencarian, panggil API untuk mendapatkan data breach spesifik
            $response = Http::get("https://haveibeenpwned.com/api/v3/breach/{$search}");

            // Jika data tidak ditemukan, kembalikan pesan error
            if ($response->status() === 404) {
                return back()->withErrors(['search' => 'Data breach not found.']);
            }

            // Decode data JSON
            $data = collect([$response->json()]);
        } else {
            // Ambil semua data breach jika tidak ada pencarian
            $response = Http::get('https://haveibeenpwned.com/api/v3/breaches');
            $data = collect($response->json());
        }

        // Urutkan data berdasarkan tahun terbaru pada `BreachDate`
        $sortedData = $data->sortByDesc(function ($item) {
            return strtotime($item['BreachDate']);
        });

        // Tambahkan pagination dengan 10 data per halaman
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $sortedData->slice(($currentPage - 1) * $perPage, $perPage);
        $paginatedData = new LengthAwarePaginator($currentItems, $sortedData->count(), $perPage);
        $paginatedData->setPath($request->url());

        // Ambil 10 data terbaru untuk chart
        $latestChartData = $sortedData->take(10)->map(function ($item) {
            return [
                'title' => $item['Title'],
                'count' => $item['PwnCount'],
            ];
        });

        // Kirim data ke view
        return view('breaches.index', [
            'chartData' => $latestChartData->values(),
            'data' => $paginatedData,
            'search' => $search,
        ]);
    }
}
