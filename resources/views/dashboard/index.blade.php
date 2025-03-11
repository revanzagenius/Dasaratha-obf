@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6 dark:bg-gray-900 dark:text-white">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard</h1>
                        <p class="text-sm font-medium text-gray-500">Real-time security monitoring and vulnerability assessment</p>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                <!-- Domains Card -->
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 hover:scale-105 transition-transform duration-300 ease-in-out">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Monitored Domains</p>
                            <h3 class="text-2xl font-bold text-white mt-1">{{ $domainsCount }}</h3>
                            <div class="mt-2 flex items-center text-sm text-blue-100">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>Active</span>
                            </div>
                        </div>
                        <div class="p-3 bg-blue-400/30 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Ports Card -->
                <div
                    class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 hover:scale-105 transition-transform duration-300 ease-in-out">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-emerald-100">Open Ports</p>
                            <h3 class="text-2xl font-bold text-white mt-1">{{ $portsCount }}</h3>
                            <div class="mt-2 flex items-center text-sm text-emerald-100">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Monitored</span>
                            </div>
                        </div>
                        <div class="p-3 bg-emerald-400/30 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Vulnerabilities Card -->
                <div
                    class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 hover:scale-105 transition-transform duration-300 ease-in-out">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-amber-100">Vulnerabilities</p>
                            <h3 class="text-2xl font-bold text-white mt-1">{{ $totalVulns }}</h3>
                            <div class="mt-2 flex items-center text-sm text-amber-100">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>Detected</span>
                            </div>
                        </div>
                        <div class="p-3 bg-amber-400/30 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Data Exposure Card -->
                <div
                    class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl shadow-lg p-6 hover:scale-105 transition-transform duration-300 ease-in-out">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-rose-100">Data Exposure</p>
                            <h3 class="text-2xl font-bold text-white mt-1">{{ $dataExposeCount }}</h3>
                            <div class="mt-2 flex items-center text-sm text-rose-100">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>Critical</span>
                            </div>
                        </div>
                        <div class="p-3 bg-rose-400/30 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Threat Map -->
            <div class="bg-white rounded-xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Global Threat Map</h2>
                            <p class="text-sm text-gray-500">Geographic distribution of threats</p>
                        </div>
                    </div>
                </div>
                <div id="map" class="h-[450px] w-full rounded-lg border border-gray-200 shadow-lg"></div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 mt-6">
                <!-- Data Monitor Chart -->
                <div class="bg-white rounded-xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-gray-100 rounded-lg">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Data Exposure Trend</h2>
                                <p class="text-sm text-gray-500">Historical analysis of exposed data</p>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('dashboard.indexd') }}" class="flex items-center">
                            <select name="filter"
                                class="bg-gray-100 text-gray-700 border-0 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-200"
                                onchange="this.form.submit()">
                                <option value="day" {{ $filter === 'day' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>Last 30 Days</option>
                                <option value="year" {{ $filter === 'year' ? 'selected' : '' }}>Last 12 Months</option>
                            </select>
                        </form>
                    </div>
                    <div id="exposureChart" class="transition-all ease-in-out duration-300"></div>
                </div>

                <!-- Security Metrics Chart -->
                <div class="bg-white rounded-xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-gray-100 rounded-lg">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Security Metrics</h2>
                                <p class="text-sm text-gray-500">Ports and vulnerabilities analysis</p>
                            </div>
                        </div>
                    </div>
                    <div id="portsVulnsChart" class="transition-all ease-in-out duration-300"></div>
                </div>
            </div>

            
        </div>
    </div>

    <!-- Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Map Configuration
        const locations = @json($locations);
        const map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '©OpenStreetMap contributors'
        }).addTo(map);

        locations.forEach(location => {
            if (location.latitude && location.longitude) {
                const marker = L.marker([location.latitude, location.longitude])
                    .addTo(map)
                    .bindPopup(`
                    <div class="text-sm">
                        <div class="font-bold mb-1">IP Address: ${location.ip}</div>
                        <div class="text-gray-600">Location detected</div>
                    </div>
                `);
            }
        });

        // Chart Options
        const chartOptions = {
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                },
                foreColor: '#374151'
            },
            series: [{
                name: 'Exposed Data',
                data: @json($emailsOverTime->pluck('email_count'))
            }],
            xaxis: {
                categories: @json($emailsOverTime->pluck('date')),
                labels: {
                    style: {
                        colors: '#374151'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#374151'
                    }
                }
            },
            colors: ['#3B82F6'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            grid: {
                borderColor: '#E5E7EB',
                strokeDashArray: 4
            }
        };

        // Initialize Charts
        const exposureChart = new ApexCharts(document.querySelector("#exposureChart"), chartOptions);
        exposureChart.render();

        const securityMetricsChart = new ApexCharts(document.querySelector("#securityMetricsChart"), {
            ...chartOptions,
            chart: {
                type: 'radar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Security Metrics',
                data: [{{ $totalPorts }}, {{ $totalVulns }}, {{ $dataExposeCount }},
                    {{ $domainsCount }}
                ]
            }],
            labels: ['Open Ports', 'Vulnerabilities', 'Data Exposure', 'Domains']
        });
        securityMetricsChart.render();

        const vulnDistributionChart = new ApexCharts(document.querySelector("#vulnDistributionChart"), {
            ...chartOptions,
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Vulnerabilities',
                data: [{{ $totalVulns }}, Math.floor({{ $totalVulns }} * 0.6), Math.floor(
                    {{ $totalVulns }} * 0.3), Math.floor({{ $totalVulns }} * 0.1)]
            }],
            xaxis: {
                categories: ['Total', 'High', 'Medium', 'Low']
            }
        });
        vulnDistributionChart.render();

        const portActivityChart = new ApexCharts(document.querySelector("#portActivityChart"), {
            ...chartOptions,
            series: [{
                name: 'Active Ports',
                data: [{{ $portsCount }}, Math.floor({{ $portsCount }} * 0.8), Math.floor(
                    {{ $portsCount }} * 0.6), Math.floor({{ $portsCount }} * 0.9), Math.floor(
                    {{ $portsCount }} * 0.7)]
            }],
            xaxis: {
                categories: ['Now', '-1h', '-2h', '-3h', '-4h']
            }
        });
        portActivityChart.render();

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
@endsection
