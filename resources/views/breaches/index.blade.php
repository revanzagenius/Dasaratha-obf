@extends('layouts.app')

@section('content')
<body class="bg-gray-100  p-4">
    <div class="container mx-auto mt-4">

        <!-- Chart Section in a Card -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4">Breach Data Chart</h2>
            <div id="chart"></div>
        </div>

        <!-- Search Form -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Breach Data Table</h2>
            <form method="GET" action="{{ route('breaches.index') }}" class="flex">
                <input
                    type="text"
                    name="search"
                    placeholder="Search breach by name"
                    value="{{ $search }}"
                    class="p-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button
                    type="submit"
                    class="p-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600"
                >
                    Search
                </button>
            </form>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">Title</th>
                        <th scope="col" class="py-3 px-6">Domain</th>
                        <th scope="col" class="py-3 px-6">Breach Date</th>
                        <th scope="col" class="py-3 px-6">Pwn Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $item['Title'] }}</td>
                            <td class="py-4 px-6">{{ $item['Domain'] }}</td>
                            <td class="py-4 px-6">{{ $item['BreachDate'] }}</td>
                            <td class="py-4 px-6">{{ number_format($item['PwnCount']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {!! $data->links() !!}
        </div>

        <!-- Error Message -->
        @if ($errors->has('search'))
            <p class="text-red-500 mt-4">{{ $errors->first('search') }}</p>
        @endif
    </div>

    <script>
        // Data for the chart
        const chartData = @json($chartData);

        const options = {
            series: [{
                name: 'Pwn Count',
                data: chartData.map(item => item.count)
            }],
            chart: {
                type: 'line',
                height: 400
            },
            stroke: {
                curve: 'smooth'
            },
            dataLabels: {
                enabled: true
            },
            xaxis: {
                categories: chartData.map(item => item.title),
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

        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
</body>
@endsection
