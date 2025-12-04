@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">VIP Impersonate Details</h1>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach ($groupedData as $platform => $items)
      <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
          @php
            $icons = [
              'facebook' => 'fab fa-facebook text-blue-600',
              'instagram' => 'fab fa-instagram text-pink-500',
              'youtube' => 'fab fa-youtube text-red-600',
              'twitter' => 'fab fa-twitter text-blue-400',
              'linkedin' => 'fab fa-linkedin text-blue-700',
              'tiktok' => 'fab fa-tiktok text-black',
              'github' => 'fab fa-github text-gray-600',
              'reddit' => 'fab fa-reddit text-orange-500',
              'x' => 'fab fa-x-twitter text-black',
            ];
          @endphp
          <i class="{{ $icons[$platform] ?? 'fas fa-globe' }} text-2xl"></i> {{ ucfirst($platform) }} Mentions ({{ $items->count() }})
        </h2>

        @if ($items->count())
          <ul class="space-y-4">
            @foreach ($items->take(10) as $item)
              <li class="bg-gray-50 dark:bg-gray-900 p-3 rounded-md shadow-sm">
                <div class="flex justify-between items-center mb-2">
                  <span class="text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</span>
                </div>
                <a href="{{ $item->url }}" target="_blank" class="text-blue-600 hover:underline break-words text-sm">
                  {{ $item->url }}
                </a>
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-gray-500 text-sm">Belum ada data mention {{ ucfirst($platform) }}.</p>
        @endif
      </div>
    @endforeach
  </div>
</div>
@endsection
