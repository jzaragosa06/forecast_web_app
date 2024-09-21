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

    {{-- <div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div>
                        <div id="chart1"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore
                            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                            nisi ut
                            aliquip ex ea commodo consequat.
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Time Series Type: <div id="tstype">

                            </div>
                            Frequency: <div id="freq"></div>

                        </div>
                        <div class="col-md-6">
                            Forecast Horizon: <div id="steps"></div>
                            Target: <div id="target"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="detailed_result_button" class="col-md-6">
                            <button class="btn btn-primary">Detailed Result</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary">Converse with AI</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="detailed_result" style="display: none">
            <div class="row">
                <div class="col-md-8 ">
                    <div id="chart2"></div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore
                            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                            nisi
                            ut
                            aliquip ex ea commodo consequat.
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            MAE: <div id = "mae"></div>
                            MSE: <div id = "mse"></div>
                        </div>
                        <div class="col-md-6">
                            RSME: <div id = "rsme"></div>
                            MAPE: <div id= "mape"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="bg-light border rounded p-5 mt-3" style="height: 500px;">
                        <!-- Placeholder for middle box content -->
                    </div>
                </div>
                <div class="col-md-6">
                    <table>
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
        </div>
    </div> --}}


    {{-- <div class="container mx-auto p-4">
        <div class="flex flex-wrap">
            <div class="w-full md:w-2/3 p-4">
                <div class="bg-white shadow rounded-lg p-4">
                    <div id="chart1"></div>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-4">
                <div class="bg-white shadow rounded-lg p-4 flex flex-col">
                    <div class="mb-4">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-1/2 mb-2">
                            <span class="font-semibold">Time Series Type:</span>
                            <div id="tstype" class="text-gray-600"></div>
                        </div>
                        <div class="w-1/2 mb-2">
                            <span class="font-semibold">Frequency:</span>
                            <div id="freq" class="text-gray-600"></div>
                        </div>
                        <div class="w-1/2 mb-2">
                            <span class="font-semibold">Forecast Horizon:</span>
                            <div id="steps" class="text-gray-600"></div>
                        </div>
                        <div class="w-1/2 mb-2">
                            <span class="font-semibold">Target:</span>
                            <div id="target" class="text-gray-600"></div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-4">
                        <div id="detailed_result_button" class="w-1/2 pr-2">
                            <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Detailed Result</button>
                        </div>
                        <div class="w-1/2 pl-2">
                            <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Converse with AI</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="detailed_result" class="hidden">
            <div class="flex flex-wrap">
                <div class="w-full md:w-2/3 p-4">
                    <div class="bg-white shadow rounded-lg p-4">
                        <div id="chart2"></div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-4">
                    <div class="bg-white shadow rounded-lg p-4 flex flex-col">
                        <div class="mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-1/2 mb-2">
                                <span class="font-semibold">MAE:</span>
                                <div id="mae" class="text-gray-600"></div>
                            </div>
                            <div class="w-1/2 mb-2">
                                <span class="font-semibold">MSE:</span>
                                <div id="mse" class="text-gray-600"></div>
                            </div>
                            <div class="w-1/2 mb-2">
                                <span class="font-semibold">RSME:</span>
                                <div id="rsme" class="text-gray-600"></div>
                            </div>
                            <div class="w-1/2 mb-2">
                                <span class="font-semibold">MAPE:</span>
                                <div id="mape" class="text-gray-600"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-1/2 p-4">
                    <div class="bg-gray-100 border rounded-lg p-5 h-96">
                        <!-- Placeholder for middle box content -->
                    </div>
                </div>
                <div class="w-1/2 p-4">
                    <div class="bg-white shadow rounded-lg">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">Date</th>
                                    <th class="border px-4 py-2">Forecasted Value</th>
                                    <th class="border px-4 py-2">True Value</th>
                                    <th class="border px-4 py-2">Error</th>
                                </tr>
                            </thead>
                            <tbody id="forecastTableBody-test">
                                <!-- Table rows will go here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="container mx-auto my-6">
        <div class="flex flex-wrap">
            <div class="w-full md:w-2/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div id="chart1"></div>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="mb-4">
                        <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-1/2 mb-2">
                            <div>
                                <span class="font-semibold">Time Series Type:</span>
                                <div id="tstype" class="text-gray-600"></div>
                            </div>
                            <div>
                                <span class="font-semibold">Frequency:</span>
                                <div id="freq" class="text-gray-600"></div>
                            </div>
                        </div>
                        <div class="w-1/2 mb-2">
                            <div>
                                <span class="font-semibold">Forecast Horizon:</span>
                                <div id="steps" class="text-gray-600"></div>
                            </div>
                            <div>
                                <span class="font-semibold">Target:</span>
                                <div id="target" class="text-gray-600"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-4">
                        <div id="detailed_result_button" class="w-1/2 pr-2">
                            <button
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Detailed
                                Result</button>
                        </div>
                        <div class="w-1/2 pl-2">
                            <button
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Converse
                                with AI</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="detailed_result" class="hidden">
            <div class="flex flex-wrap">
                <div class="w-full md:w-2/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <div id="chart2"></div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <div class="mb-4">
                            <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-1/2 mb-2">
                                <div>
                                    <span class="font-semibold">MAE:</span>
                                    <div id="mae" class="text-gray-600"></div>
                                </div>
                                <div>
                                    <span class="font-semibold">MSE:</span>
                                    <div id="mse" class="text-gray-600"></div>
                                </div>
                            </div>
                            <div class="w-1/2 mb-2">
                                <div>
                                    <span class="font-semibold">RSME:</span>
                                    <div id="rsme" class="text-gray-600"></div>
                                </div>
                                <div>
                                    <span class="font-semibold">MAPE:</span>
                                    <div id="mape" class="text-gray-600"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-1/2 p-4">
                    <div class="bg-gray-50 border rounded-lg p-5 h-96">
                        <!-- Placeholder for middle box content -->
                    </div>
                </div>
                <div class="w-1/2 p-4">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Date</th>
                                <th class="border px-4 py-2">Forecasted Value</th>
                                <th class="border px-4 py-2">True Value</th>
                                <th class="border px-4 py-2">Error</th>
                            </tr>
                        </thead>
                        <tbody id="forecastTableBody-test">
                            <!-- Table rows will go here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- <div class="container mx-auto my-6">
        <div class="flex flex-wrap">
            <div class="w-full md:w-2/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4 h-full">
                    <div id="chart1"></div>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4 h-full">
                    <div class="mb-4">
                        <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-1/2 mb-2">
                            <div>
                                <span class="font-semibold">Time Series Type:</span>
                                <div id="tstype" class="text-gray-600"></div>
                            </div>
                            <div>
                                <span class="font-semibold">Frequency:</span>
                                <div id="freq" class="text-gray-600"></div>
                            </div>
                        </div>
                        <div class="w-1/2 mb-2">
                            <div>
                                <span class="font-semibold">Forecast Horizon:</span>
                                <div id="steps" class="text-gray-600"></div>
                            </div>
                            <div>
                                <span class="font-semibold">Target:</span>
                                <div id="target" class="text-gray-600"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-4">
                        <div id="detailed_result_button" class="w-1/2 pr-2">
                            <button
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Detailed
                                Result</button>
                        </div>
                        <div class="w-1/2 pl-2">
                            <button
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Converse
                                with AI</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="detailed_result" class="hidden">
            <div class="flex flex-wrap">
                <div class="w-full md:w-2/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full">
                        <div id="chart2"></div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full">
                        <div class="mb-4">
                            <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-1/2 mb-2">
                                <div>
                                    <span class="font-semibold">MAE:</span>
                                    <div id="mae" class="text-gray-600"></div>
                                </div>
                                <div>
                                    <span class="font-semibold">MSE:</span>
                                    <div id="mse" class="text-gray-600"></div>
                                </div>
                            </div>
                            <div class="w-1/2 mb-2">
                                <div>
                                    <span class="font-semibold">RSME:</span>
                                    <div id="rsme" class="text-gray-600"></div>
                                </div>
                                <div>
                                    <span class="font-semibold">MAPE:</span>
                                    <div id="mape" class="text-gray-600"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-1/2 p-4">
                    <div class="bg-gray-50 border rounded-lg p-5 h-96">
                        <!-- Placeholder for middle box content -->
                    </div>
                </div>
                <div class="w-1/2 p-4">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <table id="forecastTable" class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">Date</th>
                                    <th class="border px-4 py-2">Forecasted Value</th>
                                    <th class="border px-4 py-2">True Value</th>
                                    <th class="border px-4 py-2">Error</th>
                                </tr>
                            </thead>
                            <tbody id="forecastTableBody-test">
                                <!-- Example rows (rendered dynamically) -->
                                <tr>
                                    <td class="border px-4 py-2">2024-01-01</td>
                                    <td class="border px-4 py-2">100</td>
                                    <td class="border px-4 py-2">90</td>
                                    <td class="border px-4 py-2">10</td>
                                </tr>
                                <!-- Add more example rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}



    <div class="container mx-auto my-6">
        <div class="flex flex-wrap">
            <div class="w-full md:w-2/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4 h-full">
                    <div id="chart1"></div>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4 h-full">
                    <div class="mb-4">
                        <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-1/2 mb-2">
                            <div>
                                <span class="font-semibold">Time Series Type:</span>
                                <div id="tstype" class="text-gray-600"></div>
                            </div>
                            <div>
                                <span class="font-semibold">Frequency:</span>
                                <div id="freq" class="text-gray-600"></div>
                            </div>
                        </div>
                        <div class="w-1/2 mb-2">
                            <div>
                                <span class="font-semibold">Forecast Horizon:</span>
                                <div id="steps" class="text-gray-600"></div>
                            </div>
                            <div>
                                <span class="font-semibold">Target:</span>
                                <div id="target" class="text-gray-600"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-4">
                        {{-- <div id="detailed_result_button" class="w-1/2 pr-2">
                            <button
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Detailed
                                Result</button>
                        </div> --}}
                        <div id="detailed_result_button" class="w-1/2 pr-2">
                            <button id="toggleButton"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                                Detailed Result</button>
                        </div>
                        <div class="w-1/2 pl-2">
                            <button
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Converse
                                with AI</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="detailed_result" style="display: none;">
            <div class="flex flex-wrap">
                <div class="w-full md:w-2/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full">
                        <div id="chart2"></div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full">
                        <div class="mb-4">
                            <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-1/2 mb-2">
                                <div>
                                    <span class="font-semibold">MAE:</span>
                                    <div id="mae" class="text-gray-600"></div>
                                </div>
                                <div>
                                    <span class="font-semibold">MSE:</span>
                                    <div id="mse" class="text-gray-600"></div>
                                </div>
                            </div>
                            <div class="w-1/2 mb-2">
                                <div>
                                    <span class="font-semibold">RSME:</span>
                                    <div id="rsme" class="text-gray-600"></div>
                                </div>
                                <div>
                                    <span class="font-semibold">MAPE:</span>
                                    <div id="mape" class="text-gray-600"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-2/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-5">
                        <table id="forecastTable" class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">Date</th>
                                    <th class="border px-4 py-2">Forecasted Value</th>
                                    <th class="border px-4 py-2">True Value</th>
                                    <th class="border px-4 py-2">Error</th>
                                </tr>
                            </thead>
                            <tbody id="forecastTableBody-test">
                                <!-- Example rows (rendered dynamically) -->
                                <tr>
                                    <td class="border px-4 py-2">2024-01-01</td>
                                    <td class="border px-4 py-2">100</td>
                                    <td class="border px-4 py-2">90</td>
                                    <td class="border px-4 py-2">10</td>
                                </tr>
                                <!-- Add more example rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="w-1/3 p-4">
                    <div class="bg-gray-50 border rounded-lg p-5 h-full">
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





        // JavaScript to toggle the detailed result section visibility
        // const detailedResultButton = document.getElementById("detailed_result_button");
        // const detailedResultDiv = document.getElementById("detailed_result");

        // detailedResultButton.addEventListener("click", function() {
        //     if (detailedResultDiv.style.display === "none") {
        //         detailedResultDiv.style.display = "block";
        //         detailedResultButton.textContent = "Hide Detailed Result";
        //     } else {
        //         detailedResultDiv.style.display = "none";
        //         detailedResultButton.textContent = "Show Detailed Result";
        //     }
        // });

        const detailedResultButton = document.getElementById("detailed_result_button");
        const detailedResultDiv = document.getElementById("detailed_result");

        detailedResultButton.addEventListener("click", function() {
            // if (detailedResultDiv.style.display === "none" || detailedResultDiv.style.display === "") {
            //     detailedResultDiv.style.display = "block";
            //     detailedResultButton.textContent = "Hide Detailed Result";
            //     detailedResultButton.classList.remove("bg-blue-500");
            //     detailedResultButton.classList.add("bg-red-500"); // Change color when active
            // } else {
            //     detailedResultDiv.style.display = "none";
            //     detailedResultButton.textContent = "Show Detailed Result";
            //     detailedResultButton.classList.remove("bg-red-500");
            //     detailedResultButton.classList.add("bg-blue-500"); // Revert color
            // }

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

{{-- 
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

  


    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.esm.min.mjs';
        mermaid.initialize({
            startOnLoad: true
        });
    </script>



    <title>Document</title>
</head>

<body>

    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div>
                        <div id="chart1"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore
                            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                            nisi ut
                            aliquip ex ea commodo consequat.
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Time Series Type: <div id="tstype">

                            </div>
                            Frequency: <div id="freq"></div>

                        </div>
                        <div class="col-md-6">
                            Forecast Horizon: <div id="steps"></div>
                            Target: <div id="target"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="detailed_result_button" class="col-md-6">
                            <button class="btn btn-primary">Detailed Result</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary">Converse with AI</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div id="detailed_result" style="display: none">
            <div class="row">
                <div class="col-md-8 ">
                    <div id="chart2"></div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore
                            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                            nisi
                            ut
                            aliquip ex ea commodo consequat.
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            MAE: <div id = "mae"></div>
                            MSE: <div id = "mse"></div>
                        </div>
                        <div class="col-md-6">
                            RSME: <div id = "rsme"></div>
                            MAPE: <div id= "mape"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <pre class="mermaid">
                        graph TD
                        A[Dataset]:::hoverable --> B[Training dataset]
                        A --> C[Test dataset]
                        B --> D[Model]
                        C --> E[Evaluate]
                        D --> E
                        E -->|Error acceptable?| F{Error acceptable?}
                        F -->|Yes| G[Forecast]
                        F -->|No| H[Retrain Model]
                        H --> D
                        click A "https://example.com/dataset" "This is the dataset"
                        click B "https://example.com/training" "This is the training dataset"
                        click C "https://example.com/test" "This is the test dataset"
                        click D "https://example.com/model" "This is the model"
                        click E "https://example.com/evaluate" "This is the evaluation step"
                        click F "https://example.com/decision" "This is the decision point"
                        click G "https://example.com/forecast" "This is the forecasting step"
                        click H "https://example.com/retrain" "This is the retraining step"
                    </pre>






                </div>
                <div class="col-md-6">
                    <table>
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
        </div>
    </div>

    <script>
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

</html> --}}
