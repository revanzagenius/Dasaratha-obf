@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Form Pencarian -->
    <form action="{{ route('otx.index') }}" method="GET" class="mb-6 flex">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search Pulses..."
            class="w-full p-3 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit"
            class="bg-blue-600 text-white px-6 rounded-r-md hover:bg-blue-700 transition">
            Search
        </button>
    </form>

    <!-- Tampilkan Pulses yang Sudah di-Subscribe -->
    @if(!$searchResults)
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Recomendation Pulses</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($pulses['results'] ?? [] as $pulse)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-300 transition-transform transform hover:scale-105 flex flex-col h-full">
                    <div class="p-6 flex-grow">
                        <h3 class="text-xl font-bold text-gray-900">{{ $pulse['name'] }}</h3>
                        <p class="text-md text-gray-700 mt-3">
                            {{ \Illuminate\Support\Str::limit($pulse['description'] ?? 'No description available', 120, '...') }}
                        </p>
                        <p class="text-sm text-gray-500 mt-4">By: <span class="font-semibold">{{ $pulse['author_name'] ?? 'Unknown' }}</span></p>
                    </div>
                     <!-- Button View Details -->
                    <div class="p-6 pt-0 flex gap-4">
                        <a href="{{ route('otx.download', $pulse['id']) }}"
                        class="block text-center bg-green-600 text-white font-bold py-3 px-4 rounded-md hover:bg-green-700 transition">
                            Download PDF
                        </a>

                        <a href="{{ route('otx.show', $pulse['id']) }}"
                        class="block text-center bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Hasil Pencarian -->
    @if ($searchResults)
        <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Search Results for "{{ request('q') }}"</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($searchResults['results'] ?? [] as $pulse)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-300 transition-transform transform hover:scale-105 flex flex-col h-full">
                    <div class="p-6 flex-grow">
                        <h3 class="text-xl font-bold text-gray-900">{{ $pulse['name'] }}</h3>
                        <p class="text-md text-gray-700 mt-3">
                            {{ \Illuminate\Support\Str::limit($pulse['description'] ?? 'No description available', 120, '...') }}
                        </p>
                        <p class="text-sm text-gray-500 mt-4">By: <span class="font-semibold">{{ $pulse['author_name'] ?? 'Unknown' }}</span></p>
                    </div>
                     <!-- Button View Details -->
                    <div class="p-6 pt-0 flex gap-4">
                        <a href="{{ route('otx.download', $pulse['id']) }}"
                        class="block text-center bg-green-600 text-white font-bold py-3 px-4 rounded-md hover:bg-green-700 transition">
                            Download PDF
                        </a>

                        <a href="{{ route('otx.show', $pulse['id']) }}"
                        class="block text-center bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
