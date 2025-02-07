<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RSSFeedController extends Controller
{
    public function mostrecent()
    {
        $feedUrl = 'https://www.projecthoneypot.org/list_of_ips.php?t=h&rss=1';

        // Ambil data dari RSS feed
        $response = Http::get($feedUrl);

        if ($response->ok()) {
            $xml = simplexml_load_string($response->body());

            // Parsing data RSS menjadi array
            $items = [];
            foreach ($xml->channel->item as $item) {
                $items[] = [
                    'ip' => trim(explode('|', (string) $item->title)[0]),
                    'riskLevel' => trim(explode('|', (string) $item->title)[1] ?? ''),
                    'description' => (string) $item->description,
                    'url' => (string) $item->link,
                    'pubDate' => (string) $item->pubDate,
                ];
            }

            // Membagi data menjadi `latestEntries` dan `otherEntries`
            $latestEntries = array_slice($items, 0, 10);
            $otherEntries = array_slice($items, 10);

            // Kirim data ke view
            return view('rss.mostrecent', compact('latestEntries', 'otherEntries'));
        }

        return back()->withErrors('Gagal mengambil data dari Project Honey Pot.');
    }

    public function indonesia()
    {
        $feedUrl = 'https://www.projecthoneypot.org/list_of_ips.php?t=h&ctry=id&rss=1';

        // Ambil data dari RSS feed
        $response = Http::get($feedUrl);

        if ($response->ok()) {
            $xml = simplexml_load_string($response->body());

            // Parsing data RSS menjadi array
            $items = [];
            foreach ($xml->channel->item as $item) {
                $items[] = [
                    'ip' => trim(explode('|', (string) $item->title)[0]),
                    'riskLevel' => trim(explode('|', (string) $item->title)[1] ?? ''),
                    'description' => (string) $item->description,
                    'url' => (string) $item->link,
                    'pubDate' => (string) $item->pubDate,
                ];
            }

            // Membagi data menjadi `latestEntries` dan `otherEntries`
            $latestEntries = array_slice($items, 0, 10);
            $otherEntries = array_slice($items, 10);

            // Kirim data ke view
            return view('rss.indonesia', compact('latestEntries', 'otherEntries'));
        }

        return back()->withErrors('Gagal mengambil data dari Project Honey Pot.');
    }
}
