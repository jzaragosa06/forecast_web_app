<!DOCTYPE html>
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
            <div class="col-md-8 border border-dark">
                <canvas id="chart1"></canvas>
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
        const jsonData = @json($data);
        const data = JSON.parse(jsonData);

        // Initialize the first chart
        let chart1 = new Chart(document.getElementById('chart1'), {
            type: 'line',
            data: {
                labels: data.seasonality.index,
                datasets: [{
                    label: 'Seasonality',
                    data: data.seasonality.target,
                    borderColor: 'red',
                    fill: false
                }]
            }
        });

        chart1.update();
    </script>

</body>

</html>