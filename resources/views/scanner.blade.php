@extends('layouts.app')

@section('title', 'IP Vulnerability Scanner')

@section('content')
<body class="bg-white text-black font-sans">
    <div class="container mx-auto mt-5">
        <!-- Form Input -->
        <div class="bg-white text-black rounded-lg shadow-lg p-6 mb-5">
            <h5 class="text-lg font-bold mb-4">Scan IP Address</h5>
            <form action="{{ url('/shodan/scan') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="ip" class="block text-sm font-medium mb-1">Input IP :</label>
                    <input type="text" id="ip" name="ip" placeholder="192.168.X.X" class="w-full p-2 bg-white rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-lg">Scan IP</button>
            </form>
        </div>

        @if(!empty($data['chart_data']))
        <div class="bg-white text-black rounded-lg shadow-lg p-6 mb-5">
            <h5 class="text-lg font-bold mb-4">Statistik Pemindaian</h5>
            <div class="relative h-64 w-full">
                <canvas id="scanStatsChart"></canvas>
            </div>
        </div>
        @endif

        <!-- Leaflet Map -->
        @if(!empty($data['latitude']) && !empty($data['longitude']))
        <div class="bg-white text-black rounded-lg shadow-lg p-6 mb-5">
            <h5 class="text-lg font-bold mb-4">Peta Lokasi IP</h5>
            <div id="map" class="h-96"></div>
        </div>
        @endif

        <!-- Results -->
        @if(isset($data))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Hasil Shodan -->
            <div class="bg-white text-black rounded-lg shadow-lg p-6">
                <h5 class="text-lg font-bold mb-4">Ringkasan Hasil Shodan</h5>
                <table class="w-full text-sm">
                    <tbody>
                        <tr>
                            <th class="text-left py-2">IP Address</th>
                            <td class="py-2">{{ $data['ip'] }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2">OS</th>
                            <td class="py-2">{{ $data['os'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2">ISP</th>
                            <td class="py-2">{{ $data['isp'] ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="text-lg font-bold mt-4">Kerentanan Ditemukan (CVE):</h5>
                @if(!empty($data['cve_details']))
                <table class="w-full text-sm mt-3">
                    <thead>
                        <tr>
                            <th class="text-left py-2">CVE</th>
                            <th class="text-left py-2">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['cve_details'] as $cve => $description)
                        <tr>
                            <td class="py-2">{{ $cve }}</td>
                            <td class="py-2">{{ $description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-red-500 mt-4">Tidak ada kerentanan yang ditemukan.</p>
                @endif
            </div>

            <!-- Hasil VirusTotal -->
            <div class="bg-white text-black rounded-lg shadow-lg p-6">
                <h5 class="text-lg font-bold mb-4">Ringkasan Hasil Pemindaian VirusTotal</h5>
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="text-left py-2">Parameter</th>
                            <th class="text-left py-2">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-left py-2">Community Score</th>
                            <td class="py-2">{{ $data['virus_total']['community_score'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2">Tanggal Analisis Terakhir</th>
                            <td class="py-2">{{ $data['virus_total']['last_analysis_date'] ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="text-lg font-bold mt-4">Detail Analisis Vendor Keamanan:</h5>
                @if(!empty($data['virus_total']['last_analysis_results']))
                <table class="w-full text-sm mt-3">
                    <thead>
                        <tr>
                            <th class="text-left py-2">Vendor</th>
                            <th class="text-left py-2">Hasil Analisis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['virus_total']['last_analysis_results'] as $vendor => $result)
                        <tr>
                            <td class="py-2">{{ $vendor }}</td>
                            <td class="py-2">
                                @if($result['category'] == 'malicious')
                                <span class="bg-red-500 text-white px-2 py-1 rounded">Malicious</span>
                                @elseif($result['category'] == 'clean')
                                <span class="bg-green-500 text-white px-2 py-1 rounded">Clean</span>
                                @else
                                <span class="bg-gray-500 text-white px-2 py-1 rounded">Unrated</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-red-500">Tidak ada data analisis vendor keamanan.</p>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Scripts -->
    @if(!empty($data['latitude']) && !empty($data['longitude']))
    <script>
        var map = L.map('map').setView([{{ $data['latitude'] }}, {{ $data['longitude'] }}], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
        L.marker([{{ $data['latitude'] }}, {{ $data['longitude'] }}]).addTo(map)
            .bindPopup('<b>IP Address:</b> {{ $data['ip'] }}<br><b>ISP:</b> {{ $data['isp'] ?? "N/A" }}')
            .openPopup();
    </script>
    @endif

    @if(!empty($data['chart_data']))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('scanStatsChart').getContext('2d');
        var chartData = {
            labels: ['Port Terbuka', 'Jumlah CVE', 'Malicious Score (VirusTotal)'],
            datasets: [{
                label: 'Statistik Pemindaian',
                data: [
                    {{ $data['chart_data']['ports_open'] }},
                    {{ $data['chart_data']['cve_count'] }},
                    {{ $data['chart_data']['malicious_count'] }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        };

        var scanStatsChart = new Chart(ctx, {
            type: 'pie',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endif
</body>
@endsection
