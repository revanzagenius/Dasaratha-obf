@extends('layouts.app')

@section('title', 'IP Vulnerability Scanner')

@section('content')
<div class="bg-gray-100 p-6 font-sans min-h-screen">

  <!-- Trick to keep Tailwind from purging bg classes -->
  <div class="hidden">
    bg-blue-800 bg-gradient-to-r from-pink-500 to-purple-500 bg-red-600 bg-gray-800 bg-blue-700 bg-black bg-sky-400 bg-orange-400 bg-gray-900 bg-cyan-600 bg-indigo-500 bg-orange-500
  </div>

  <!-- Platform Specific Mentions -->
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
    @foreach (['facebook', 'instagram', 'youtube', 'twitter', 'linkedin', 'tiktok', 'reddit', 'github', 'x', 'vimeo'] as $platform)
      @php
        $bgColors = [
          'facebook' => 'bg-blue-800',
          'instagram' => 'bg-gradient-to-r from-pink-500 to-purple-500',
          'youtube' => 'bg-red-600',
          'twitter' => 'bg-gray-800',
          'linkedin' => 'bg-blue-700',
          'tiktok' => 'bg-black',
          'github' => 'bg-gray-900',
          'vimeo' => 'bg-indigo-500',
          'reddit' => 'bg-red-400',
          'x' => 'bg-blue-500',
        ];

        $icons = [
          'facebook' => 'fab fa-facebook',
          'instagram' => 'fab fa-instagram',
          'youtube' => 'fab fa-youtube',
          'twitter' => 'fab fa-twitter',
          'linkedin' => 'fab fa-linkedin',
          'tiktok' => 'fab fa-tiktok',
          'github' => 'fab fa-github',
          'vimeo' => 'fab fa-vimeo',
          'reddit' => 'fab fa-reddit',
          'x' => 'fab fa-x',
        ];
      @endphp

      <div class="flex items-center justify-between p-4 text-white rounded-xl {{ $bgColors[$platform] ?? 'bg-gray-600' }}">
        <div class="flex items-center gap-2">
          <i class="{{ $icons[$platform] ?? 'fas fa-hashtag' }} text-lg"></i>
          <span class="capitalize font-semibold">{{ $platform }}</span>
        </div>
        <span class="text-sm font-bold">{{ $platformCounts[$platform] ?? 0 }}</span>
      </div>
    @endforeach
  </div>

  <!-- Facebook & Twitter Mentions (Side by Side) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    <!-- Facebook Mentions -->
    <div class="bg-white rounded-xl p-6 shadow">
      <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fab fa-facebook text-blue-600 text-2xl"></i> Facebook Mentions (10 Terbaru)
      </h2>

      @if($facebookMentions->count())
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
              <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700 uppercase">
                <th class="px-4 py-3 border-b">#</th>
                <th class="px-4 py-3 border-b">URL</th>
                <th class="px-4 py-3 border-b">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($facebookMentions as $index => $mention)
                <tr class="{{ $loop->odd ? 'bg-gray-50' : 'bg-white' }} text-sm text-gray-700">
                  <td class="px-4 py-3 border-b">{{ $index + 1 }}</td>
                  <td class="px-4 py-3 border-b">
                    <a href="{{ $mention->url }}" target="_blank" class="text-blue-600 hover:underline break-words">{{ $mention->url }}</a>
                  </td>
                  <td class="px-4 py-3 border-b">{{ \Carbon\Carbon::parse($mention->created_at)->format('d M Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-gray-500 text-sm">Belum ada data mention Facebook terbaru.</p>
      @endif
    </div>

    <!-- Twitter Mentions -->
    <div class="bg-white rounded-xl p-6 shadow">
      <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fab fa-twitter text-blue-500 text-2xl"></i> Twitter Mentions (10 Terbaru)
      </h2>

      @if($twitterMentions->count())
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
              <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700 uppercase">
                <th class="px-4 py-3 border-b">#</th>
                <th class="px-4 py-3 border-b">URL</th>
                <th class="px-4 py-3 border-b">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($twitterMentions as $index => $mention)
                <tr class="{{ $loop->odd ? 'bg-gray-50' : 'bg-white' }} text-sm text-gray-700">
                  <td class="px-4 py-3 border-b">{{ $index + 1 }}</td>
                  <td class="px-4 py-3 border-b">
                    <a href="{{ $mention->url }}" target="_blank" class="text-blue-600 hover:underline break-words">{{ $mention->url }}</a>
                  </td>
                  <td class="px-4 py-3 border-b">{{ \Carbon\Carbon::parse($mention->created_at)->format('d M Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-gray-500 text-sm">Belum ada data mention Twitter terbaru.</p>
      @endif
    </div>

  </div>

  <!-- GitHub & Instagram Mentions (Side by Side) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    <!-- GitHub Mentions -->
    <div class="bg-white rounded-xl p-6 shadow">
      <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fab fa-github text-gray-800 text-2xl"></i> GitHub Mentions (10 Terbaru)
      </h2>

      @if($githubMentions->count())
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
              <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700 uppercase">
                <th class="px-4 py-3 border-b">#</th>
                <th class="px-4 py-3 border-b">URL</th>
                <th class="px-4 py-3 border-b">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($githubMentions as $index => $mention)
                <tr class="{{ $loop->odd ? 'bg-gray-50' : 'bg-white' }} text-sm text-gray-700">
                  <td class="px-4 py-3 border-b">{{ $index + 1 }}</td>
                  <td class="px-4 py-3 border-b">
                    <a href="{{ $mention->url }}" target="_blank" class="text-blue-600 hover:underline break-words">{{ $mention->url }}</a>
                  </td>
                  <td class="px-4 py-3 border-b">{{ \Carbon\Carbon::parse($mention->created_at)->format('d M Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-gray-500 text-sm">Belum ada data mention GitHub terbaru.</p>
      @endif
    </div>

    <!-- Instagram Mentions -->
    <div class="bg-white rounded-xl p-6 shadow">
      <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fab fa-instagram text-pink-500 text-2xl"></i> Instagram Mentions (10 Terbaru)
      </h2>

      @if($instagramMentions->count())
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
              <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700 uppercase">
                <th class="px-4 py-3 border-b">#</th>
                <th class="px-4 py-3 border-b">URL</th>
                <th class="px-4 py-3 border-b">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($instagramMentions as $index => $mention)
                <tr class="{{ $loop->odd ? 'bg-gray-50' : 'bg-white' }} text-sm text-gray-700">
                  <td class="px-4 py-3 border-b">{{ $index + 1 }}</td>
                  <td class="px-4 py-3 border-b">
                    <a href="{{ $mention->url }}" target="_blank" class="text-blue-600 hover:underline break-words">{{ $mention->url }}</a>
                  </td>
                  <td class="px-4 py-3 border-b">{{ \Carbon\Carbon::parse($mention->created_at)->format('d M Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-gray-500 text-sm">Belum ada data mention Instagram terbaru.</p>
      @endif
    </div>

  </div>


<!-- LinkedIn & YouTube Mentions (Side by Side) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    <!-- LinkedIn Mentions -->
    <div class="bg-white rounded-xl p-6 shadow">
      <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fab fa-linkedin text-blue-700 text-2xl"></i> LinkedIn Mentions (10 Terbaru)
      </h2>

      @if($linkedinMentions->count())
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
              <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700 uppercase">
                <th class="px-4 py-3 border-b">#</th>
                <th class="px-4 py-3 border-b">URL</th>
                <th class="px-4 py-3 border-b">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($linkedinMentions as $index => $mention)
                <tr class="{{ $loop->odd ? 'bg-gray-50' : 'bg-white' }} text-sm text-gray-700">
                  <td class="px-4 py-3 border-b">{{ $index + 1 }}</td>
                  <td class="px-4 py-3 border-b">
                    <a href="{{ $mention->url }}" target="_blank" class="text-blue-600 hover:underline break-words">{{ $mention->url }}</a>
                  </td>
                  <td class="px-4 py-3 border-b">{{ \Carbon\Carbon::parse($mention->created_at)->format('d M Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-gray-500 text-sm">Belum ada data mention LinkedIn terbaru.</p>
      @endif
    </div>

    <!-- YouTube Mentions -->
    <div class="bg-white rounded-xl p-6 shadow">
      <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fab fa-youtube text-red-600 text-2xl"></i> YouTube Mentions (10 Terbaru)
      </h2>

      @if($youtubeMentions->count())
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
              <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700 uppercase">
                <th class="px-4 py-3 border-b">#</th>
                <th class="px-4 py-3 border-b">URL</th>
                <th class="px-4 py-3 border-b">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($youtubeMentions as $index => $mention)
                <tr class="{{ $loop->odd ? 'bg-gray-50' : 'bg-white' }} text-sm text-gray-700">
                  <td class="px-4 py-3 border-b">{{ $index + 1 }}</td>
                  <td class="px-4 py-3 border-b">
                    <a href="{{ $mention->url }}" target="_blank" class="text-blue-600 hover:underline break-words">{{ $mention->url }}</a>
                  </td>
                  <td class="px-4 py-3 border-b">{{ \Carbon\Carbon::parse($mention->created_at)->format('d M Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-gray-500 text-sm">Belum ada data mention YouTube terbaru.</p>
      @endif
    </div>

  </div>





  <!-- Executive Physical Threats & Take Downs -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Executive Physical Threats -->
    <div class="bg-white rounded-xl p-4 shadow h-48 flex flex-col items-center justify-center text-gray-400">
      <i class="fas fa-search text-4xl mb-2"></i>
      <p>No Data Available</p>
    </div>

    <!-- Take Downs -->
    <div class="bg-white rounded-xl p-4 shadow">
      <h2 class="text-lg font-semibold mb-4">Take Downs</h2>
      <p class="text-4xl font-bold mb-2">0</p>
      <p class="text-sm text-gray-500">Ongoing</p>
      <div class="mt-4 text-sm text-gray-500">
        <p>0 Closed</p>
        <p>0 Dismissed</p>
      </div>
    </div>
  </div>
</body>
@endsection
