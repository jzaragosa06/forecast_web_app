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

        // Function to create chart
        function createChart(title, labels, seriesData, isDatetime = false) {
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
                    intersect: false,
                    x: {
                        format: 'MMM dd' // Format the tooltip to show only month and day
                    }
                },
                yaxis: {
                    title: {
                        text: 'Value'
                    },
                    labels: {
                        show: true,
                        formatter: function(value) {
                            return isNaN(value) ? value : value.toFixed(2);
                        }
                    },
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
                        let labels, title, isDatetime = false;
                        if (component === 'weekly') {
                            labels = weeklyLabels;
                            title = `${col} - Weekly Seasonality`;
                        } else if (component === 'yearly') {
                            labels = yearlyLabels;
                            title = `${col} - Yearly Seasonality`;
                            isDatetime = true; // Set datetime flag for yearly
                        }

                        console.log(labels);
                        console.log(title);
                        console.log(seasonalityData[component].values);

                        // Prepare series data for ApexCharts
                        const seriesData = [{
                            name: 'Value',
                            data: seasonalityData[component].values
                        }, ];

                        // Create chart
                        createChart(title, labels, seriesData, isDatetime);
                    }
                });
            }
        }
    </script>

</body>

</html>
