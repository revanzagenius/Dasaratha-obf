<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndonesiaIpReport;
use App\Models\MostRecentIpReport;
use Illuminate\Support\Facades\Http;

class RSSFeedController extends Controller
{

    public function mostrecent()
    {
        $latestEntries = MostRecentIpReport::orderBy('reported_at', 'desc')->take(10)->get();
        $otherEntries = MostRecentIpReport::orderBy('reported_at', 'desc')->skip(10)->take(50)->get();

        return view('rss.mostrecent', compact('latestEntries', 'otherEntries'));
    }


    public function indonesia()
    {
        $latestEntries = IndonesiaIpReport::orderBy('reported_at', 'desc')->take(10)->get();
        $otherEntries = IndonesiaIpReport::orderBy('reported_at', 'desc')->skip(10)->take(50)->get();

        return view('rss.indonesia', compact('latestEntries', 'otherEntries'));
    }

}
