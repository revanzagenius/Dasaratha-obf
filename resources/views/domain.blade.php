@extends('layouts.app')

@section('title', 'IP Vulnerability Scanner')

@section('content')
    <!-- Menampilkan pesan sukses atau error -->
    @if(session('success'))
        <p class="bg-green-100 text-green-800 p-4 rounded mb-4">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="bg-red-100 text-red-800 p-4 rounded mb-4">{{ session('error') }}</p>
    @endif

    <!-- Tombol untuk tambah domain -->
    @if(auth()->user()->role_id == 1)
    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4" data-modal-target="addDomainModal" data-modal-toggle="addDomainModal">
        + Tambah Domain
    </button>
    @endif

    <!-- Modal untuk tambah domain -->
    <div id="addDomainModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Tambah Domain</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addDomainModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <form action="{{ route('domains.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="domain" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Masukkan URL Domain</label>
                            <input type="url" name="domain" id="domain" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500" placeholder="Masukkan URL domain" required>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Tambah Domain</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Domain List (Tabel yang menampilkan daftar domain) -->
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Domain Name</th>
                    <th scope="col" class="px-6 py-3">Expiry Date</th>
                    <th scope="col" class="px-6 py-3">Registrar</th>
                    <th scope="col" class="px-6 py-3">Created Date</th>
                    <th scope="col" class="px-6 py-3">Updated Date</th>
                    <th scope="col" class="px-6 py-3">Name Servers</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Countdown</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($domains as $domain)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $domain->domain_name }}</td>
                        <td class="px-6 py-4">{{ $domain->expiry_date }}</td>
                        <td class="px-6 py-4">{{ $domain->registrar_name }}</td>
                        <td class="px-6 py-4">{{ $domain->created_date }}</td>
                        <td class="px-6 py-4">{{ $domain->updated_date }}</td>
                        <td class="px-6 py-4">
                            <ul class="list-disc pl-5">
                                @foreach (json_decode($domain->name_servers, true) as $nameServer)
                                    <li>{{ $nameServer }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4">{{ $domain->domain_status }}</td>
                        <td class="px-6 py-4 countdown" data-expiry="{{ $domain->expiry_date }}"></td>
                        <td class="px-6 py-4">
                            <a href="{{ route('domains.downloadPdf') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Unduh PDF</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                    element.textContent = `${days} hari lagi`;
                } else {
                    element.textContent = "Expired";
                }
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
@endsection
