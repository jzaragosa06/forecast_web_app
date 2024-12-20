@extends('layouts.base')

@section('title', 'View File')

@section('page-title', 'Manage File')

@section('content')
    <div class="container mx-auto">
        <div class="mb-2">
            <!-- Filename -->
            <h4 class="text-lg font-semibold mb-2 text-gray-700">{{ $timeSeriesData['filename'] }}</h4>
            <!-- Description -->
            <p class="text-gray-700 text-sm leading-relaxed">
                {{ $timeSeriesData['description'] }}
            </p>
        </div>
        <div id="chart"></div> <!-- Chart Container -->


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
                        show: true,
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
                    curve: 'smooth',
                    lineCap: 'butt',
                    colors: undefined,
                    width: 2,
                    dashArray: 0,
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
