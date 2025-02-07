@extends('layouts.app')

@section('content')
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-5">
        <h1 class="text-2xl font-bold mb-5 text-gray-700">Password Breach Database</h1>

        <div class="overflow-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">No</th>
                        <th class="border border-gray-300 px-4 py-2">Password</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($passwords as $index => $password)
                        <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="border border-gray-300 px-4 py-2">{{ ($currentPage - 1) * 10 + $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $password }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-5 space-x-1">
            <!-- Tombol First -->
            @if ($currentPage > 3)
                <a href="{{ route('passwords.index', ['page' => 1]) }}" class="px-3 py-2 rounded-md bg-gray-300 text-black hover:bg-blue-500 hover:text-white">First</a>
            @endif

            <!-- Tombol sebelumnya jika halaman lebih dari 1 -->
            @if ($currentPage > 1)
                <a href="{{ route('passwords.index', ['page' => $currentPage - 1]) }}" class="px-3 py-2 rounded-md bg-gray-300 text-black hover:bg-blue-500 hover:text-white">&laquo;</a>
            @endif

            <!-- Tombol halaman -->
            @for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
                <a href="{{ route('passwords.index', ['page' => $i]) }}"
                   class="px-3 py-2 rounded-md {{ $currentPage == $i ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black hover:bg-blue-500 hover:text-white' }}">
                    {{ $i }}
                </a>
            @endfor

            <!-- Tombol Next -->
            @if ($currentPage < $totalPages)
                <a href="{{ route('passwords.index', ['page' => $currentPage + 1]) }}" class="px-3 py-2 rounded-md bg-gray-300 text-black hover:bg-blue-500 hover:text-white">&raquo;</a>
            @endif

            <!-- Tombol Last -->
            @if ($currentPage < $totalPages - 2)
                <a href="{{ route('passwords.index', ['page' => $totalPages]) }}" class="px-3 py-2 rounded-md bg-gray-300 text-black hover:bg-blue-500 hover:text-white">Last</a>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite/dist/flowbite.min.js"></script>
</body>
@endsection
