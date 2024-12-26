@extends('layouts.app')

@section('content')
<body class="bg-gray-900 text-white">

    <!-- Main Content -->
    <div class="container mx-auto mt-10">
        <h1 class="text-center text-4xl font-bold mb-6">14,453,524,165 Compromised Assets</h1>
        <p class="text-center text-gray-400 mb-8">
            Click here to view our updated search operators and learn how to utilize regex, and the true power of DeHashed.
        </p>

        <!-- Form Search -->
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <form action="/search" method="POST" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label for="domain" class="block text-sm font-medium text-gray-700 mb-2">Search Domain :</label>
                    <input type="text" id="domain" name="domain"
                        class="block w-full px-4 py-2 text-gray-900 bg-gray-200 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter domain, e.g., bri.co.id" required>
                </div>
                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-300">
                    Search
                </button>
            </form>
        </div>
    </div>
</body>
@endsection
