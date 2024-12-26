@extends('layouts.app')

@section('content')
<body class="bg-white text-black">

    <!-- Header -->
    <div class="text-center py-6 bg-gray-800 text-white">
        <h1 class="text-3xl font-bold">Dehashed API Results</h1>
    </div>

    <!-- Summary Section -->
    <div class="container mx-auto mt-8 px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="p-4 bg-gray-700 text-white rounded-lg">
                <p class="text-2xl font-bold">{{ $data['total_results'] ?? 0 }}</p>
                <p class="text-sm">Results Found</p>
            </div>
            <div class="p-4 bg-gray-700 text-white rounded-lg">
                <p class="text-2xl font-bold">{{ $data['elapsed_time'] ?? '0 ms' }}</p>
                <p class="text-sm">Search Elapsed Time</p>
            </div>
            <div class="p-4 bg-gray-700 text-white rounded-lg">
                <p class="text-2xl font-bold">{{ $data['assets_searched'] ?? 'N/A' }}</p>
                <p class="text-sm">Assets Searched</p>
            </div>
            <div class="p-4 bg-gray-700 text-white rounded-lg">
                <p class="text-2xl font-bold">{{ $data['aggregated_data_wells'] ?? 'N/A' }}</p>
                <p class="text-sm">Aggregated Data Wells</p>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="container mx-auto mt-8 px-4">
        @if(isset($data['entries']) && count($data['entries']) > 0)
            <table class="w-full text-left text-sm bg-white text-black border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-800 border-b border-gray-300">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Password</th>
                        <th class="px-4 py-2">Hash</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['entries'] as $entry)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-t border-gray-300">{{ $entry['id'] ?? '-' }}</td>
                            <td class="px-4 py-2 border-t border-gray-300">{{ $entry['username'] ?? '-' }}</td>
                            <td class="px-4 py-2 border-t border-gray-300">{{ $entry['email'] ?? '-' }}</td>
                            <td class="px-4 py-2 border-t border-gray-300">{{ $entry['password'] ?? '-' }}</td>
                            <td class="px-4 py-2 border-t border-gray-300">{{ $entry['hash'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-gray-500 mt-8">No data found for the provided query.</p>
        @endif
    </div>
</body>
</html>
@endsection
