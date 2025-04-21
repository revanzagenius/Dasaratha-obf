@extends('layouts.app')

@section('title', 'IP Vulnerability Scanner')

@section('content')
<div class="space-y-6">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="rounded-lg bg-green-50 p-4 border-l-4 border-green-400">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg bg-red-50 p-4 border-l-4 border-red-400">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Add Domain Button -->
    @if(auth()->user()->role_id == 1)
        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" data-modal-target="addDomainModal" data-modal-toggle="addDomainModal">
            <svg class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            Tambah Domain
        </button>
    @endif

    <!-- Add Domain Modal -->
    <div id="addDomainModal" tabindex="-1" aria-hidden="true" class="mt-5 fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-md mx-auto">
            <div class="relative bg-white rounded-xl shadow-lg">
                <div class="flex items-center justify-between p-5 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">Tambah Domain</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg p-1.5 inline-flex items-center" data-modal-hide="addDomainModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"></path></svg>
                    </button>
                </div>
                <div class="p-6">
                    <form action="{{ route('domains.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="domain" class="block text-sm font-medium text-gray-700">URL Domain</label>
                                <input type="url" name="domain" id="domain" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="https://example.com" required>
                            </div>
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                Tambah Domain
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Domain List -->
<div class="space-y-6">
    <!-- Domain Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Domain Information</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach (['Domain Name', 'Expiry Date', 'Registrar', 'Created Date', 'Updated Date', 'Name Servers', 'Status', 'Countdown', 'Action'] as $header)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($domains as $domain)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $domain->domain_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $domain->expiry_date }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $domain->registrar_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $domain->created_date }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $domain->updated_date }}</td>
                            <td class="px-6 py-4 text-sm">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach (json_decode($domain->name_servers, true) as $nameServer)
                                        <li class="text-gray-700">{{ $nameServer }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full
                                    {{ $domain->domain_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($domain->domain_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm countdown text-gray-700" data-expiry="{{ $domain->expiry_date }}"></td>
                            <td class="px-6 py-4 text-sm space-x-2 flex">
                                <a href="{{ route('domains.downloadPdf') }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-md hover:bg-indigo-700 transition">
                                    <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    PDF
                                </a>
                                <form action="{{ route('domains.destroy', $domain->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700 transition"
                                        onclick="return confirm('Are you sure you want to delete this domain?');">
                                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Subdomain Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Subdomain Information</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach (['No', 'Subdomain', 'Type', 'Value', 'Ports', 'Last Seen'] as $header)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($records as $index => $record)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $record['subdomain'] ?: '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $record['type'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $record['value'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ isset($record['ports']) && is_array($record['ports']) ? implode(', ', $record['ports']) : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $record['last_seen'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Countdown Script -->
<script>
    const countdownElements = document.querySelectorAll('.countdown');

    countdownElements.forEach(element => {
        const expiryDate = new Date(element.dataset.expiry);

        function updateCountdown() {
            const now = new Date();
            const timeLeft = expiryDate - now;

            if (timeLeft > 0) {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const textColor = days <= 30 ? 'text-red-600' : days <= 90 ? 'text-yellow-600' : 'text-green-600';
                element.innerHTML = `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${textColor} bg-opacity-10 ${textColor.replace('text', 'bg')}">${days} hari lagi</span>`;
            } else {
                element.innerHTML = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired</span>';
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
</script>
@endsection
