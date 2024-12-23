@extends('layouts.app')

@section('content')
    <!-- Menampilkan pesan sukses atau error -->
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(auth()->user()->role_id == 1)
        <!-- Button untuk menampilkan form -->
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4" id="toggleFormButton">+</button>
    @endif
    <!-- Form disembunyikan secara default -->
    <div id="scanForm" class="hidden mb-5">
        <form action="{{ route('scan') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="ip" class="block text-sm font-medium">Enter IP to Scan:</label>
                <input type="text" name="ip" id="ip"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500"
                    placeholder="Enter IP address" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium">Enter Your Email for Notifications:</label>
                <input type="email" name="email" id="email"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500"
                    placeholder="Enter your email" required>
            </div>
            <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Save</button>
        </form>
    </div>

    <!-- Menampilkan hasil IP yang telah dipindai -->
    @if ($hosts->isEmpty())
        <p class="text-gray-400">No data available. Please scan an IP.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($hosts as $host)
                <div
                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                            Details</h5>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <tbody>
                                <tr>
                                    <th class="px-6 py-3 font-medium text-gray-900 dark:text-white">IP</th>
                                    <td class="px-6 py-3">{{ $host->ip }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-3 font-medium text-gray-900 dark:text-white">Country</th>
                                    <td class="px-6 py-3">{{ $host->country }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-3 font-medium text-gray-900 dark:text-white">City</th>
                                    <td class="px-6 py-3">{{ $host->city }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-3 font-medium text-gray-900 dark:text-white">Open Ports</th>
                                    <td class="px-6 py-3">
                                        @php
                                            $ports = json_decode($host->ports);
                                            echo is_array($ports) ? implode(', ', $ports) : 'N/A';
                                        @endphp
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4 space-y-2">
                            <a href="{{ route('result', ['id' => $host->id]) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">
                                Show Details
                            </a>
                            <a href="{{ route('dashboard.exportPdf', $host->id) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 w-full">
                                Export to PDF
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Script untuk toggle form -->
    <script>
        document.getElementById('toggleFormButton').addEventListener('click', function() {
            const form = document.getElementById('scanForm');
            form.classList.toggle('hidden');
        });
    </script>
@endsection
