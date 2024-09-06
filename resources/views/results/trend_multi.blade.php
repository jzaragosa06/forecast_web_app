<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Trend Analysis - Multivariate Time Series</title>
</head>

<body>
    <h4>Trend Analysis Result</h4>
    <div class="container">
        <div class="row">
            <!-- Container where charts will be dynamically added -->
            <div id="chart-container" class="col-md-12">
                <!-- Dynamic charts will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);

        // Function to dynamically create charts for each variable
        function createCharts(data) {
            const chartContainer = document.getElementById('chart-container');
            const index = data.trend.index; // Time index (date or time)

            // Loop through each variable in colname
            data.colname.forEach((col) => {
                // Create a new div for each variable chart
                const div = document.createElement('div');
                div.className = "col-md-12 mb-4";

                // Create a new canvas for each variable
                const canvas = document.createElement('canvas');
                canvas.id = `chart-${col}`;
                div.appendChild(canvas);
                chartContainer.appendChild(div);

                // Initialize the chart for each variable
                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: index, // X-axis: time index
                        datasets: [{
                                label: `${col} - Original Value`,
                                data: data.trend[col], // Original value data
                                borderColor: 'black',
                                fill: false,
                                borderWidth: 2
                            },
                            {
                                label: `${col} - SMA 5`,
                                data: data.trend[`${col}_sma_5`], // SMA 5
                                borderColor: 'red',
                                fill: false,
                                borderWidth: 2,
                                borderDash: [5, 5] // Dashed line for visual distinction
                            },
                            {
                                label: `${col} - SMA 10`,
                                data: data.trend[`${col}_sma_10`], // SMA 10
                                borderColor: 'blue',
                                fill: false,
                                borderWidth: 2,
                                borderDash: [5, 2] // Another dash pattern
                            },
                            {
                                label: `${col} - SMA 20`,
                                data: data.trend[`${col}_sma_20`], // SMA 20
                                borderColor: 'green',
                                fill: false,
                                borderWidth: 2,
                                borderDash: [10, 5] // Another dash pattern
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: `Trend Analysis for ${col}`
                        },
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Date/Time'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Values'
                                }
                            }
                        }
                    }
                });
            });
        }

        // Call the function to create charts dynamically
        createCharts(data);
    </script>

</body>

</html>
