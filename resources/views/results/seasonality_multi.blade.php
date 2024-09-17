{{-- 
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
    <div class="container">
        <h4 class="text-center my-4">Multivariate Seasonality Result</h4>
        <div id="chart-container" class="row">
            <!-- Dynamic charts for each variable will be inserted here -->
        </div>
    </div>

    <script>
        // Mocked JSON data for demonstration, replace with your dynamic data
        const jsonData = @json($data);
        const data = JSON.parse(jsonData);

        // Generate x-axis labels
        const weeklyLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const yearlyLabels = Array.from({
            length: 365
        }, (_, i) => `Day ${i + 1}`);

        // Reference to the chart container
        const chartContainer = document.getElementById('chart-container');

        // Function to create chart
        function createChart(chartDiv, title, labels, seriesData) {
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
                tooltip: {
                    shared: true,
                    intersect: false
                },
                yaxis: {
                    title: {
                        text: 'Value'
                    }
                }
            };

            const chart = new ApexCharts(chartDiv, options);
            chart.render();
        }

        // Function to create a Bootstrap card for each variable
        function createCard(variableName) {
            const cardDiv = document.createElement('div');
            cardDiv.classList.add('col-md-12', 'mb-4');
            cardDiv.innerHTML = `
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">${variableName}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Weekly and Yearly charts will be inserted here -->
                            <div id="${variableName}-weekly-chart" class="col-md-6"></div>
                            <div id="${variableName}-yearly-chart" class="col-md-6"></div>
                        </div>
                    </div>
                </div>`;
            return cardDiv;
        }

        // Process data and create charts for each variable
        const colnames = data.colnames;

        if (data.seasonality_per_period && colnames) {
            colnames.forEach(col => {
                const seasonalityData = data.seasonality_per_period[col];
                const card = createCard(col);
                chartContainer.appendChild(card);

                // Create weekly chart if available
                if (seasonalityData.weekly) {
                    const weeklyDiv = document.getElementById(`${col}-weekly-chart`);
                    const weeklySeries = [{
                            name: 'Value',
                            data: seasonalityData.weekly.values
                        },
                        // {
                        //     name: 'Lower Bound',
                        //     data: seasonalityData.weekly.lower
                        // },
                        // {
                        //     name: 'Upper Bound',
                        //     data: seasonalityData.weekly.upper
                        // }
                    ];
                    createChart(weeklyDiv, `${col} - Weekly Seasonality`, weeklyLabels, weeklySeries);
                }

                // Create yearly chart if available
                if (seasonalityData.yearly) {
                    const yearlyDiv = document.getElementById(`${col}-yearly-chart`);
                    const yearlySeries = [{
                            name: 'Value',
                            data: seasonalityData.yearly.values
                        },
                        // {
                        //     name: 'Lower Bound',
                        //     data: seasonalityData.yearly.lower
                        // },
                        // {
                        //     name: 'Upper Bound',
                        //     data: seasonalityData.yearly.upper
                        // }
                    ];
                    createChart(yearlyDiv, `${col} - Yearly Seasonality`, yearlyLabels, yearlySeries);
                }
            });
        }
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
    <h4 class="text-center mt-3">Seasonality Result</h4>
    <div class="container">
        <div id="chart-container" class="row">
            <!-- Dynamic charts will be inserted here -->
        </div>
    </div>

    <script>
        // Mocked JSON data for demonstration, replace with your dynamic data
        const jsonData = @json($data);
        const data = JSON.parse(jsonData);

        // Generate x-axis labels
        const weeklyLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const yearlyLabels = Array.from({
            length: 365
        }, (_, i) => `Day ${i + 1}`);

        // Reference to the chart container
        const chartContainer = document.getElementById('chart-container');

        // Function to create a chart for each variable
        function createChart(title, labels, seriesData) {
            const chartDiv = document.createElement('div');
            chartDiv.classList.add('col-md-12', 'mb-4'); // Bootstrap styling for spacing
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
                tooltip: {
                    shared: true,
                    intersect: false
                },
                yaxis: {
                    title: {
                        text: 'Value'
                    }
                }
            };

            const chart = new ApexCharts(chartDiv, options);
            chart.render();
        }

        // Loop through each variable in the colnames
        const colnames = data.colnames;

        if (data.seasonality_per_period && colnames.length) {
            colnames.forEach((col, index) => {
                const seasonalityData = data.seasonality_per_period[col];

                // Add a separator for each variable for better visual organization
                const separator = document.createElement('div');
                separator.classList.add('col-12', 'text-center', 'my-3', 'py-2', 'bg-info', 'text-white');
                separator.textContent = `Seasonality of ${col}`;
                chartContainer.appendChild(separator);

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

                        // Prepare series data for ApexCharts
                        const seriesData = [{
                                name: 'Value',
                                data: seasonalityData[component].values
                            },
                            {
                                name: 'Lower Bound',
                                data: seasonalityData[component].lower
                            },
                            {
                                name: 'Upper Bound',
                                data: seasonalityData[component].upper
                            }
                        ];

                        // Create chart for each component (weekly/yearly)
                        createChart(title, labels, seriesData);
                    }
                });
            });
        }
    </script>

</body>

</html>
