@extends('layouts.app')

@section('content')
<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class'
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-200 dark:bg-gray-900 min-h-screen flex items-center justify-center p-6 font-sans text-gray-800 dark:text-gray-100">

  <!-- Main Card Container -->
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-7xl p-6 space-y-6 transition-colors duration-300 mx-auto">


    <!-- Header User Info + Dark Mode Toggle -->
<div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
      <div class="flex items-center border dark:border-gray-700 rounded-lg px-6 py-3 shadow-sm bg-white dark:bg-gray-700">
        <img src="https://media.licdn.com/dms/image/v2/C5103AQG7mMhG55Mnrg/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1516878616364?e=1750291200&v=beta&t=X8vLWDZ2tJPtF9bhT-HQdbDlB3E2_ykofTCYuwxfaQg"
             alt="Profile" class="w-16 h-16 rounded-full mr-4">
        <div class="flex flex-col">
          <span class="text-xl font-semibold">Zulfikar</span>
          <!-- Optional: Uncomment below if you want "Switch User" -->
          <!-- <span class="text-sm text-gray-500 dark:text-gray-300">Switch User</span> -->
        </div>
        <i class="fas fa-chevron-down ml-4 text-lg text-gray-500"></i>
      </div>
      <a href="{{ route('vip.detail') }}"
        class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-5 py-3 rounded-lg shadow text-lg">
            View Details
     </a>
    </div>

    <!-- Dark Mode Toggle -->
    <button id="toggleDark" class="text-2xl text-gray-600 dark:text-yellow-300 hover:text-black dark:hover:text-white transition">
      <i class="fas fa-moon dark:hidden"></i>
      <i class="fas fa-sun hidden dark:inline"></i>
    </button>
  </div>


    <!-- Count Of Alerts & Leaked Data -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 shadow-sm hover:shadow-md transition">
        <!-- Ganti bagian "Count Of Alerts" -->
        <h2 class="text-lg font-semibold mb-4">Count Of Alerts</h2>
        <div class="h-40 flex items-center justify-center text-4xl text-blue-700 dark:text-blue-300 font-bold">
        {{ $countAlerts }}
        </div>
      </div>

      <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 shadow-sm hover:shadow-md transition">
        <h2 class="text-lg font-semibold mb-4">Leaked Data (Top 5)</h2>

        @if ($topLeakedData->count() > 0)
          <ul class="space-y-2 text-sm text-gray-800 dark:text-gray-100">
            @foreach ($topLeakedData as $data)
              <li class="flex justify-between border-b border-gray-300 dark:border-gray-600 pb-1">
                <span class="font-medium">{{ $data->platform }}</span>
                <span class="text-xs">{{ \Carbon\Carbon::parse($data->leaked_at)->diffForHumans() }}</span>
              </li>
              <li class="text-xs text-gray-500 dark:text-gray-400 italic">{{ $data->created_at }}</li>
            @endforeach
          </ul>
        @else
          <div class="h-40 flex flex-col items-center justify-center text-gray-400 dark:text-gray-300">
            <i class="fas fa-search text-4xl mb-2"></i>
            <p>No Leaked Data Found</p>
          </div>
        @endif
      </div>
    </div>

    <!-- Platform Specific Mentions -->
<div class="grid grid-cols-2 md:grid-cols-6 gap-4">
    <div class="flex items-center justify-between bg-blue-800 text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-facebook"></i>
      <span>{{ $platformCounts['facebook'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-instagram"></i>
      <span>{{ $platformCounts['instagram'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-red-600 text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-youtube"></i>
      <span>{{ $platformCounts['youtube'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-gray-800 text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-twitter"></i>
      <span>{{ $platformCounts['twitter'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-blue-700 text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-linkedin"></i>
      <span>{{ $platformCounts['linkedin'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-black text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-tiktok"></i>
      <span>{{ $platformCounts['tiktok'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-sky-400 text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-telegram"></i>
      <span>{{ $platformCounts['telegram'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-orange-400 text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-reddit"></i>
      <span>{{ $platformCounts['reddit'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-red-500 text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-pinterest"></i>
      <span>{{ $platformCounts['pinterest'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-gray-700 text-white rounded-xl p-4 shadow-sm">
      <i class="fas fa-comment-dots"></i>
      <span>{{ $platformCounts['forums'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-cyan-600 text-white rounded-xl p-4 shadow-sm">
      <i class="fab fa-vimeo-v"></i>
      <span>{{ $platformCounts['vimeo'] ?? 0 }}</span>
    </div>

    <div class="flex items-center justify-between bg-orange-500 text-white rounded-xl p-4 shadow-sm">
      <i class="fas fa-rss"></i>
      <span>{{ $platformCounts['rss'] ?? 0 }}</span>
    </div>
  </div>


    <!-- Executive Physical Threats & Take Downs -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 shadow-sm h-48 flex flex-col items-center justify-center text-gray-400 dark:text-gray-300 hover:shadow-md transition">
        <i class="fas fa-search text-4xl mb-2"></i>
        <p>No Data Available</p>
      </div>
    </div>
  </div>

  <!-- Toggle Script -->
  <script>
    const toggle = document.getElementById('toggleDark');
    toggle.addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');
    });
  </script>
</body>
@endsection
