<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class ThreatController extends Controller
{
    public function index(Request $request)
    {
        // Membaca file JSON dari storage
        $jsonData = file_get_contents(storage_path('app/Threat-Actor.json'));

        // Decode JSON ke array
        $data = json_decode($jsonData, true);

        // Ambil data dari properti "values", gunakan array kosong jika tidak ada
        $threatGroups = collect($data['values'] ?? []);

        // Jika ada parameter 'search', filter data berdasarkan Threat Actor atau Country
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = strtolower($request->search); // Menyimpan kata pencarian
            $threatGroups = $threatGroups->filter(function ($group) use ($searchTerm) {
                // Pastikan 'name' dan 'country' ada dan bertipe string sebelum diproses
                $name = isset($group['actor']) ? (is_array($group['actor']) ? implode(' ', $group['actor']) : (string) $group['actor']) : '';
                $country = isset($group['country']) ? (is_array($group['country']) ? implode(' ', $group['country']) : (string) $group['country']) : '';

                // Debugging: Cek apakah actor atau country mengandung searchTerm
                // dd($name, $country, stripos(strtolower($name), $searchTerm), stripos(strtolower($country), $searchTerm));

                // Pencarian berdasarkan nama group atau country
                return stripos(strtolower($name), $searchTerm) !== false ||
                       stripos(strtolower($country), $searchTerm) !== false;
            });
        }

        // Urutkan berdasarkan `last-card-change` dari terbaru ke lama
        $threatGroups = $threatGroups->sortByDesc(function ($group) {
            return isset($group['last-card-change'])
                ? Carbon::parse($group['last-card-change'])->timestamp
                : 0;
        });

        // **Simpan seluruh data yang sudah terurut untuk chart**
        $allThreatGroups = $threatGroups->values(); // Pastikan indeks array diperbaiki

        // Menentukan jumlah item per halaman
        $perPage = 10;

        // Paginasi manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $threatGroups->slice(($currentPage - 1) * $perPage, $perPage);
        $paginatedThreatGroups = new LengthAwarePaginator($currentItems, $threatGroups->count(), $perPage);

        // Menetapkan URL untuk pagination
        $paginatedThreatGroups->setPath(url()->current());

        // Kirim data ke view
        return view('threats.index', compact('paginatedThreatGroups', 'allThreatGroups'));
    }


}

