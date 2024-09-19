<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $timeSeriesData['filename'] }} - Time Series Graph</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Time Series Data: {{ $timeSeriesData['filename'] }} </h1>

        <div id="chart"></div> <!-- Chart Container -->

        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    @foreach ($timeSeriesData['header'] as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($timeSeriesData['data'] as $row)
                    <tr>
                        <td>{{ $row['date'] }}</td>
                        @foreach ($row['values'] as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
