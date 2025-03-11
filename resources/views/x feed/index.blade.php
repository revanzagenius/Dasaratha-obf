@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Brand Intelligence</h1>

    @foreach($tweets as $tweet)
    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
        <div class="flex items-start space-x-4">
            <!-- Avatar Placeholder -->
            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">
                {{ strtoupper(substr($tweet->author_username, 0, 1)) }}
            </div>
            <div class="w-full">
                <!-- Username and Handle -->
                <div class="flex justify-between">
                    <div>
                        <span class="font-semibold">{{ $tweet->author_username }}</span>
                        <span class="text-gray-500">@{{ $tweet->author_username }}</span>
                    </div>
                    <span class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($tweet->created_at)->diffForHumans() }}
                    </span>
                </div>

                <!-- Tweet Text -->
                <p class="mt-2 text-gray-700">{{ $tweet->text }}</p>

                <!-- Metrics (Likes, Retweets, Replies, etc.) -->
                <div class="flex justify-between text-gray-500 text-sm mt-3">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V10a2 2 0 012-2h2m4-4v8m0 0l-3-3m3 3l3-3">
                            </path>
                        </svg>
                        <span>{{ $tweet->retweet_count }}</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 15l7-7 7 7">
                            </path>
                        </svg>
                        <span>{{ $tweet->like_count }}</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h6m-6 4h4">
                            </path>
                        </svg>
                        <span>{{ $tweet->reply_count }}</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-5-5m-6-6H4l6 6">
                            </path>
                        </svg>
                        <span>{{ $tweet->impression_count }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-4">
        {{ $tweets->links() }}
    </div>
</div>
@endsection
