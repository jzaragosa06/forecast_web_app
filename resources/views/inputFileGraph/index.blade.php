@extends('layouts.base')

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
@endsection
