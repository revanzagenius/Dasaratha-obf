@extends('layouts.app')

@section('content')
<body class="bg-gray-100 p-5">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Vulnerabilities</h1>
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-500">
                    <span>Total</span>
                    <span class="font-bold text-indigo-600">{{ number_format($total) }} CVE</span>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="flex justify-end mb-4">
            <form method="GET" action="{{ route('opencve.index') }}" class="flex items-center bg-white shadow-sm rounded-md overflow-hidden">
               <!-- Dropdown Filter -->
                <div class="relative">
                    <select
                        name="filter_type"
                        class="appearance-none border-none bg-gray-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                        <option value="cve" {{ request('filter_type') == 'cve' ? 'selected' : '' }}>Search by CVE ID</option>
                        <option value="vendors" {{ request('filter_type') == 'vendors' ? 'selected' : '' }}>Search by Vendors</option>
                        <option value="products" {{ request('filter_type') == 'products' ? 'selected' : '' }}>Search by Products</option>
                    </select>
                    <span class="absolute right-3 top-2 text-gray-400 pointer-events-none">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </div>


                <!-- Input Query -->
                <input
                    type="text"
                    name="query"
                    value="{{ request('query') }}"
                    placeholder="Enter CVE ID or Product..."
                    class="px-4 py-2 w-64 border-none text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="flex items-center bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                    <i class="fas fa-search mr-2"></i> Search
                </button>
            </form>
        </div>

        <!-- Error Notification -->
        @if (isset($error))
            <div class="mb-4 text-red-600">{{ $error }}</div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">CVE</th>
                        <th class="py-3 px-6 text-left">Description</th>
                        <th class="py-3 px-6 text-left">Updated</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($results as $result)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            @if (isset($result['cve_id']))
                                <td class="py-3 px-6">
                                    <a href="{{ route('cve.show', ['id' => $result['cve_id']]) }}" class="text-indigo-600 font-medium">
                                        {{ $result['cve_id'] }}
                                    </a>
                                </td>
                                <td class="py-3 px-6">{{ $result['description'] }}</td>
                            @elseif (isset($result['name']))
                                <td class="py-3 px-6" colspan="2">{{ $result['name'] }}</td>
                            @endif
                            <td class="py-3 px-6">
                                {{ isset($result['updated_at']) ? \Carbon\Carbon::parse($result['updated_at'])->format('Y-m-d') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-3">No data available.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-center">
            @php
                $lastPage = ceil($total / 10);
                $startPage = max(1, $currentPage - 2);
                $endPage = min($lastPage, $currentPage + 2);
            @endphp
            <nav class="inline-flex shadow-sm" aria-label="Pagination">
                @if ($currentPage > 1)
                    <a href="{{ url()->current() }}?page={{ $currentPage - 1 }}" class="py-2 px-3 bg-white border border-gray-300 rounded-l hover:bg-gray-100">&laquo; Previous</a>
                @else
                    <span class="py-2 px-3 bg-gray-200 text-gray-400 rounded-l cursor-not-allowed">&laquo; Previous</span>
                @endif

                @for ($i = $startPage; $i <= $endPage; $i++)
                    @if ($i == $currentPage)
                        <span class="py-2 px-3 bg-indigo-600 text-white">{{ $i }}</span>
                    @else
                        <a href="{{ url()->current() }}?page={{ $i }}" class="py-2 px-3 bg-white border border-gray-300 hover:bg-gray-100">{{ $i }}</a>
                    @endif
                @endfor

                @if ($currentPage < $lastPage)
                    <a href="{{ url()->current() }}?page={{ $currentPage + 1 }}" class="py-2 px-3 bg-white border border-gray-300 rounded-r hover:bg-gray-100">Next &raquo;</a>
                @else
                    <span class="py-2 px-3 bg-gray-200 text-gray-400 rounded-r cursor-not-allowed">Next &raquo;</span>
                @endif
            </nav>
        </div>
    </div>
</body>
@endsection
