@extends('layouts.app')

@section('title', 'IP Vulnerability Scanner')

@section('content')
<style>
#map-container {
    position: relative; /* Mengatur agar map berada di dalam flow dokumen */
    z-index: 0; /* Pastikan map tidak menutupi elemen lain */
}

#map {
    height: 400px; /* Atur tinggi map sesuai kebutuhan */
    width: 100%; /* Pastikan map mengambil seluruh lebar kontainer */
    border-radius: 8px; /* Tambahkan radius jika diperlukan */
    z-index: 0; /* Pastikan elemen map tidak berada di atas elemen lain */
}
</style>
<body class="bg-gray-100">
    <div class="grid grid-cols-3 gap-6 p-6">
        <!-- Cards -->
        <div class="bg-blue-600 text-white p-4 rounded shadow">
            <h2 class="text-2xl font-bold">{{ $domainsCount }}</h2>
            <p><b>Domains</b></p>
        </div>
        <div class="bg-green-500 text-white p-4 rounded shadow">
            <h2 class="text-2xl font-bold">{{ $portsCount }}</h2>
            <p>Port Monitor</p>
        </div>
        <div class="bg-red-500 text-white p-4 rounded shadow">
            <h2 class="text-2xl font-bold">{{ $dataExposeCount }}</h2>
            <p>Data Expose</p>
        </div>
    </div>

    <!-- Map -->
    <div id="map-container" class="w-full p-6">
        <div id="map" class="rounded shadow"></div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-2 gap-4 p-6">
        <div class="bg-white p-6 rounded shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Data Monitor Over Time</h3>
                <form method="GET" action="{{ route('dashboard.indexd') }}">
                    <select name="filter" class="border border-gray-300 rounded px-2 py-1" onchange="this.form.submit()">
                        <option value="day" {{ $filter === 'day' ? 'selected' : '' }}>Day</option>
                        <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>Month</option>
                        <option value="year" {{ $filter === 'year' ? 'selected' : '' }}>Year</option>
                    </select>
                </form>
            </div>
            <div id="emailsOverTimeChart"></div>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-bold mb-4">Ports and Vulnerabilities</h3>
            <div id="portsVulnsChart"></div>
        </div>
    </div>

    <!-- Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const locations = @json($locations);

        // Inisialisasi map
        const map = L.map('map').setView([0, 0], 2); // Pusatkan di koordinat global dengan zoom 2

        // Tambahkan tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Tambahkan marker untuk setiap lokasi
        locations.forEach(location => {
            if (location.latitude && location.longitude) {
                L.marker([location.latitude, location.longitude])
                    .addTo(map)
                    .bindPopup(`IP: ${location.ip}`)
                    .openPopup();
            }
        });
    </script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Data untuk chart Data Monitor Over Time
        const dates = @json($emailsOverTime->pluck('date'));
        const emailCounts = @json($emailsOverTime->pluck('email_count'));

        const emailsOverTimeOptions = {
            chart: {
                type: 'line',
                height: 350,
            },
            series: [{
                name: 'Data Result',
                data: emailCounts
            }],
            xaxis: {
                categories: dates,
                title: {
                    text: 'Date'
                }
            },
            yaxis: {
                title: {
                    text: 'Data Result'
                }
            },
        };

        const emailsOverTimeChart = new ApexCharts(document.querySelector("#emailsOverTimeChart"), emailsOverTimeOptions);
        emailsOverTimeChart.render();

        // Data untuk chart Ports and Vulnerabilities
        const portsVulnsOptions = {
            chart: {
                type: 'bar',
                height: 350,
            },
            series: [{
                name: 'Count',
                data: [{{ $totalPorts }}, {{ $totalVulns }}]
            }],
            xaxis: {
                categories: ['Ports', 'Vulnerabilities'],
                title: {
                    text: 'Categories'
                }
            },
            yaxis: {
                title: {
                    text: 'Count'
                }
            },
            colors: ['#FF6384', '#36A2EB'],
        };

        const portsVulnsChart = new ApexCharts(document.querySelector("#portsVulnsChart"), portsVulnsOptions);
        portsVulnsChart.render();
    </script>
</body>
@endsection
