@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CVE</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- New CVEs Today -->
            <div class="bg-white shadow-md rounded p-4">
                <h2 class="text-lg font-semibold">NEW CVE TODAY</h2>
                <p class="text-3xl font-bold">{{ $newCveToday }}</p>
            </div>

            <!-- Updated Today -->
            <div class="bg-white shadow-md rounded p-4">
                <h2 class="text-lg font-semibold">UPDATED TODAY</h2>
                <p class="text-3xl font-bold">{{ $updatedToday }}</p>
            </div>

            <!-- Weekly Known Exploited -->
            <div class="bg-white shadow-md rounded p-4">
                <h2 class="text-lg font-semibold">WEEKLY KNOWN EXPLOITED - KEV</h2>
                <p class="text-3xl font-bold">{{ $weeklyExploited }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Vulnerability Stream by Days -->
            <div class="bg-white shadow-md rounded p-2">
                <h2 class="text-md font-semibold mb-2">Vulnerability Stream by Days</h2>
                <div id="vulnerabilityChart"></div>
            </div>

            <!-- CVE Severity Distribution -->
            <div class="bg-white shadow-md rounded p-2">
                <h2 class="text-md font-semibold mb-2">CVE Severity Distribution</h2>
                <div id="severityChart"></div>
            </div>
        </div>

        <!-- Detailed Vulnerabilities Table -->
        <div class="bg-white shadow-md rounded p-4 mt-6">
            <h2 class="text-lg font-semibold mb-4">Vulnerability Details</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">CVE ID</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">CVSS Score</th>
                        <th class="px-4 py-2">Published At</th>
                        <th class="px-4 py-2">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vulnerabilities as $vulnerability)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $vulnerability->cve_id }}</td>
                        <td class="px-4 py-2">{{ $vulnerability->description }}</td>
                        <td class="px-4 py-2">{{ $vulnerability->cvss_score }}</td>
                        <td class="px-4 py-2">{{ $vulnerability->published_at }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ $vulnerability->detail_url }}" target="_blank" class="text-blue-500 hover:text-blue-700">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Vulnerability Stream by Days
        const vulnerabilityData = @json($vulnerabilityData);
        const vulnerabilityLabels = Object.keys(vulnerabilityData);
        const vulnerabilityValues = Object.values(vulnerabilityData);

        var optionsBar = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Number of Vulnerabilities',
                data: vulnerabilityValues
            }],
            xaxis: {
                categories: vulnerabilityLabels
            }
        };

        var chartBar = new ApexCharts(document.querySelector("#vulnerabilityChart"), optionsBar);
        chartBar.render();

        // CVE Severity Distribution
        const severityData = @json($severityDistribution);

        var optionsPie = {
            chart: {
                type: 'pie',
                height: 350
            },
            series: Object.values(severityData),
            labels: ['Low', 'Medium', 'High'],
            colors: ['#34D399', '#FBBF24', '#EF4444']
        };

        var chartPie = new ApexCharts(document.querySelector("#severityChart"), optionsPie);
        chartPie.render();
    </script>
</body>
@endsection
