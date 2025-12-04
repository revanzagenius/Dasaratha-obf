@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-center text-3xl font-bold mb-6">📊 Analisis Sentimen Tweet</h2>

    <!-- Statistik Sentimen -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-md text-center transform hover:scale-105 transition-all">
            <h4 class="text-lg font-semibold">Positif 😃</h4>
            <h2 class="text-4xl font-bold">{{ $positive }}</h2>
        </div>
        <div class="bg-red-500 text-white p-6 rounded-lg shadow-md text-center transform hover:scale-105 transition-all">
            <h4 class="text-lg font-semibold">Negatif 😡</h4>
            <h2 class="text-4xl font-bold">{{ $negative }}</h2>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md text-center transform hover:scale-105 transition-all">
            <h4 class="text-lg font-semibold">Netral 😐</h4>
            <h2 class="text-4xl font-bold">{{ $neutral }}</h2>
        </div>
    </div>

    <!-- Chart Container -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Line Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h4 class="text-lg font-semibold mb-3">📈 Tren Sentimen per Hari</h4>
            <div id="sentimentLineChart"></div>
        </div>

        <!-- Donut Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h4 class="text-lg font-semibold mb-3">📊 Distribusi Sentimen</h4>
            <div id="sentimentDonutChart"></div>
        </div>
    </div>

    <!-- Tabel Tweet dengan Paginasi -->
    <div class="mt-10 bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-lg font-semibold mb-4">📝 Daftar Tweet</h4>
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 p-2">Username</th>
                    <th class="border border-gray-300 p-2">Tweet</th>
                    <th class="border border-gray-300 p-2">Sentimen</th>
                    <th class="border border-gray-300 p-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tweets as $tweet)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-300 p-2">{{ $tweet->author_username }}</td>
                    <td class="border border-gray-300 p-2">{{ $tweet->text }}</td>
                    <td class="border border-gray-300 p-2 text-center">
                        @if($tweet->sentiment == 'positive')
                            <span class="text-green-500 font-bold">Positif 😃</span>
                        @elseif($tweet->sentiment == 'negative')
                            <span class="text-red-500 font-bold">Negatif 😡</span>
                        @else
                            <span class="text-yellow-500 font-bold">Netral 😐</span>
                        @endif
                    </td>
                    <td class="border border-gray-300 p-2 text-gray-500">
                        {{ \Carbon\Carbon::parse($tweet->created_at)->format('d M Y, H:i') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $tweets->links() }}
        </div>
    </div>
</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var dates = @json($dates);
    var positiveTrends = @json($positiveTrends);
    var negativeTrends = @json($negativeTrends);
    var neutralTrends = @json($neutralTrends);
    var sentimentData = [{{ $positive }}, {{ $negative }}, {{ $neutral }}];

    // Line Chart
    var optionsLine = {
        chart: { type: 'line', height: 350 },
        series: [
            { name: 'Positif', data: positiveTrends },
            { name: 'Negatif', data: negativeTrends },
            { name: 'Netral', data: neutralTrends }
        ],
        xaxis: { categories: dates },
        colors: ['#28a745', '#dc3545', '#ffc107'],
        stroke: { width: 3 }
    };
    var chartLine = new ApexCharts(document.querySelector("#sentimentLineChart"), optionsLine);
    chartLine.render();

    // Donut Chart
    var optionsDonut = {
        chart: { type: 'donut', height: 350 },
        series: sentimentData,
        labels: ['Positif', 'Negatif', 'Netral'],
        colors: ['#28a745', '#dc3545', '#ffc107'],
        responsive: [{ breakpoint: 480, options: { chart: { width: 300 } } }]
    };
    var chartDonut = new ApexCharts(document.querySelector("#sentimentDonutChart"), optionsDonut);
    chartDonut.render();
</script>
@endsection
