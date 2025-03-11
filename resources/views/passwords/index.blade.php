@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Password Breach Database</h1>
                        <p class="mt-1 text-sm text-gray-500">Comprehensive database of compromised passwords</p>
                    </div>

                    <!-- Enhanced Dropdown -->
                    <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-2">
                        <label for="perPage" class="text-sm font-medium text-gray-600">Display</label>
                        <select id="perPage"
                            class="bg-white border border-gray-200 text-gray-700 rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-colors duration-200"
                            onchange="changeItemsPerPage(this.value)">
                            @foreach ([5, 10, 15, 20, 25, 50, 100] as $value)
                                <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>
                                    {{ $value }} entries
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Password</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($passwords as $index => $password)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ($currentPage - 1) * $perPage + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                        {{ $password }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Enhanced Pagination -->
                <div class="bg-gray-50 border-t border-gray-100 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">
                            Showing {{ ($currentPage - 1) * $perPage + 1 }} to
                            {{ min($currentPage * $perPage, $totalPages * $perPage) }} of
                            {{ $totalPages * $perPage }} entries
                        </p>

                        <div class="flex items-center space-x-2">
                            @if ($currentPage > 3)
                                <a href="{{ route('passwords.index', ['page' => 1, 'perPage' => $perPage]) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                    First
                                </a>
                            @endif

                            @if ($currentPage > 1)
                                <a href="{{ route('passwords.index', ['page' => $currentPage - 1, 'perPage' => $perPage]) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                    Previous
                                </a>
                            @endif

                            <div class="hidden sm:flex items-center space-x-2">
                                @for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
                                    <a href="{{ route('passwords.index', ['page' => $i, 'perPage' => $perPage]) }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium {{ $currentPage == $i
                                            ? 'text-white bg-blue-600 border border-blue-600 hover:bg-blue-700'
                                            : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700' }} 
                                        rounded-lg transition-colors duration-200">
                                        {{ $i }}
                                    </a>
                                @endfor
                            </div>

                            @if ($currentPage < $totalPages)
                                <a href="{{ route('passwords.index', ['page' => $currentPage + 1, 'perPage' => $perPage]) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                    Next
                                </a>
                            @endif

                            @if ($currentPage < $totalPages - 2)
                                <a href="{{ route('passwords.index', ['page' => $totalPages, 'perPage' => $perPage]) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                    Last
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeItemsPerPage(value) {
            window.location.href = "{{ route('passwords.index') }}?page=1&perPage=" + value;
        }
    </script>
@endsection
