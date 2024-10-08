<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApexCharts Line Chart Click Event - Two Series</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>

    <!-- Container for the chart -->
    <div id="chart"></div>

    <script>
        // Initialize the chart
        var options = {
            chart: {
                type: 'line',
                height: 350,
                events: {
                    legendClick: function(chartContext, seriesIndex, opts) {
                        console.log('clicked on ', seriesIndex);
                    },
                    markerClick: function(event, chartContext, opts) {
                        console.log('chart context', chartContext);
                        console.log('chart opts', opts);
                    }
                }
            },
            series: [{
                    name: 'Series 1',
                    data: [{
                            x: new Date(2023, 0, 1),
                            y: 34
                        },
                        {
                            x: new Date(2023, 1, 1),
                            y: 43
                        },
                        {
                            x: new Date(2023, 2, 1),
                            y: 31
                        },
                        {
                            x: new Date(2023, 3, 1),
                            y: 55
                        },
                        {
                            x: new Date(2023, 4, 1),
                            y: 42
                        }
                    ]
                },
                {
                    name: 'Series 2',
                    data: [{
                            x: new Date(2023, 0, 1),
                            y: 22
                        },
                        {
                            x: new Date(2023, 1, 1),
                            y: 35
                        },
                        {
                            x: new Date(2023, 2, 1),
                            y: 44
                        },
                        {
                            x: new Date(2023, 3, 1),
                            y: 28
                        },
                        {
                            x: new Date(2023, 4, 1),
                            y: 39
                        }
                    ]
                }
            ],
            xaxis: {
                type: 'datetime',
                title: {
                    text: 'Date'
                }
            },
            yaxis: {
                title: {
                    text: 'Values'
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        // Render the chart
        chart.render();
    </script>

</body>

</html>
