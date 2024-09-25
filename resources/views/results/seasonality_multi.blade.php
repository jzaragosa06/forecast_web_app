{{-- <!DOCTYPE html>
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
        const jsonData = @json($data);
        const data = JSON.parse(jsonData);


        // Generate x-axis labels for yearly seasonality as dates (Jan 1 to Dec 31 of an arbitrary year)
        const generateYearlyLabels = () => {
            const labels = [];
            const arbitraryYear = 2020; // Arbitrary non-leap year
            let currentDate = new Date(arbitraryYear, 0, 1); // Start at January 1

            while (currentDate.getFullYear() === arbitraryYear) {
                // Convert to timestamp for ApexCharts datetime x-axis
                labels.push(currentDate.getTime());
                // Increment by 1 day
                currentDate.setDate(currentDate.getDate() + 1);
            }

            return labels;
        };

        const weeklyLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const yearlyLabels = generateYearlyLabels(); // Use the new function to generate date labels


        // Reference to the chart container
        const chartContainer = document.getElementById('chart-container');

        // Function to create a chart for each variable
        function createChart(title, labels, seriesData, isDatetime = false) {
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
                    type: isDatetime ? 'datetime' : 'category', // Use 'datetime' for yearly
                    categories: labels,
                    labels: {
                        formatter: function(value, timestamp) {
                            if (isDatetime) {
                                // Format the datetime labels to only show month and day
                                return new Date(timestamp).toLocaleDateString('en-US', {
                                    month: 'short',
                                    day: 'numeric'
                                });
                            } else {
                                return value;
                            }
                        }
                    }
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
                        let labels, title, isDatetime = false;
                        if (component === 'weekly') {
                            labels = weeklyLabels;
                            title = `${col} - Weekly Seasonality`;
                        } else if (component === 'yearly') {
                            labels = yearlyLabels;
                            title = `${col} - Yearly Seasonality`;
                            isDatetime = true;
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
                        createChart(title, labels, seriesData, isDatetime);
                    }
                });
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
    <div class="container">
        <div id="chart-container" class="row">
            <!-- Dynamic charts will be inserted here -->
        </div>
    </div>

    <script>
        const jsonData = @json($data);
        const data = JSON.parse(jsonData);

        // Generate x-axis labels for yearly seasonality as dates (Jan 1 to Dec 31 of an arbitrary year)
        const generateYearlyLabels = () => {
            const labels = [];
            const arbitraryYear = 2020; // Arbitrary non-leap year
            let currentDate = new Date(arbitraryYear, 0, 1); // Start at January 1

            while (currentDate.getFullYear() === arbitraryYear) {
                // Convert to timestamp for ApexCharts datetime x-axis
                labels.push(currentDate.getTime());
                // Increment by 1 day
                currentDate.setDate(currentDate.getDate() + 1);
            }

            return labels;
        };

        const weeklyLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const yearlyLabels = generateYearlyLabels(); // Use the new function to generate date labels

        // Reference to the chart container
        const chartContainer = document.getElementById('chart-container');

        // Function to create a combined chart for all variables
        function createCombinedChart(title, labels, seriesData, isDatetime = false, yaxisOptions) {
            const chartDiv = document.createElement('div');
            chartDiv.classList.add('col-md-12', 'mb-4'); // Bootstrap styling for spacing
            chartContainer.appendChild(chartDiv);

            const options = {
                chart: {
                    type: 'line',
                    height: 400,
                    animations: {
                        enabled: true
                    }
                },
                title: {
                    text: title,
                    align: 'left'
                },
                xaxis: {
                    type: isDatetime ? 'datetime' : 'category', // Use 'datetime' for yearly
                    categories: labels,
                    labels: {
                        formatter: function(value, timestamp) {
                            if (isDatetime) {
                                // Format the datetime labels to only show month and day
                                return new Date(timestamp).toLocaleDateString('en-US', {
                                    month: 'short',
                                    day: 'numeric'
                                });
                            } else {
                                return value;
                            }
                        }
                    }
                },
                series: seriesData,
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                markers: {
                    size: 0
                },
                tooltip: {
                    shared: true,
                    intersect: false
                },
                yaxis: yaxisOptions // Multiple y-axes for each variable
            };

            const chart = new ApexCharts(chartDiv, options);
            chart.render();
        }

        // Combine all variables for yearly or weekly charts into one graph with different y-axis scales
        const colnames = data.colnames;

        if (data.seasonality_per_period && colnames.length) {
            // Prepare data for combined yearly seasonality chart
            let yearlySeries = [];
            let yearlyYaxis = [];

            let weeklySeries = [];
            let weeklyYaxis = [];


            colnames.forEach((col, index) => {
                const seasonalityData = data.seasonality_per_period[col];

                // Prepare series for yearly seasonality
                if (seasonalityData['yearly']) {
                    yearlySeries.push({
                        name: col,
                        data: seasonalityData['yearly'].values
                    });

                    // Add y-axis configuration for this variable
                    yearlyYaxis.push({
                        seriesName: col,
                        title: {
                            text: col
                        },
                        labels: {
                            show: true,
                            formatter: function(value) {
                                return isNaN(value) ? value : value.toFixed(2);
                            }
                        },
                    });
                }

                // Prepare series for weekly seasonality
                if (seasonalityData['weekly']) {
                    weeklySeries.push({
                        name: col,
                        data: seasonalityData['weekly'].values
                    });

                    // Add y-axis configuration for this variable
                    weeklyYaxis.push({
                        seriesName: col,
                        title: {
                            text: col
                        },
                        labels: {
                            show: true,
                            formatter: function(value) {
                                return isNaN(value) ? value : value.toFixed(2);
                            }
                        },
                    });
                }
            });

            // Create combined chart for yearly seasonality
            if (yearlySeries.length > 0) {
                createCombinedChart('Combined Yearly Seasonality', yearlyLabels, yearlySeries, true, yearlyYaxis);
            }

            // Create combined chart for weekly seasonality
            if (weeklySeries.length > 0) {
                createCombinedChart('Combined Weekly Seasonality', weeklyLabels, weeklySeries, false, weeklyYaxis);
            }
        }
    </script>

</body>

</html>
