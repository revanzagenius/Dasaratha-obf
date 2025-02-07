@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">IP Reports Dictionary Attacker</h1>

    <div class="card bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Latest Entries</h2>
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border border-gray-200">IP Address</th>
                        <th class="px-4 py-2 border border-gray-200">Risk Level</th>
                        <th class="px-4 py-2 border border-gray-200">Description</th>
                        <th class="px-4 py-2 border border-gray-200">Details</th>
                        <th class="px-4 py-2 border border-gray-200">Reported At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestEntries as $entry)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-200">{{ $entry['ip'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $entry['riskLevel'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $entry['description'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">
                            <a href="{{ $entry['url'] }}" target="_blank" class="text-blue-600 hover:underline">View Details</a>
                        </td>
                        <td class="px-4 py-2 border border-gray-200">{{ $entry['pubDate'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Other Entries</h2>
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border border-gray-200">IP Address</th>
                        <th class="px-4 py-2 border border-gray-200">Risk Level</th>
                        <th class="px-4 py-2 border border-gray-200">Description</th>
                        <th class="px-4 py-2 border border-gray-200">Details</th>
                        <th class="px-4 py-2 border border-gray-200">Reported At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($otherEntries as $entry)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-200">{{ $entry['ip'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $entry['riskLevel'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $entry['description'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">
                            <a href="{{ $entry['url'] }}" target="_blank" class="text-blue-600 hover:underline">View Details</a>
                        </td>
                        <td class="px-4 py-2 border border-gray-200">{{ $entry['pubDate'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
