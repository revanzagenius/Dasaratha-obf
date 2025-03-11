@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6 dark:bg-gray-900 dark:text-white">
        <!-- Main Container with Increased Max Width -->
        <div class="max-w-[90rem] mx-auto px-6 py-8">
            <!-- Header Section -->
            <div class="flex items-center gap-4 mb-10">
                <div class="p-3 bg-gradient-to-br from-teal-500 to-teal-500 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-sm font-medium text-gray-500">Threat Intelligence</p>
                </div>
            </div>

            <!-- Domain Monitoring Section -->
            <section class="mb-12">
                <div class="flex items-center mb-6 border-l-4 border-teal-400 pl-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-800">Domain Monitoring</h2>
                        <p class="text-sm text-slate-500 mt-1">Analysis of domain security metrics</p>
                    </div>
                </div>


                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Port Distribution Chart -->
                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-slate-800">Port Distribution</h3>
                            <p class="text-xs text-slate-500 mt-1">Analysis of ports across domains</p>
                        </div>
                        <div id="portDistributionChart" style="min-height: 240px;"></div>
                    </div>

                    <!-- Vulnerability Distribution Chart -->
                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-slate-800">Vulnerability Distribution</h3>
                            <p class="text-xs text-slate-500 mt-1">Domain vulnerability analysis</p>
                        </div>
                        <div id="vulnDistributionChart" style="min-height: 240px;"></div>
                    </div>
                </div>
            </section>

            {{-- VIP List Data Breach --}}
            <section class="mb-12">
                <div class="flex items-center mb-6 border-l-4 border-teal-400 pl-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-800">VIP List</h2>
                        <p class="text-sm text-slate-500 mt-1">VIP List tracking</p>
                    </div>
                </div>

                <!-- Quick Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Data Breach Card -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-slate-600">Total Data VIP List Breaches</h3>
                                <p class="text-xl font-bold text-slate-800 mt-1">
                                    {{ number_format($data['total_results'] ?? 0) }}</p>
                            </div>
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-4 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-slate-600">Total VIP List</h3>
                                <p class="text-xl font-bold text-slate-800 mt-1">
                                    {{ $vip_list }}</p>
                            </div>
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
            </section>

            {{-- Global Data Breach --}}
            <section class="mb-12">
                <div class="flex items-center mb-6 border-l-4 border-teal-400 pl-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-800">Global Data Breach</h2>
                        <p class="text-sm text-slate-500 mt-1">Global data Breach Tracking</p>
                    </div>
                </div>

                <!-- Quick Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-6">
                    <!-- Data Breach Card -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-slate-600">Total Data Breaches</h3>
                                <p class="text-xl font-bold text-slate-800 mt-1">
                                    {{ number_format($totalDataCount ?? 0) }}</p>
                            </div>
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <h3 class="text-sm font-medium text-slate-800">Latest Breach Data Chart</h3>
                        <p class="text-xs text-slate-500 mt-1">Analysis of latest breach data chart</p>
                        <div id='GlobalDataBreachChart'></div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <h3 class="text-sm font-medium text-slate-800">Latest Breach Data Table</h3>
                        <p class="text-xs text-slate-500 mt-1">Analysis of latest breach data table</p>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Domain
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Breach Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            PWN Count
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paginatedData as $ld)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $ld['Title'] }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $ld['Domain'] }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $ld['BreachDate'] }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ number_format($ld['PwnCount']) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </section>

            <!-- CVE Analysis Section -->
            <section class="mb-12">
                <div class="flex items-center mb-6 border-l-4 border-teal-400 pl-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-800">CVE Analysis</h2>
                        <p class="text-sm text-slate-500 mt-1">Vulnerability and exploit tracking</p>
                    </div>
                </div>

                <!-- Quick Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                    <!-- Total CVE Card -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-slate-600">CVE</h3>
                                <p class="text-xl font-bold text-slate-800 mt-1">{{ $totalCVE }}</p>
                            </div>
                            <div class="p-2 bg-teal-50 rounded-lg">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- New CVE Card -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-slate-600">New CVEs Today</h3>
                                <p class="text-xl font-bold text-slate-800 mt-1">{{ $newCveToday }}</p>
                            </div>
                            <div class="p-2 bg-red-50 rounded-lg">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Exploited Card -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-slate-600">Weekly Exploited</h3>
                                <p class="text-xl font-bold text-slate-800 mt-1">{{ $weeklyExploited }}</p>
                            </div>
                            <div class="p-2 bg-amber-50 rounded-lg">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CVSS Score Distribution -->
                <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-slate-800">CVSS Score Distribution</h3>
                        <p class="text-xs text-slate-500 mt-1">Vulnerability severity analysis</p>
                    </div>
                    <div id="cvssChart" style="min-height: 280px;"></div>
                </div>
            </section>

            <!-- Password Analysis Section -->
            <section class="mb-12">
                <div class="flex items-center mb-6 border-l-4 border-teal-400 pl-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-800">Password Analysis</h2>
                        <p class="text-sm text-slate-500 mt-1">Password security metrics</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Password Composition -->
                    <div class="col-span-2 bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-slate-800">Password Composition</h3>
                            <p class="text-xs text-slate-500 mt-1">Distribution of password types</p>
                        </div>
                        <div id="passwordCompositionChart" style="min-height: 240px;"></div>
                    </div>

                    <div class="col-span-1 bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-slate-800">Latest Pawn Password</h3>
                        </div>
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="text-left border-b border-slate-200">
                                    <th class="pb-2 font-medium text-slate-600">No</th>
                                    <th class="pb-2 font-medium text-slate-600">Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentPasswords as $index => $password)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                        <td class="py-2">{{ $index + 1 }}</td>
                                        <td class="py-2 text-slate-600">{{ $password }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </section>

            {{-- Global IP Spam --}}
            <section class="mb-12">
                <div class="flex items-center mb-6 border-l-4 border-teal-400 pl-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-800">Global IP Spam</h2>
                        <p class="text-sm text-slate-500 mt-1">5 Latest Global IP Spam</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="text-left border-b border-slate-200">
                                    <th class="pb-2 font-medium text-slate-600">No</th>
                                    <th class="pb-2 font-medium text-slate-600">IP Address</th>
                                    <th class="pb-2 font-medium text-slate-600">Risk Level</th>
                                    <th class="pb-2 font-medium text-slate-600">Description</th>
                                    <th class="pb-2 font-medium text-slate-600">Details</th>
                                    <th class="pb-2 font-medium text-slate-600">Reported At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestEntriesGlobalSpam as $index => $latestEntry)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                        <td class="py-2">{{ $index + 1 }}</td>
                                        <td class="py-2 text-slate-600">{{ $latestEntry->ip }}</td>
                                        <td class="py-2 text-slate-600">{{ $latestEntry->risk_level }}</td>
                                        <td class="py-2 text-slate-600">{{ $latestEntry->description }}</td>
                                        <td class="py-2 text-slate-600">
                                            <a href="{{ $latestEntry->url }}" target="_blank" class="text-blue-600 hover:underline">View Details</a>
                                        </td>
                                        <td class="py-2 text-slate-600">{{ $latestEntry->reported_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Malware Analysis Section -->
            <section class="mb-12">
                <div class="flex items-center mb-6 border-l-4 border-teal-400 pl-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-800">Malware Analysis</h2>
                        <p class="text-sm text-slate-500 mt-1">Threat detection and tracking</p>
                    </div>
                    <span
                        class="px-3 py-1 text-xs font-medium bg-purple-50 text-purple-600 rounded-full">{{ number_format($totalMalware) }}
                        Detected</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-1gap-6 mb-6">
                    <!-- Malware Distribution -->

                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-slate-800">Malware Distribution</h3>
                            <p class="text-xs text-slate-500 mt-1">Types of detected malware</p>
                        </div>
                        <div id="malwareDistributionChart" style="min-height: 240px;"></div>
                    </div>
                </div>


                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Top Malware Table -->
                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <h3 class="text-sm font-medium text-slate-800 mb-4">Top 10 Malware Threats</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-left border-b border-slate-200">
                                        <th class="pb-2 font-medium text-slate-600">Name</th>
                                        <th class="pb-2 font-medium text-slate-600">Type</th>
                                        <th class="pb-2 font-medium text-slate-600">Rank</th>
                                        <th class="pb-2 font-medium text-slate-600">Trend</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topMalwares as $malware)
                                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                            <td class="py-2">
                                                <a href="{{ $malware['url'] }}" target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                                    {{ $malware['name'] }}
                                                </a>
                                            </td>
                                            <td class="py-2 text-slate-600">{{ $malware['type'] }}</td>
                                            <td class="py-2 text-slate-600">#{{ $malware['rank'] }}</td>
                                            <td class="py-2">
                                                @if ($malware['trend'] === 'up')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                                        ↑ Rising
                                                    </span>
                                                @elseif($malware['trend'] === 'down')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                        ↓ Declining
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-700">
                                                        → Stable
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Most Active Malware Chart -->
                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-slate-800">Most Active Malware</h3>
                            <p class="text-xs text-slate-500 mt-1">Activity level of detected malware</p>
                        </div>
                        <div id="mostActiveChart" style="min-height: 240px;"></div>
                    </div>
                </div>
            </section>

            <section class="mb-12">
                <div class="flex items-center mb-6 border-l-4 border-teal-400 pl-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-800">Threat Actor</h2>
                        <p class="text-sm text-slate-500 mt-1">Threat actor</p>
                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-slate-600">Total Threat Groups</h3>
                                <p class="text-xl font-bold text-slate-800 mt-1">{{ $allThreatGroups->count() }}</p>
                            </div>
                            <div class="p-2 bg-teal-50 rounded-lg">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-slate-600">Countriy Targeting Indonesia</h3>
                                <p class="text-xl font-bold text-slate-800 mt-1">
                                    {{ $allThreatGroups->pluck('country')->flatten()->unique()->count() }}</p>
                            </div>
                            <div class="p-2 bg-teal-50 rounded-lg">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-slate-600">Last Updated</h3>
                                <p class="text-xl font-bold text-slate-800 mt-1">
                                    {{ $allThreatGroups->first() ? \Carbon\Carbon::parse($allThreatGroups->first()['last-card-change'])->format('M d, Y') : 'N/A' }}
                            </div>
                            <div class="p-2 bg-teal-50 rounded-lg">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4">Threat Groups by Country Targeting Indonesia
                        </h2>
                        <div id="countryChart" style="min-height: 400px;"></div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4">Actor Distribution by Source</h2>
                        <div id="nameGiverChart" style="min-height: 400px;"></div>
                    </div>
                </div>
            </section>

            {{-- News --}}
            <section class="mb-12">
                <div class="flex items-center mb-6 border-l-4 border-teal-400 pl-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-800">News</h2>
                        <p class="text-sm text-slate-500 mt-1">5 Latest CyberSecurity News & TheHacker News</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-slate-800 mb-5">CyberSecurity News</h2>
                        </div>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Link
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestCybersecurityNews as $index => $article)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $index + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $article->title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $article->description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ $article->url }}" target="_blank"
                                                class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 text-center">
                                                More
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-5 border border-slate-100">
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-slate-800 mb-5">CyberSecurity News</h2>
                        </div>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Link
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestCybersecurityNews as $index => $article)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $index + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $article->title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $article->description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ $article->url }}" target="_blank"
                                                class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 text-center">
                                                More
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </div>
    </div>

    <script>
        const chartTheme = {
            mode: 'light',
            palette: 'palette4',
            fontFamily: 'Inter, sans-serif',
        };

        // Port Distribution Chart
        const portDistributionOptions = {
            chart: {
                type: 'donut',
                height: 240,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                }
            },
            theme: chartTheme,
            series: {!! json_encode(array_column($domainData, 'ports')) !!},
            labels: {!! json_encode(array_keys($domainData)) !!},
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Port',
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            }
        };

        // Vulnerability Distribution Chart
        const vulnDistributionOptions = {
            chart: {
                type: 'donut',
                height: 240,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                }
            },
            theme: chartTheme,
            series: {!! json_encode(array_column($domainData, 'vulns')) !!},
            labels: {!! json_encode(array_keys($domainData)) !!},
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Vulnerability',
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            }
        };

        // CVSS Score Chart
        const cvssChartOptions = {
            chart: {
                type: 'bar',
                height: 280,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                }
            },
            theme: chartTheme,
            series: [{
                name: 'Vulnerabilities',
                data: {!! json_encode(array_values($cvssGroups)) !!}
            }],
            xaxis: {
                categories: {!! json_encode(array_keys($cvssGroups)) !!}
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '60%'
                }
            },
            dataLabels: {
                enabled: false
            }
        };

        // Password Composition Chart
        const passwordCompositionOptions = {
            chart: {
                type: 'donut',
                height: 240,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                }
            },
            theme: chartTheme,
            series: [{{ $onlyLetters }}, {{ $onlyNumbers }}, {{ $lettersAndNumbers }}, {{ $etc }}],
            labels: ['Only Letters', 'Only Numbers', 'Letters and Numbers', 'Other'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Password',
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            }
        };

        // Malware Distribution Chart
        const malwareDistributionOptions = {
            chart: {
                type: 'bar',
                height: 240,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                }
            },
            theme: chartTheme,
            series: [{
                name: 'Malware Count',
                data: {!! json_encode(array_values($typeCounts)) !!}
            }],
            xaxis: {
                categories: {!! json_encode(array_keys($typeCounts)) !!}
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '60%'
                }
            },
            dataLabels: {
                enabled: false
            }
        };

        // Most Active Malware Chart
        const mostActiveChartOptions = {
            chart: {
                type: 'bar',
                height: 240,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                }
            },
            theme: chartTheme,
            series: [{
                name: 'Activity Level',
                data: {!! json_encode(array_column($mostActiveMalwares, 'position')) !!}
            }],
            xaxis: {
                categories: {!! json_encode(array_column($mostActiveMalwares, 'name')) !!}
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 4,
                    columnWidth: '60%'
                }
            },
            dataLabels: {
                enabled: false
            }
        };

        // Convert Laravel collection to JavaScript array
        const threatGroups = @json($allThreatGroups);

        const countries = {};
        const nameGivers = {};

        threatGroups.forEach(group => {
            if (Array.isArray(group.country)) {
                group.country.forEach(country => {
                    countries[country] = (countries[country] || 0) + 1;
                });
            }

            if (Array.isArray(group.names)) {
                group.names.forEach(name => {
                    let giver = name["name-giver"] || "Unknown";
                    if (giver.trim() === "?" || giver.trim() === "") {
                        giver = "Unknown";
                    }
                    nameGivers[giver] = (nameGivers[giver] || 0) + 1;
                });
            }
        });

        // Country Distribution Chart
        const countryChartOptions = {
            chart: {
                type: 'donut',
                height: 400,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                }
            },
            theme: chartTheme,
            series: Object.values(countries),
            labels: Object.keys(countries),
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Groups',
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            }
        };

        // Name Giver Distribution Chart
        const nameGiverChartOptions = {
            chart: {
                type: 'bar',
                height: 400,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                }
            },
            theme: chartTheme,
            series: [{
                name: 'Actors',
                data: Object.values(nameGivers)
            }],
            xaxis: {
                categories: Object.keys(nameGivers),
                labels: {
                    rotate: -45,
                    trim: true
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '60%',
                    distributed: true
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            }
        };

        const GlobalDataBreachchartData = @json($chartData);

        const GlobalDataBreachOptions = {
            series: [{
                name: 'Pwn Count',
                data: GlobalDataBreachchartData.map(item => item.count)
            }],
            chart: {
                type: 'line',
                height: 400
            },
            theme: chartTheme,
            stroke: {
                curve: 'smooth'
            },
            dataLabels: {
                enabled: true
            },
            xaxis: {
                categories: GlobalDataBreachchartData.map(item => item.title),
                title: {
                    text: 'Breach Title'
                }
            },
            yaxis: {
                title: {
                    text: 'Pwn Count'
                }
            }
        };


        // Initialize all charts when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all ApexCharts
            new ApexCharts(document.querySelector("#portDistributionChart"), portDistributionOptions).render();
            new ApexCharts(document.querySelector("#vulnDistributionChart"), vulnDistributionOptions).render();
            new ApexCharts(document.querySelector("#cvssChart"), cvssChartOptions).render();
            new ApexCharts(document.querySelector("#passwordCompositionChart"), passwordCompositionOptions)
                .render();
            new ApexCharts(document.querySelector("#malwareDistributionChart"), malwareDistributionOptions)
                .render();
            new ApexCharts(document.querySelector("#mostActiveChart"), mostActiveChartOptions).render();
            new ApexCharts(document.querySelector("#countryChart"), countryChartOptions).render();
            new ApexCharts(document.querySelector("#nameGiverChart"), nameGiverChartOptions).render();
            new ApexCharts(document.querySelector("#GlobalDataBreachChart"), GlobalDataBreachOptions).render();
        });
    </script>
@endsection
