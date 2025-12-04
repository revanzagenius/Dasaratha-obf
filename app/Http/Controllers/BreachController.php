<?php

namespace App\Http\Controllers;

use App\Models\BreachRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class BreachController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Ambil data dari database
        $query = BreachRecord::query();

        if ($search) {
            $query->where('Title', 'like', "%{$search}%")
                ->orWhere('Name', 'like', "%{$search}%");
        }

        $sortedData = $query->orderByDesc('BreachDate')->get();

        // Pagination
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $sortedData->slice(($currentPage - 1) * $perPage, $perPage);
        $paginatedData = new LengthAwarePaginator($currentItems, $sortedData->count(), $perPage);
        $paginatedData->setPath($request->url());

        // Chart data (10 terbaru)
        $latestChartData = $sortedData->take(10)->map(function ($item) {
            return [
                'title' => $item->Title,
                'count' => $item->PwnCount,
            ];
        });

        $latestData = $sortedData->first();
        session(['latestData' => $latestData]);

        return view('breaches.index', [
            'chartData' => $latestChartData->values(),
            'data' => $paginatedData,
            'search' => $search,
            'latestData' => $latestData,
        ]);
    }
}
