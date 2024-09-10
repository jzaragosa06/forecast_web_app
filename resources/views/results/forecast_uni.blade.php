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
    <h4>Forecast Result</h4>
    <div class="container">
        <div class="row">
            <div class="col-md-8 border border-dark">
                <canvas id="chart1"></canvas>
                <canvas id="chart2"></canvas>
            </div>
            <div class="col-md-4 border border-dark">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>

    </div>
    <script>
        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);

        // Initialize the first chart
        let chart1 = new Chart(document.getElementById('chart1'), {
            type: 'line',
            data: {
                labels: data.forecast.pred_out.index,
                datasets: [{
                    label: 'Pred Out',
                    data: data.forecast.pred_out.target,
                    borderColor: 'red',
                    fill: false
                }]
            }
        });

        // Initialize the second chart
        let chart2 = new Chart(document.getElementById('chart2'), {
            type: 'line',
            data: {
                labels: data.forecast.pred_test.index,
                datasets: [{
                    label: 'Pred Test',
                    data: data.forecast.pred_test.target,
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });

        // Update both charts
        chart1.update();
        chart2.update();
    </script>


</body>

</html> --}}




{{-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
</head>

<body>
    <h4>Forecast Result</h4>
    <div class="container">
        <div class="row">
            <div class="col-md-8 border border-dark">
                <div id="chart1"></div>
                <div id="chart2"></div>
            </div>
            <div class="col-md-4 border border-dark">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);

        // Helper function to convert index to Date objects
        const convertToDateObjects = (indexList) => {
            return indexList.map(dateStr => {
                const date = new Date(dateStr); // Convert each index to Date object
                return date.toLocaleDateString(); // Format the date (you can customize this)
            });
        };

        // Convert the index into date objects for both charts
        const predOutDates = convertToDateObjects(data.forecast.pred_out.index);
        const predTestDates = convertToDateObjects(data.forecast.pred_test.index);


        

        // Initialize the first chart using ApexCharts
        let options1 = {
            chart: {
                type: 'line',
                height: 200
            },
            series: [{
                name: 'Pred Out',
                data: data.forecast.pred_out.target
            }],
            xaxis: {
                categories: predOutDates // Use the converted date objects
            },
            stroke: {
                curve: 'smooth',
                width: 1,
            },
            colors: ['#FF0000'] // red color
        };

        let chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
        chart1.render();

        // Initialize the second chart using ApexCharts
        let options2 = {
            chart: {
                type: 'line',
                height: 200
            },
            series: [{
                name: 'Pred Test',
                data: data.forecast.pred_test.target
            }],
            xaxis: {
                categories: predTestDates // Use the converted date objects
            },
            stroke: {
                curve: 'smooth',
                width: 1,
            },
            colors: ['#0000FF'] // blue color
        };

        let chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
        chart2.render();
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

    <title>Document</title>
</head>

<body>
    <h4>Forecast Result</h4>
    <div class="container">
        <div class="row">
            <div class="col-md-8 border border-dark">
                <div id="chart1"></div>
            </div>
            <div class="col-md-4 border border-dark">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);


        // Forecast index
        const forecastIndex = data.forecast.pred_out.index;
        const originalDataIndex = data.data.entire_data.index;

        const full_index = [...originalDataIndex, ...forecastIndex];
        console.log(full_index);


        const nullsBeforeForecast = Array(originalDataIndex.length).fill(null);
        const forecastData = data.forecast.pred_out.target;
        const forecastData_null = [...nullsBeforeForecast, ...forecastData];
        const origDataValue = data.data.entire_data.Value;

        
        console.log(forecastData_null);

        // Initialize the first chart using ApexCharts
        let options1 = {
            chart: {
                type: 'line',
                height: 200
            },
            series: [{
                name: 'orig data',
                data: origDataValue,

            }, {
                name: 'Pred Out',
                data: forecastData_null,

            }],
            xaxis: {
                categories: full_index
            },
            stroke: {
                curve: 'smooth',
                width: 1,
            },

        };

        let chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
        chart1.render();
    </script>




    {{-- <script>
        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);

        // Original data
        const originalData = data.data.entire_data.Value;
        // Forecast data
        const forecastData = data.forecast.pred_out.target;
        // Forecast index
        const forecastIndex = data.forecast.pred_out.index;

        // Initialize the chart with null values for preceding forecast points
        const nullsBeforeForecast = Array(originalData.length).fill(null);
        const completeForecastData = [...nullsBeforeForecast, ...forecastData];
        const completeIndex = [...data.data.entire_data.index, ...forecastIndex];

        // Initialize the first chart using ApexCharts
        let options1 = {
            chart: {
                type: 'line',
                height: 200
            },
            series: [{
                name: 'Original Data',
                data: originalData
            }, {
                name: 'Forecast',
                data: completeForecastData
            }],
            xaxis: {
                categories: completeIndex,
                type: 'datetime' // Assuming your x-axis values are date-time
            },
            stroke: {
                curve: 'smooth',
                width: 1
            },
            colors: ['#FF0000', '#00FF00'] // Red for Original Data, Green for Forecast
        };

        let chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
        chart1.render();
    </script>
 --}}
</body>

</html>
