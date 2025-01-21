@extends('layouts.app')

@section('content')
<body class="bg-gray-900 text-white">

    <!-- Main Content -->
    <div class="container mx-auto mt-10">
        <div class="flex items-center justify-between">
            <h1 class="text-4xl font-bold">Data Breach Monitoring</h1>
            <!-- Button to trigger modal -->
            {{-- <button id="openModal"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                +
            </button> --}}
        </div>

        <!-- Search Results Section -->
        @isset($data)
        {{-- <div class="mt-10 px-4">
            <div class="text-center py-6 bg-gray-800 text-white">
                <h1 class="text-3xl font-bold">Data Breach Monitoring</h1>
            </div> --}}

            <div class="p-4 bg-gray-700 text-white rounded-lg">
                <p class="text-2xl font-bold">{{ $data['total_results'] ?? 0 }}</p>
                <p class="text-sm">Data Breach on domain OBF.id</p>
            </div>

            {{-- <!-- Summary Section -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center mt-8">
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
            </div> --}}


            <!-- VIP Table -->
            <div class="mt-8">
                <h5><b>VIP Monitor Email List</b></h5>
                <table class="w-full text-left text-sm bg-white text-black border border-gray-300 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-800 border-b border-gray-300">
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Data Point</th>
                            <th class="px-4 py-2">Created</th>
                            <th class="px-4 py-2">Last Modified</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-t border-gray-300">
                                <span class="text-yellow-500 border border-yellow-500 px-2 py-1 rounded">EMAIL</span>
                            </td>
                            <td class="px-4 py-2 border-t border-gray-300">KUNIAKI.TACHIKI@OBF.ID</td>
                            <td class="px-4 py-2 border-t border-gray-300">24 DEC 2024</td>
                            <td class="px-4 py-2 border-t border-gray-300">24 DEC 2024</td>
                            <td class="px-4 py-2 border-t border-gray-300">
                                <span class="text-green-500 border border-green-500 px-2 py-1 rounded">RUNNING</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-t border-gray-300">
                                <span class="text-yellow-500 border border-yellow-500 px-2 py-1 rounded">EMAIL</span>
                            </td>
                            <td class="px-4 py-2 border-t border-gray-300">CHRISTIAN.TOK@OBF.ID</td>
                            <td class="px-4 py-2 border-t border-gray-300">24 DEC 2024</td>
                            <td class="px-4 py-2 border-t border-gray-300">24 DEC 2024</td>
                            <td class="px-4 py-2 border-t border-gray-300">
                                <span class="text-green-500 border border-green-500 px-2 py-1 rounded">RUNNING</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Results Table -->
            <div class="mt-8">
                <table class="w-full text-left text-sm bg-white text-black border border-gray-300 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-800 border-b border-gray-300">
                            <th class="px-4 py-2">Username</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Password</th>
                            <th class="px-4 py-2">Hash</th>
                            <th class="px-4 py-2">Last Scan</th> <!-- Added Updated At Column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allData as $entry) <!-- Display all data -->
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border-t border-gray-300">{{ $entry->username ?? '-' }}</td>
                                <td class="px-4 py-2 border-t border-gray-300">{{ $entry->email ?? '-' }}</td>
                                <td class="px-4 py-2 border-t border-gray-300">{{ $entry->password ?? '-' }}</td>
                                <td class="px-4 py-2 border-t border-gray-300">{{ $entry->hash ?? '-' }}</td>
                                <td class="px-4 py-2 border-t border-gray-300">{{ $entry->last_scanned_at ?? 'N/A' }}</td> <!-- Display updated_at -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <!-- Message for No Data -->
        <div class="text-center mt-10">
            <p class="text-gray-500">No recent search results. Use the "+" button to perform a new search.</p>
        </div>
        @endisset
    </div>

    <!-- Modal -->
    <div id="formModal"
        class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <button id="closeModal" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">X</button>
            <!-- Form untuk pencarian -->
            <form action="{{ route('databreach.search') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label for="domain" class="block text-sm font-medium text-gray-700 mb-2">Search Domain:</label>
                    <input type="text" id="domain" name="domain"
                        class="block w-full px-4 py-2 text-gray-900 bg-gray-200 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter domain, e.g., bri.co.id" required>
                </div>

                <!-- Dropdown untuk memilih scanned time -->
                <div>
                    <label for="scanned_time" class="block text-sm font-medium text-gray-700 mb-2">Scanned Time:</label>
                    <select id="scanned_time" name="scanned_time"
                        class="block w-full px-4 py-2 text-gray-900 bg-gray-200 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">1 Day</option>
                        <option value="2">2 Days</option>
                        <option value="3">3 Days</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-300">
                    Search
                </button>
            </form>
        </div>
    </div>

    {{-- <!-- Script -->
    <script>
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');
        const formModal = document.getElementById('formModal');

        openModal.addEventListener('click', () => {
            formModal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            formModal.classList.add('hidden');
        });
    </script> --}}
</body>
@endsection
