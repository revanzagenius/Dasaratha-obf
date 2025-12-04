<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TweetFeed;

class TweetFeedController extends Controller
{
    public function index($category = null)
    {
        $query = TweetFeed::orderBy('date', 'desc'); // Urutkan dari yang terbaru

        if ($category) {
            if ($category === 'phishing') {
                $query->whereJsonContains('tags', '#phishing');
            } elseif ($category === 'cobaltstrike') {
                $query->whereJsonContains('tags', '#CobaltStrike');
            } elseif ($category === 'sha256') {
                $query->where('type', 'sha256');
            }
        }

        $storedTweets = $query->paginate(50); // Tambahkan Pagination

        return view('tweet.tweet_feed', compact('storedTweets', 'category'));
    }


}
