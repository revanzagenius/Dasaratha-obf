<?php

namespace App\Http\Controllers;

use App\Models\HackerNews;
use Illuminate\Http\Request;
use App\Models\CyberSecurityNews;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\NewsAPIService; // Gunakan NewsAPIService

class NewsController extends Controller
{

    public function index()
    {
        $latestNews = CyberSecurityNews::orderBy('published_at', 'desc')->take(9)->get();
        $otherNews = CyberSecurityNews::orderBy('published_at', 'desc')->skip(9)->take(20)->get();

        return view('news', compact('latestNews', 'otherNews'));
    }

    // public function show()
    // {
    //     $latestNews = CyberSecurityNews::orderBy('published_at', 'desc')->take(9)->get();
    //     $otherNews = CyberSecurityNews::orderBy('published_at', 'desc')->skip(9)->take(20)->get();

    //     return view('news', compact('latestNews', 'otherNews'));
    // }

    public function malware()
    {
        // Membaca data dari file JSON
        $json_data = file_get_contents(storage_path('app/malware_trends.json'));

        // Mengubah data JSON menjadi array
        $malware_data = json_decode($json_data, true);

        // Memeriksa jika data valid sebelum mengirimkan ke view
        if ($malware_data === null) {
            return view('malware')->with('malware_data', []);
        }

        // Menambahkan previous_rank untuk perbandingan
        foreach ($malware_data as &$malware) {
            // Jika previous_rank tidak ada, set previous_rank ke nilai rank sebelumnya
            if (!isset($malware['previous_rank'])) {
                $malware['previous_rank'] = $malware['rank'];
            }
        }

        // Mengurutkan data berdasarkan rank (peringkat)
        usort($malware_data, function ($a, $b) {
            return $a['rank'] <=> $b['rank'];
        });

        // Menyimpan kembali data JSON setelah perbaikan
        file_put_contents(storage_path('app/malware_trends.json'), json_encode($malware_data, JSON_PRETTY_PRINT));

        return view('malware')->with('malware_data', $malware_data);
    }

    public function detail($name)
    {
        $trends_json = file_get_contents(storage_path('app/malware_trends.json'));
        $description_json = file_get_contents(storage_path('app/malware_description.json'));

        $trends_data = json_decode($trends_json, true);
        $description_data = json_decode($description_json, true);

        $malware_trend = collect($trends_data)->firstWhere('name', $name);
        $malware_description = collect($description_data)->firstWhere('name', $name);

        if (!$malware_trend || !$malware_description) {
            abort(404, 'Malware not found');
        }

        // Format ulang IOCs menjadi kategori
        $formatted_iocs = [
            'IP addresses' => array_filter($malware_description['iocs'], fn($ioc) => filter_var($ioc, FILTER_VALIDATE_IP)),
            'domains' => array_filter($malware_description['domains'], fn($ioc) => preg_match('/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $ioc)),
            'URLs' => array_filter($malware_description['iocs'], fn($ioc) => filter_var($ioc, FILTER_VALIDATE_URL)),
        ];


        // Ambil video URL (jika ada)
        $video_url = $malware_description['video_url'] ?? null;

        $malware_detail = array_merge($malware_trend, $malware_description, ['iocs' => $formatted_iocs, 'video_url' => $video_url]);

        return view('malware-detail')->with('malware', $malware_detail);
    }


    public function Feeds()
{
    // Cek apakah file ada di path yang diberikan
    $jsonPath = storage_path('app/cve.json');

    // Pastikan file ada
    if (!file_exists($jsonPath)) {
        return abort(404, 'File not found');
    }

    // Ambil data dari file feeds.json
    $feeds = json_decode(file_get_contents($jsonPath), true);

    // Cek apakah data valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        return abort(500, 'Invalid JSON data');
    }

    // Pass data ke view
    return view('feeds.index', ['feeds' => $feeds]);
}

        public function hackernews()
    {
        $articles = HackerNews::orderBy('published_at', 'desc')->get();

        $latestNews = $articles->take(9);
        $otherNews = $articles->slice(9);

        return view('news.index', compact('latestNews', 'otherNews'));
    }

}
