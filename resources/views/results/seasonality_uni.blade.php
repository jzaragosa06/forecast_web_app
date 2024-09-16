{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Document</title>
</head>

<body>
    <h4>Seasonality Result</h4>
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
        const jsonData = @json($data);
        const data = JSON.parse(jsonData);

        console.log(data);
    </script>

</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <title>Seasonality Chart</title>
</head>

<body>
    <h4>Seasonality Result</h4>
    <div class="container">
        <div class="row">
            <!-- Container where charts will be dynamically added -->
            <div id="chart-container" class="col-md-12">
                <!-- Dynamic charts will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        // Mocked JSON data for demonstration, replace with your dynamic data
        const jsonData = @json($data);
        const data = JSON.parse(jsonData);

        // console.log(data);

        // Generate x-axis labels
        const weeklyLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const yearlyLabels = Array.from({
            length: 365
        }, (_, i) => `Day ${i + 1}`);

        // Reference to the chart container
        const chartContainer = document.getElementById('chart-container');

        // Function to create chart
        function createChart(title, labels, seriesData) {
            const chartDiv = document.createElement('div');
            chartDiv.style.marginBottom = '30px';
            chartContainer.appendChild(chartDiv);

            const options = {
                chart: {
                    type: 'line',
                    height: 350,
                    animations: {
                        enabled: true
                    }
                },
                title: {
                    text: title,
                    align: 'center'
                },
                xaxis: {
                    categories: labels
                },
                series: seriesData,
                stroke: {
                    curve: 'smooth',
                    width: 1,
                },
                markers: {
                    size: 0
                },
                // tooltip: {
                //     shared: true,
                //     intersect: false
                // },
                yaxis: {
                    title: {
                        text: 'Value'
                    }
                }
            };

            const chart = new ApexCharts(chartDiv, options);
            chart.render();
        }

        // Loop through each variable (colname)
        const colnames = data.colnames;

        if (data.seasonality_per_period && colnames) {
            for (const col in data.seasonality_per_period) {
                const seasonalityData = data.seasonality_per_period[col];
                console.log(seasonalityData);

                // Loop through the components (e.g., 'weekly', 'yearly')
                data.components.forEach(component => {

                    if (seasonalityData[component]) {
                        let labels, title;
                        if (component === 'weekly') {
                            labels = weeklyLabels;
                            title = `${col} - Weekly Seasonality`;
                        } else if (component === 'yearly') {
                            labels = yearlyLabels;
                            title = `${col} - Yearly Seasonality`;
                        }

                        console.log(labels);
                        console.log(title);
                        console.log(seasonalityData[component].values);


                        // Prepare series data for ApexCharts
                        const seriesData = [{
                                name: 'Value',
                                data: seasonalityData[component].values
                            },
                            // {
                            //     name: 'Lower Bound',
                            //     data: seasonalityData[component].lower
                            // },
                            // {
                            //     name: 'Upper Bound',
                            //     data: seasonalityData[component].upper
                            // }
                        ];

                        // Create chart
                        createChart(title, labels, seriesData);
                    }
                });
            }
        }
    </script>

</body>

</html>
