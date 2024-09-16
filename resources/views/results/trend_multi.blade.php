


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> <!-- Include ApexCharts -->
    <title>Trend Analysis - Multivariate Time Series</title>
    <style>
        #var-in-one-graph-container {
            display: none;
        }
    </style>
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
    <button id="var-in-one-graph-btn" class="btn btn-primary">Display the trend of variables side by side</button>
    <div id="var-in-one-graph-container">
        <h4>Comparing the trend of each variable</h4>
        <div class="container">
            <div class="row">
                <div id="var-in-one-graph-chart" class="col-md-12"></div>
            </div>
        </div>
    </div>

    <script>
        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);

        // Utility function to handle missing values
        const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

        // Function to check if variables are on the same scale
        function checkSameScale(data) {
            const ranges = data.colname.map(col => {
                const values = cleanData(data.trend[col]).filter(value => value !== null);
                const min = Math.min(...values);
                const max = Math.max(...values);
                return max - min;
            });

            const maxRange = Math.max(...ranges);
            const minRange = Math.min(...ranges);

            // Check if the ranges differ significantly (e.g., more than a factor of 10)
            return (maxRange / minRange) < 10;
        }

        // Function to dynamically create charts for each variable
        function createCharts(data) {
            const chartContainer = document.getElementById('chart-container');
            const index = data.trend.index; // Time index (date or time)

            // Loop through each variable in colname
            data.colname.forEach((col) => {
                // Create a new div for each variable chart
                const div = document.createElement('div');
                div.className = "col-md-12 mb-4";
                chartContainer.appendChild(div);

                // Clean the data to handle missing values
                const originalData = cleanData(data.trend[col]);
                const sma5Data = cleanData(data.trend[`${col}_sma_5`]);
                const sma10Data = cleanData(data.trend[`${col}_sma_10`]);
                const sma20Data = cleanData(data.trend[`${col}_sma_20`]);

                // Initialize the chart for each variable using ApexCharts
                const options = {
                    chart: {
                        type: 'line',
                        height: 350,
                        zoom: {
                            enabled: true
                        }
                    },
                    series: [{
                        name: `${col} - Original Value`,
                        data: originalData,
                    }, {
                        name: `${col} - SMA 5`,
                        data: sma5Data,
                    }, {
                        name: `${col} - SMA 10`,
                        data: sma10Data,
                    }, {
                        name: `${col} - SMA 20`,
                        data: sma20Data,
                    }],
                    xaxis: {
                        categories: index, // X-axis labels (dates/times)
                        title: {
                            text: 'Date/Time'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Values'
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    markers: {
                        size: 0
                    },
                    title: {
                        text: `Trend Analysis for ${col}`,
                        align: 'left'
                    },
                    tooltip: {
                        enabled: true,
                        shared: true,
                        intersect: false
                    },
                    colors: ['#546E7A', '#FF4560', '#1E90FF', '#00E396'], // Assign colors
                    legend: {
                        position: 'top'
                    }
                };

                // Append the chart
                const chart = new ApexCharts(div, options);
                chart.render();
            });
        }

        // Function to display all variables in a single chart
        function createCombinedChart(data, useLogarithmic) {
            const index = data.trend.index; // Time index (date or time)

            const seriesData = data.colname.map((col) => {
                const originalData = cleanData(data.trend[col]);
                const transformedData = useLogarithmic ?
                    originalData.map(value => value !== null ? Math.log(value) : null) :
                    originalData;
                return {
                    name: col,
                    data: transformedData
                };
            });

            // Options for combined chart
            const options = {
                chart: {
                    type: 'line',
                    height: 450,
                    zoom: {
                        enabled: true
                    }
                },
                series: seriesData,
                xaxis: {
                    categories: index,
                    title: {
                        text: 'Date/Time'
                    }
                },
                yaxis: {
                    title: {
                        text: useLogarithmic ? 'Logarithmic Values' : 'Original Values'
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                markers: {
                    size: 0
                },
                title: {
                    text: `Trend Comparison of All Variables (${useLogarithmic ? 'Logarithmic Scale' : 'Original Scale'})`,
                    align: 'left'
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                    intersect: false
                },
                colors: ['#FF4560', '#00E396', '#1E90FF', '#FEB019', '#775DD0'], // Customize colors as needed
                legend: {
                    position: 'top'
                }
            };

            // Render chart
            const chartDiv = document.getElementById('var-in-one-graph-chart');
            const chart = new ApexCharts(chartDiv, options);
            chart.render();
        }

        // Show combined chart when button is clicked
        document.getElementById('var-in-one-graph-btn').addEventListener('click', function() {
            const container = document.getElementById('var-in-one-graph-container');

            // Check if variables are on the same scale
            const sameScale = checkSameScale(data);
            let useLogarithmic = false;

            if (!sameScale) {
                if (!confirm(
                        'The variables are not on the same scale. Would you like to display the data in logarithmic scale?'
                    )) {
                    return; // User canceled the action
                }
                useLogarithmic = true; // Use logarithmic scale if data is not on the same scale
            }

            container.style.display = 'block'; // Show the container
            createCombinedChart(data, useLogarithmic); // Call function to create combined chart
        });

        // Call the function to create individual charts dynamically
        createCharts(data);
    </script>

</body>

</html>
