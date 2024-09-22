<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

</head>

<body>

    {{-- <div class="container my-6">
        <div class="row">
            <div class="col-12 col-md-8 p-4">
                <div>
                    <div id="chart1"></div>
                </div>
            </div>
            <div class="col-12 col-md-4 p-4">
                <div>
                    <div class="mb-4">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <div>
                                <span>Time Series Type:</span>
                                <div id="tstype"></div>
                            </div>
                            <div>
                                <span>Frequency:</span>
                                <div id="freq"></div>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div>
                                <span>Forecast Horizon:</span>
                                <div id="steps"></div>
                            </div>
                            <div>
                                <span>Target:</span>
                                <div id="target"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div id="detailed_result_button" class="col-6 pr-2">
                            <button id="toggleButton">
                                Detailed Result</button>
                        </div>
                        <div class="col-6 pl-2">
                            <button>Converse with AI</button>
                        </div>
                    </div>
                    <div>insert a chat here</div>
                </div>
            </div>
        </div>

        <div id="detailed_result" style="display: none;">
            <div class="row">
                <div class="col-12 col-md-8 p-4">
                    <div>
                        <div id="chart2"></div>
                    </div>
                </div>
                <div class="col-12 col-md-4 p-4">
                    <div>
                        <div class="mb-4">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <div>
                                    <span>MAE:</span>
                                    <div id="mae"></div>
                                </div>
                                <div>
                                    <span>MSE:</span>
                                    <div id="mse"></div>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div>
                                    <span>RSME:</span>
                                    <div id="rsme"></div>
                                </div>
                                <div>
                                    <span>MAPE:</span>
                                    <div id="mape"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-8 p-4">
                    <div>
                        <table id="forecastTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Forecasted Value</th>
                                    <th>True Value</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody id="forecastTableBody-test">
                                <!-- Example rows (rendered dynamically) -->
                                <tr>
                                    <td>2024-01-01</td>
                                    <td>100</td>
                                    <td>90</td>
                                    <td>10</td>
                                </tr>
                                <!-- Add more example rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-4 p-4">
                    <div>
                        <!-- Placeholder for middle box content -->
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <div id="chart1"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt
                                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                    ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <span>MAE:</span>
                                    <div id="mae"></div>
                                </div>
                                <div>
                                    <span>MSE:</span>
                                    <div id="mse"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <span>RSME:</span>
                                    <div id="rsme"></div>
                                </div>
                                <div>
                                    <span>MAPE:</span>
                                    <div id="mape"></div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6" id="detailed_result_button" >Detailed Resul</div>
                            <div class="col-6">Converse with AI</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <table id="forecastTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Forecasted Value</th>
                                    <th>True Value</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody id="forecastTableBody-out">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div id="chatContainer">
                    <div>
                        <h2>Chat with AI</h2>
                        <div id="chatBox">
                            <!-- Chat messages will go here -->
                        </div>
                        <input type="text" id="chatInput" placeholder="Type your message..." />
                        <button id="sendChat">Send</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="detailed_result" style="display: none;">
            <div class="row">
                <div class="col-12 col-md-8 p-4">
                    <div>
                        <div id="chart2"></div>
                    </div>
                </div>
                <div class="col-12 col-md-4 p-4">
                    <div>
                        <div class="mb-4">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <div>
                                    <span>MAE:</span>
                                    <div id="mae"></div>
                                </div>
                                <div>
                                    <span>MSE:</span>
                                    <div id="mse"></div>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div>
                                    <span>RSME:</span>
                                    <div id="rsme"></div>
                                </div>
                                <div>
                                    <span>MAPE:</span>
                                    <div id="mape"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-8 p-4">
                    <div>
                        <table id="forecastTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Forecasted Value</th>
                                    <th>True Value</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody id="forecastTableBody-test">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-4 p-4">
                    <div>
                        <!-- Placeholder for middle box content -->
                    </div>
                </div>
            </div>
        </div>
    </div>









    <script>
        $(document).ready(function() {
            $('#forecastTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": false, // Remove the search box
                "lengthChange": false // Remove the entries dropdown
            });
        });
        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);
        const colname = data.metadata.colname;

        console.log(colname);

        renderChart1();
        renderChart2();
        // renderForecastTable_out();
        renderForecastTable_test();

        $('#mae').text(data.forecast.metrics.mae);
        $('#mse').text(data.forecast.metrics.mse);
        $('#rmse').text(data.forecast.metrics.rmse);
        $('#mape').text(data.forecast.metrics.mape);


        $('#tstype').text(data.metadata.tstype);
        $('#freq').text(data.metadata.freq);
        $('#description').text(data.metadata.description);
        $('#steps').text(data.metadata.steps);
        $('#target').text(data.metadata.colname);

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
                    categories: full_index,
                    type: 'datetime'
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            // Check if the value is a valid number before applying toFixed
                            return isNaN(value) ? value : value.toFixed(
                                2); // Safely format only valid numeric values
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            // Check if the value is a valid number before applying toFixed
                            return isNaN(value) ? value : value.toFixed(
                                2); // Safely format only valid numeric values
                        }
                    }
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
                    categories: full_index,
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            // Check if the value is a valid number before applying toFixed
                            return isNaN(value) ? value : value.toFixed(
                                2); // Safely format only valid numeric values
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            // Check if the value is a valid number before applying toFixed
                            return isNaN(value) ? value : value.toFixed(
                                2); // Safely format only valid numeric values
                        }
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 1,
                },

            };

            let chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
            chart2.render();
        }







        const detailedResultButton = document.getElementById("detailed_result_button");
        const detailedResultDiv = document.getElementById("detailed_result");

        detailedResultButton.addEventListener("click", function() {


            if (detailedResultDiv.style.display === "none" || detailedResultDiv.style.display === "") {
                detailedResultDiv.style.display = "block";
                toggleButton.textContent = "Hide Detailed Result";
                toggleButton.classList.remove("bg-blue-500", "hover:bg-blue-600");
                toggleButton.classList.add("bg-red-500", "hover:bg-red-600"); // Change to a different color
            } else {
                detailedResultDiv.style.display = "none";
                toggleButton.textContent = "Show Detailed Result";
                toggleButton.classList.remove("bg-red-500", "hover:bg-red-600");
                toggleButton.classList.add("bg-blue-500", "hover:bg-blue-600"); // Revert to original color
            }
        });



        function renderForecastTable_out() {
            let forecastIndex = data.forecast.pred_out.index;
            let forecastValues = data.forecast.pred_out[`${colname}`];
            let tableBody = document.getElementById('forecastTableBody-out');

            let rows = '';
            forecastIndex.forEach((date, index) => {
                const value = forecastValues[index];
                rows += `
                    <tr class="border-b border-gray-200">
                        <td class="py-2 px-4">${date}</td>
                        <td class="py-2 px-4">${value}</td>
                    </tr>
                `;
            });

            tableBody.innerHTML = rows;
        }


        function renderForecastTable_test() {

            let forecastIndex = data.data.test_data.index;
            let forecastValues = data.forecast.pred_test[`${colname}`];
            let testValues = data.data.test_data[`${colname}`];
            let tableBody = document.getElementById('forecastTableBody-test');

            let rows = '';
            forecastIndex.forEach((date, index) => {
                const value = forecastValues[index];
                rows += `
                    <tr class="border-b border-gray-200">
                        <td class="py-2 px-4">${date}</td>
                        <td class="py-2 px-4">${value}</td>
                         <td class="py-2 px-4">${testValues[index]}</td>
                          <td class="py-2 px-4">${value - testValues[index]}</td>
                    </tr>
                `;
            });

            tableBody.innerHTML = rows;
        }
    </script>





</body>

</html>
