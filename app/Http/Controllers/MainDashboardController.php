<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Breach;
use App\Models\HackerNews;
use App\Models\ShodanHost;
use App\Models\BreachRecord;
use Illuminate\Http\Request;
use App\Models\Vulnerability;
use App\Models\DehashedResult;
use App\Services\NewsAPIService;
use App\Models\CyberSecurityNews;
use App\Models\MostRecentIpReport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\DeHashedController;
use Illuminate\Pagination\LengthAwarePaginator;



class MainDashboardController extends Controller
{
    protected $newsService;

    public function __construct(NewsAPIService $newsService)
    {
        $this->newsService = $newsService;
    }
    public function index(Request $request)
    {
        // Domain
        $domains = ShodanHost::all();

        // Siapkan data untuk chart
        $domainData = [];
        foreach ($domains as $domain) {
            $domainList = json_decode($domain->domains, true); // Decode JSON
            $ports = json_decode($domain->ports, true); // Decode ports
            $vulns = json_decode($domain->vulns, true); // Decode vulns

            foreach ($domainList as $d) {
                $domainData[$d] = [
                    'ports' => count($ports), // Hitung jumlah port
                    'vulns' => count($vulns), // Hitung jumlah vuln
                ];
            }
        }

        // Data Breach
        $vip_list = Breach::all()->count();
        $latest_breach = DehashedResult::latest()->first();
        $dehashedController = new DeHashedController();
        $allData = $dehashedController->getAllData();

        // CVE
        $newCveToday = Vulnerability::whereDate('published_at', Carbon::today())->count();
        $updatedToday = Vulnerability::whereDate('updated_at', Carbon::today())->count();
        $weeklyExploited = Vulnerability::whereBetween('published_at', [Carbon::now()->subDays(7), Carbon::now()])->count();
        $totalCVE = Vulnerability::all()->count();
        $vulnerabilities = Vulnerability::select('cvss_score')->get();


        $cvssGroups = [
            '1.0' => 0,
            '2.0' => 0,
            '3.0' => 0,
            '4.0' => 0,
            '5.0' => 0,
            '6.0' => 0,
            '7.0' => 0,
            '8.0' => 0,
            '9.0' => 0,
            '10.0' => 0,
            'Undefined' => 0
        ];

        foreach ($vulnerabilities as $vuln) {
            $score = $vuln->cvss_score;

            if ($score >= 1.0 && $score < 2.0) {
                $cvssGroups['1.0']++;
            } elseif ($score >= 2.0 && $score < 3.0) {
                $cvssGroups['2.0']++;
            } elseif ($score >= 3.0 && $score < 4.0) {
                $cvssGroups['3.0']++;
            } elseif ($score >= 4.0 && $score < 5.0) {
                $cvssGroups['4.0']++;
            } elseif ($score >= 5.0 && $score < 6.0) {
                $cvssGroups['5.0']++;
            } elseif ($score >= 6.0 && $score < 7.0) {
                $cvssGroups['6.0']++;
            } elseif ($score >= 7.0 && $score < 8.0) {
                $cvssGroups['7.0']++;
            } elseif ($score >= 8.0 && $score < 9.0) {
                $cvssGroups['8.0']++;
            } elseif ($score >= 9.0 && $score < 10.0) {
                $cvssGroups['9.0']++;
            } elseif ($score == 10.0) {
                $cvssGroups['10.0']++;
            } else {
                $cvssGroups['Undefined']++;
            }
        }


        // Global Data Breach
        $latestData = session('latestData');

        // Password
        $filePath = storage_path('app/10_million_password_list_top_10000.txt');

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        $passwords = explode("\n", file_get_contents($filePath));
        $totalPasswords = count($passwords);

        $onlyLetters = 0;
        $onlyNumbers = 0;
        $lettersAndNumbers = 0;
        $etc = 0;

        foreach ($passwords as $password) {
            $password = trim($password);

            if (preg_match('/^[A-Za-z]+$/', $password)) {
                $onlyLetters++;
            } elseif (preg_match('/^[0-9]+$/', $password)) {
                $onlyNumbers++;
            } elseif (preg_match('/^[A-Za-z0-9]+$/', $password)) {
                $lettersAndNumbers++;
            } else {
                $etc++;
            }
        }

        $recentPasswords = file_exists($filePath)
            ? array_slice(file($filePath, FILE_IGNORE_NEW_LINES), 0, 10)
            : [];

        // Malware Trends Data
        $json_data = file_get_contents(storage_path('app/malware_trends.json'));
        $malware_data = json_decode($json_data, true);

        // Data Utama
        $totalMalware = count($malware_data);
        $topMalwares = collect($malware_data)
            ->sortBy('rank')
            ->take(10)
            ->map(function ($item) {
                $item['trend'] = $item['rank'] < $item['previous_rank'] ? 'up' : ($item['rank'] > $item['previous_rank'] ? 'down' : 'stable');
                return $item;
            });

        // Hitung Tipe Malware
        // $typeCounts = collect($malware_data)->groupBy('type')->map->count()->sortDesc();

        $typeCounts = [];

        foreach ($malware_data as $malware) {
            $type = $malware['type'] ?? 'Unknown';

            if (isset($typeCounts[$type])) {
                $typeCounts[$type]++;
            } else {
                $typeCounts[$type] = 1;
            }
        }
        // Malware Paling Aktif (Position)
        $mostActiveMalwares = collect($malware_data)
            ->sortByDesc('position')
            ->take(10)
            ->values()
            ->all();

        // Rank Changes
        $rankChanges = collect($malware_data)
            ->filter(fn($m) => $m['rank'] != $m['previous_rank'])
            ->sortByDesc(fn($m) => abs($m['rank'] - $m['previous_rank']))
            ->take(5)
            ->values()
            ->all();

        // Threat Actor
        $jsonData = file_get_contents(storage_path('app/Threat-Actor.json'));
        $data = json_decode($jsonData, true);

        $threatGroups = collect($data['values']);
        $allThreatGroups = $threatGroups;
        $totalThreatGroups = $threatGroups->count();

        // Global Data Breach (pakai DB)
        $search = $request->query('search');

        $query = BreachRecord::query();

        if ($search) {
            $query->where('Title', 'like', "%{$search}%")
                ->orWhere('Name', 'like', "%{$search}%");
        }

        $sortedData = $query->orderByDesc('BreachDate')->get();

        // Pagination
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $sortedData->slice(($currentPage - 1) * $perPage, $perPage);
        $paginatedData = new LengthAwarePaginator($currentItems, $sortedData->count(), $perPage);
        $paginatedData->setPath($request->url());

        // Chart Data (10 terbaru)
        $latestChartData = $sortedData->take(10)->map(function ($item) {
            return [
                'title' => $item->Title,
                'count' => $item->PwnCount,
            ];
        });

        $totalDataCount = $sortedData->count();
        $chartData = $latestChartData->values();

        //Global Ip Spam
        $latestEntriesGlobalSpam = MostRecentIpReport::orderBy('reported_at', 'desc')->limit(5)->get();

        //News
        // Ambil data dari database, urutkan berdasarkan waktu terbaru, dan ambil 5 berita terbaru
        $latestCybersecurityNews = CyberSecurityNews::orderBy('published_at', 'desc')->limit(5)->get();
        $latestHackerNews = HackerNews::orderBy('published_at', 'desc')->limit(5)->get();



        return view('main-dashboard', compact(
            'domainData',
            'domains',
            'allData',
            'newCveToday',
            'updatedToday',
            'weeklyExploited',
            'latestData',
            'totalPasswords',
            'onlyLetters',
            'onlyNumbers',
            'lettersAndNumbers',
            'etc',
            'totalMalware',
            'typeCounts',
            'mostActiveMalwares',
            'rankChanges',
            'topMalwares',
            'cvssGroups',
            'allThreatGroups',
            'totalThreatGroups',
            'vip_list',
            'latestData',
            'chartData',
            'paginatedData',
            'totalDataCount',
            'totalCVE',
            'recentPasswords',
            'latestEntriesGlobalSpam',
            'latestCybersecurityNews',
            'latestHackerNews'

        ));
    }
}
