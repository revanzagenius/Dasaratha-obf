@extends('layouts.app')

@section('title', 'Master User')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="w-full bg-white rounded-lg shadow-lg p-8 mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Pencarian Shodan</h1>

        <form id="search-form" class="space-y-6">
            <div>
                <label for="query" class="block text-lg font-medium text-gray-700">Masukkan query pencarian:</label>
                <input type="text" id="query" name="query" required placeholder="Contoh: apache" class="mt-2 block w-full p-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Cari</button>
        </form>

        <div id="results" class="mt-8"></div>
    </div>

    <script>
        $(document).ready(function () {
            $('#search-form').submit(function (e) {
                e.preventDefault();

                var query = $('#query').val();

                $.ajax({
                    url: '{{ route("shodan.search") }}',
                    method: 'GET',
                    data: { query: query },
                    success: function (response) {
                        var resultHtml = '';
                        if (response.matches && response.matches.length > 0) {
                            response.matches.forEach(function (match) {
                                resultHtml += '<div class="bg-white p-4 mb-4 rounded-lg shadow-md">';
                                resultHtml += '<h3 class="text-lg font-bold text-gray-800">IP: ' + match.ip_str + '</h3>';
                                resultHtml += '<p class="text-sm text-gray-600"><strong>Port:</strong> ' + match.port + '</p>';
                                resultHtml += '<p class="text-sm text-gray-600"><strong>Hostname:</strong> ' + (match.hostnames.length > 0 ? match.hostnames.join(', ') : 'Tidak ditemukan') + '</p>';
                                resultHtml += '<p class="text-sm text-gray-600"><strong>Location:</strong> ' + (match.location.country_name || 'Tidak ditemukan') + '</p>';
                                resultHtml += '</div>';
                            });
                        } else {
                            resultHtml = '<div class="bg-red-100 text-red-600 p-4 rounded-lg shadow-md text-center">Tidak ada hasil ditemukan.</div>';
                        }
                        $('#results').html(resultHtml);
                    },
                    error: function () {
                        $('#results').html('<div class="bg-red-100 text-red-600 p-4 rounded-lg shadow-md text-center">Gagal melakukan pencarian.</div>');
                    }
                });
            });
        });
    </script>
@endsection