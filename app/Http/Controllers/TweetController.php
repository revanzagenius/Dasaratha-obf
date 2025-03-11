<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TweetController extends Controller
{
    public function dashboard()
{
    // Ambil jumlah sentimen
    $positive = DB::table('tweets')->where('sentiment', 'positive')->count();
    $negative = DB::table('tweets')->where('sentiment', 'negative')->count();
    $neutral = DB::table('tweets')->where('sentiment', 'neutral')->count();

    // Ambil tren sentimen harian
    $trendData = DB::table('tweets')
        ->selectRaw("DATE(created_at) as date,
                     SUM(CASE WHEN sentiment = 'positive' THEN 1 ELSE 0 END) as positive,
                     SUM(CASE WHEN sentiment = 'negative' THEN 1 ELSE 0 END) as negative,
                     SUM(CASE WHEN sentiment = 'neutral' THEN 1 ELSE 0 END) as neutral")
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Format data untuk chart
    $dates = $trendData->pluck('date')->toArray();
    $positiveTrends = $trendData->pluck('positive')->toArray();
    $negativeTrends = $trendData->pluck('negative')->toArray();
    $neutralTrends = $trendData->pluck('neutral')->toArray();

    // Ambil tweet terbaru dengan paginasi 5
    $tweets = DB::table('tweets')->orderBy('created_at', 'desc')->paginate(5);

    return view('x feed.dashboard', compact(
        'positive', 'negative', 'neutral',
        'dates', 'positiveTrends', 'negativeTrends', 'neutralTrends',
        'tweets'
    ));
}


    public function index()
    {
        $tweets = Tweet::latest()->paginate(10);
        return view('x feed.index', compact('tweets'));
    }

}
