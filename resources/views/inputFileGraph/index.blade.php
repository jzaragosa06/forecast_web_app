{{-- @extends('layouts.base')

@section('title', 'View File')

@section('page-title', 'Manage File')

@section('content')
    <div class="container mx-auto my-10">
        <h1 class="text-2xl font-semibold mb-6">Time Series Data: {{ $timeSeriesData['filename'] }}</h1>

        <div id="chart"></div> <!-- Chart Container -->

        <table class="min-w-full mt-8 border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    @foreach ($timeSeriesData['header'] as $column)
                        <th class="border border-gray-300 px-4 py-2 text-left">{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($timeSeriesData['data'] as $row)
                    <tr class="bg-white border-b">
                        <td class="border border-gray-300 px-4 py-2">{{ $row['date'] }}</td>
                        @foreach ($row['values'] as $value)
                            <td class="border border-gray-300 px-4 py-2">{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection





@section('scripts')
    <script>
        $(document).ready(function() {
            var options = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false,
                    }
                },
                series: [
                    @for ($i = 1; $i < count($timeSeriesData['header']); $i++)
                        {
                            name: '{{ $timeSeriesData['header'][$i] }}',
                            data: {!! json_encode(
                                array_map(function ($row) use ($i) {
                                    return floatval($row['values'][$i - 1]);
                                }, $timeSeriesData['data']),
                            ) !!}
                        }
                        @if ($i < count($timeSeriesData['header']) - 1)
                            ,
                        @endif
                    @endfor
                ],
                xaxis: {
                    categories: {!! json_encode(array_column($timeSeriesData['data'], 'date')) !!},
                    type: 'datetime',
                },
                yaxis: [
                    @for ($i = 1; $i < count($timeSeriesData['header']); $i++)
                        {
                            title: {
                                text: ' {{ $timeSeriesData['header'][$i] }}'
                            },
                            labels: {
                                show: true,
                                formatter: function(value) {
                                    // Check if the value is a valid number before applying toFixed
                                    return isNaN(value) ? value : value.toFixed(
                                        2); // Safely format only valid numeric values
                                }
                            },
                            axisBorder: {
                                show: true,
                            },
                            axisTicks: {
                                show: true,
                            }
                        }
                        @if ($i < count($timeSeriesData['header']) - 1)
                            ,
                        @endif
                    @endfor
                ],
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    show: true,
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

        });
    </script>
@endsection --}}


@extends('layouts.base')

@section('title', 'View File')

@section('page-title', 'Manage File')

@section('content')
    <div class="container mx-auto my-10">
        {{-- <div>
            <div>
                <!-- Filename -->
                {{ $timeSeriesData['filename'] }}
            </div>
            <div>
                <!-- description -->
                <p class="text-gray-700 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. ...</p>
            </div>
        </div> --}}

        <div class="mb-6">
            <!-- Filename -->
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ $timeSeriesData['filename'] }}</p>

            <!-- Description -->
            <p class="text-gray-700 text-lg leading-relaxed">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. ...
            </p>
        </div>
        <div id="chart"></div> <!-- Chart Container -->

        <!-- DataTable -->
        {{-- <table id="timeSeriesTable" class="min-w-full mt-8 border-collapse border border-gray-300 display">
            <thead>
                <tr class="bg-gray-200">
                    @foreach ($timeSeriesData['header'] as $column)
                        <th class="border border-gray-300 px-4 py-2 text-left">{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($timeSeriesData['data'] as $row)
                    <tr class="bg-white border-b">
                        <td class="border border-gray-300 px-4 py-2">{{ $row['date'] }}</td>
                        @foreach ($row['values'] as $value)
                            <td class="border border-gray-300 px-4 py-2">{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table> --}}

        <table id="timeSeriesTable" class="min-w-full mt-8 table-auto text-left">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    @foreach ($timeSeriesData['header'] as $column)
                        <th class="py-3 px-4">{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach ($timeSeriesData['data'] as $row)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $row['date'] }}</td>
                        @foreach ($row['values'] as $value)
                            <td class="py-3 px-4">{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#timeSeriesTable').DataTable({
                paging: true, // Enable pagination
                searching: true, // Enable search box
                ordering: true, // Enable column ordering
                responsive: true, // Responsive table
                autoWidth: false, // Disable auto width to prevent layout issues
                lengthMenu: [5, 10, 25, 50], // Number of records per page
            });

            // ApexCharts initialization
            var options = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false,
                    }
                },
                series: [
                    @for ($i = 1; $i < count($timeSeriesData['header']); $i++)
                        {
                            name: '{{ $timeSeriesData['header'][$i] }}',
                            data: {!! json_encode(
                                array_map(function ($row) use ($i) {
                                    return floatval($row['values'][$i - 1]);
                                }, $timeSeriesData['data']),
                            ) !!}
                        }
                        @if ($i < count($timeSeriesData['header']) - 1)
                            ,
                        @endif
                    @endfor
                ],
                xaxis: {
                    categories: {!! json_encode(array_column($timeSeriesData['data'], 'date')) !!},
                    type: 'datetime',
                },
                yaxis: [
                    @for ($i = 1; $i < count($timeSeriesData['header']); $i++)
                        {
                            title: {
                                text: ' {{ $timeSeriesData['header'][$i] }}'
                            },
                            labels: {
                                show: true,
                                formatter: function(value) {
                                    return isNaN(value) ? value : value.toFixed(2);
                                }
                            },
                            axisBorder: {
                                show: true,
                            },
                            axisTicks: {
                                show: true,
                            }
                        }
                        @if ($i < count($timeSeriesData['header']) - 1)
                            ,
                        @endif
                    @endfor
                ],
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    show: true,
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
@endsection
