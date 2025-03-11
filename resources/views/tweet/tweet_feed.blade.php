@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">🚀 Twitter Threat Feed</h2>

    <!-- Dropdown Filter -->
    <div class="mb-4">
        <label class="text-gray-700">Filter by Category:</label>
        <select id="filterSelect" class="border p-2 rounded">
            <option value="{{ route('tweet.feed') }}" {{ request()->routeIs('tweet.feed') ? 'selected' : '' }}>🔥 All</option>
            <option value="{{ route('tweet.feed', 'phishing') }}" {{ request()->is('tweet-feed/phishing') ? 'selected' : '' }}>🎣 Phishing URLs</option>
            <option value="{{ route('tweet.feed', 'cobaltstrike') }}" {{ request()->is('tweet-feed/cobaltstrike') ? 'selected' : '' }}>💀 CobaltStrike IPs</option>
            <option value="{{ route('tweet.feed', 'sha256') }}" {{ request()->is('tweet-feed/sha256') ? 'selected' : '' }}>🔍 SHA256 Hashes</option>
        </select>
    </div>

    <div class="bg-white shadow-md rounded-lg p-4">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-3">#</th> <!-- Tambahkan Kolom Nomor -->
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Value</th>
                        <th class="px-4 py-3">Tags</th>
                        <th class="px-4 py-3">Tweet</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($storedTweets as $index => $tweet)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $index + 1 }}</td> <!-- Menampilkan Nomor -->
                            <td class="px-4 py-2">{{ $tweet->date }}</td>
                            <td class="px-4 py-2 font-medium text-gray-900">{{ $tweet->user }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs font-medium rounded bg-blue-100 text-blue-700">
                                    {{ ucfirst($tweet->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-blue-600">
                                <a href="{{ $tweet->value }}" target="_blank" class="hover:underline">{{ $tweet->value }}</a>
                            </td>
                            <td class="px-4 py-2">
                                @foreach ($tweet->tags as $tag)
                                    <span class="px-2 py-1 text-xs font-semibold bg-gray-200 rounded">{{ $tag }}</span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ $tweet->tweet }}" target="_blank" class="text-blue-500 hover:underline">View Tweet</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $storedTweets->links('pagination::tailwind') }}
            </div>

        </div>
    </div>
</div>

<!-- JavaScript untuk Mengubah URL saat Pilihan Dropdown Berubah -->
<script>
    document.getElementById('filterSelect').addEventListener('change', function() {
        window.location.href = this.value;
    });
</script>

@endsection
