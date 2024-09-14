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

    <div class="container">
        <h4>Forecast Result</h4>

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

        <button id="detailed_result_button" class="btn btn-primary">Show Detailed Result</button>
        <div id="detailed_result" style="display: none">
            <h4>Detailed Forecast Result</h4>
            <div class="row">
                <div class="col-md-8 border border-dark">
                    <div id="chart2"></div>
                </div>
                <div class="col-md-4 border border-dark">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                        ut
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 border border-dark">
                    <div id="chart3"></div>
                </div>
                <div class="col-md-4 border border-dark">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                        ut
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);
        const colname = data.metadata.colname;


        console.log(colname);

        renderChart1();
        renderChart2();
        renderChart3();

        function renderChart1() {
            // Forecast index
            let forecastIndex = data.forecast.pred_out.index;
            let originalDataIndex = data.data.entire_data.index;
            let full_index = [...originalDataIndex, ...forecastIndex];

            let forecastData_null = [...Array(originalDataIndex.length).fill(null), ...data.forecast.pred_out[
                `${colname}`]];
            let origDataValue = data.data.entire_data[`${colname}`];





            // Initialize the first chart using ApexCharts
            let options1 = {
                chart: {
                    type: 'line',
                    height: 300
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
        }


        function renderChart2() {
            let full_index = data.data.entire_data.index;
            let trainData = data.data.train_data[`${colname}`];

            let testValue = [...Array(trainData.length).fill(null), ...data.data.test_data[`${colname}`]];
            let predValue = [...Array(trainData.length).fill(null), ...data.forecast.pred_test[`${colname}`]];


            // Initialize the first chart using ApexCharts
            let options2 = {
                chart: {
                    type: 'line',
                    height: 300
                },
                series: [{
                        name: 'train data',
                        data: trainData,

                    }, {
                        name: 'Test data',
                        data: testValue,

                    },
                    {
                        name: 'Pred test data',
                        data: predValue,

                    },
                ],
                xaxis: {
                    categories: full_index
                },
                stroke: {
                    curve: 'smooth',
                    width: 1,
                },

            };

            let chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
            chart2.render();
        }


        function renderChart3() {
            // Forecast index
            let forecastIndex = data.forecast.pred_out.index;
            let originalDataIndex = data.data.entire_data.index;
            let full_index = [...originalDataIndex, ...forecastIndex];

            let forecastData_null = [...Array(originalDataIndex.length).fill(null), ...data.forecast.pred_out[
                `${colname}`]];
            let origDataValue = data.data.entire_data[`${colname}`];





            // Initialize the first chart using ApexCharts
            let options3 = {
                chart: {
                    type: 'line',
                    height: 300
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

            let chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
            chart3.render();
        }


        // JavaScript to toggle the detailed result section visibility
        const detailedResultButton = document.getElementById("detailed_result_button");
        const detailedResultDiv = document.getElementById("detailed_result");

        detailedResultButton.addEventListener("click", function() {
            if (detailedResultDiv.style.display === "none") {
                detailedResultDiv.style.display = "block";
                detailedResultButton.textContent = "Hide Detailed Result";
            } else {
                detailedResultDiv.style.display = "none";
                detailedResultButton.textContent = "Show Detailed Result";
            }
        });
    </script>





</body>

</html>
