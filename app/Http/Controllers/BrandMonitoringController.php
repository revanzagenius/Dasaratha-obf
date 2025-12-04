<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandMention;

class BrandMonitoringController extends Controller
{
    public function index()
    {
        $platformCounts = BrandMention::select('platform')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('platform')
            ->pluck('total', 'platform');

        $totalMentions = BrandMention::count();

        // Ambil 10 data terbaru per platform
        $facebookMentions = BrandMention::where('platform', 'facebook')->latest()->take(10)->get();
        $twitterMentions = BrandMention::where('platform', 'twitter')->latest()->take(10)->get();
        $githubMentions = BrandMention::where('platform', 'github')->latest()->take(10)->get();
        $instagramMentions = BrandMention::where('platform', 'instagram')->latest()->take(10)->get();
        $linkedinMentions = BrandMention::where('platform', 'linkedin')->latest()->take(10)->get();
        $youtubeMentions = BrandMention::where('platform', 'youtube')->latest()->take(10)->get();

        // Ambil top 5 leaked data (umum, bisa dari platform manapun)
        $topLeaked = BrandMention::latest()->take(5)->get();

        return view('brand-monitoring', compact(
            'platformCounts',
            'totalMentions',
            'facebookMentions',
            'twitterMentions',
            'githubMentions',
            'instagramMentions',
            'linkedinMentions',
            'topLeaked',
            'youtubeMentions'
        ));
    }

}

