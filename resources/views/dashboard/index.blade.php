@extends('layouts.app')

@section('title', 'IP Vulnerability Scanner')

@section('content')
<body class="bg-gray-100">

    <!-- Cards -->
    <div class="grid grid-cols-4 gap-4 p-6">
        <div class="bg-blue-600 text-white p-4 rounded shadow">
            <h2 class="text-2xl font-bold">{{ $domainsCount }}</h2> <!-- Menampilkan jumlah domain -->
            <p>Domains</p>
            <a href="#" class="text-white underline">More info</a>
        </div>
        <div class="bg-green-500 text-white p-4 rounded shadow">
            <h2 class="text-2xl font-bold">{{ $portsCount }}</h2> <!-- Menampilkan jumlah port -->
            <p>Port Monitor</p>
            <a href="#" class="text-white underline">More info</a>
        </div>
        <div class="bg-red-500 text-white p-4 rounded shadow">
            <h2 class="text-2xl font-bold">65</h2>
            <p>Data Expose</p>
            <a href="#" class="text-white underline">More info</a>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-2 gap-4 p-6">
        <!-- Sales Chart -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold mb-4">Sales</h3>
            <canvas id="salesChart"></canvas>
        </div>

          <!-- Chart Section -->
          <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Stoke Details</h2>
                <button class="bg-gray-100 px-4 py-2 rounded-lg text-gray-500">Show By Month ▼</button>
            </div>
            <canvas id="chart"></canvas>
        </div>

    </script>
        <!-- Visitors Map -->
        <div class="bg-blue-100 p-6 rounded shadow">
            <h3 class="text-lg font-bold mb-4">Visitors</h3>
            <div id="map" class="h-48"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart.js example for Sales chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Sales',
                    data: [10, 20, 30, 40, 50, 60, 70],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
            }
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js configuration
    const ctx = document.getElementById('chart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [
                {
                    label: 'Desktops',
                    data: [30, 50, 60, 40, 70, 50, 80],
                    backgroundColor: 'rgba(155, 89, 182, 0.6)',
                    borderWidth: 1,
                },
                {
                    label: 'Tablets',
                    data: [40, 60, 70, 50, 90, 60, 100],
                    borderColor: '#FFC107',
                    backgroundColor: 'transparent',
                    type: 'line',
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                },
            },
        },
    });

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>
@endsection
