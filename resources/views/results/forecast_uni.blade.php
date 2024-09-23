{{-- @extends('layouts.base')

@section('title', 'Univariate Forecast')

@section('page-title', 'Manage Results')


@section('content')

    <div class="container mx-auto my-6">


        <div class="flex flex-wrap md:flex-nowrap">
            <div class="w-full md:w-2/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4 h-full">
                    <div id="chart1"></div>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4 h-full">
                    <div class="mb-4">
                        <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                        <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
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
                            <button id="toggleButton"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                                Detailed Result
                            </button>
                        </div>
                        <div class="w-1/2 pl-2">
                            <button id="toggleChatButton"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                                Converse with AI
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <!-- Chat Container -->
        <div id="chatContainer" class="hidden mt-6">
            <div class="flex flex-wrap">
                <!-- Chat Dialog Section (col-4 in Bootstrap analogy, w-1/3 in Tailwind) -->
                <div class="w-full md:w-1/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full">
                        <div class="mb-4">
                            <h2 class="font-semibold text-gray-700">Chat with AI</h2>
                            <div class="h-64 bg-gray-100 p-4 rounded overflow-y-auto" id="chatMessages">
                                <!-- Chat messages go here -->
                            </div>
                        </div>
                        <div class="mt-4">
                            <input type="text" id="chatInput" class="w-full p-2 border rounded"
                                placeholder="Type a message..." />
                            <button id="sendMessage"
                                class="mt-2 bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 w-full">
                                Send
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Chat History Section (col-8 in Bootstrap analogy, w-2/3 in Tailwind) -->
                <div class="w-full md:w-2/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full">
                        <h2 class="font-semibold text-gray-700 mb-4">Previous Chats</h2>
                        <div class="h-64 bg-gray-100 p-4 rounded overflow-y-auto" id="chatHistory">
                            <!-- History of chat messages will be shown here -->
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
                    <div class="bg-gray-300 border rounded-lg p-5 h-full">
                        <!-- Placeholder for middle box content -->
                    </div>
                </div>
            </div>

        </div>
    </div>





@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#forecastTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": false, // Remove the search box
                "lengthChange": false // Remove the entries dropdown
            });
        });




        const toggleChatButton = document.getElementById("toggleChatButton");
        const chatContainer = document.getElementById("chatContainer");

        toggleChatButton.addEventListener("click", function() {
            if (chatContainer.classList.contains("hidden")) {
                chatContainer.classList.remove("hidden");
                toggleChatButton.textContent = "Hide Chat";
                toggleChatButton.classList.remove("bg-blue-500", "hover:bg-blue-600");
                toggleChatButton.classList.add("bg-red-500", "hover:bg-red-600");
            } else {
                chatContainer.classList.add("hidden");
                toggleChatButton.textContent = "Converse with AI";
                toggleChatButton.classList.remove("bg-red-500", "hover:bg-red-600");
                toggleChatButton.classList.add("bg-blue-500", "hover:bg-blue-600");
            }
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
                    height: 300,
                    toolbar: {
                        show: false,
                    }
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
                    height: 300,
                    toolbar: {
                        show: false,
                    }
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
@endsection --}}


@extends('layouts.base')

@section('title', 'Univariate Forecast')

@section('page-title', 'Manage Results')


@section('content')

    <div class="container mx-auto my-6">


        <div class="flex flex-wrap md:flex-nowrap">
            <div class="w-full md:w-2/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4 h-full">
                    <div id="chart1"></div>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-4">
                <div class="bg-white shadow-md rounded-lg p-4 h-full">
                    <div class="mb-4">
                        <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                        <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
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
                            <button id="toggleButton"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                                Detailed Result
                            </button>
                        </div>
                        <div class="w-1/2 pl-2">
                            <button id="toggleChatButton"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                                Converse with AI
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <!-- Chat Container -->
        <div id="chatContainer" class="hidden mt-6">
            <div class="flex flex-wrap">
                <!-- Chat Dialog Section (col-4 in Bootstrap analogy, w-1/3 in Tailwind) -->
                <div class="w-full md:w-1/2 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full">
                        <div class="mb-4">
                            <h2 class="font-semibold text-gray-700">Chat with AI</h2>
                            <div id="chatMessages" class="h-64 bg-gray-100 p-4 rounded overflow-y-auto" id="chatMessages">
                                <!-- Chat messages go here -->
                            </div>
                        </div>

                        <div class="flex">
                            <input type="text" id="chatInput" class="w-full p-2 border rounded-l"
                                placeholder="Type a message..." />
                            <button id="sendMessage"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded-r hover:bg-blue-600">
                                Send
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Notes Section (col-8 in Bootstrap analogy, w-2/3 in Tailwind) -->
                <div class="w-full md:w-1/2 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full">
                        <h2 class="font-semibold text-gray-700 mb-4">Notes</h2>
                        <div class="h-64 bg-gray-100 p-4 rounded overflow-y-auto" id="chatHistory">
                            <!-- User can Add Notes Here -->
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
                    <div class="bg-gray-300 border rounded-lg p-5 h-full">
                        <!-- Placeholder for middle box content -->
                    </div>
                </div>
            </div>

        </div>
    </div>





@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Send message to Laravel when 'Send' button is clicked
            $('#sendMessage').click(function() {
                let message = $('#chatInput').val().trim();

                if (message === '') {
                    alert("Please enter a message.");
                    return;
                }

                // Append the question (user's message) to the chat container
                $('#chatMessages').append(`
                    <div class="flex justify-end mb-4">
                        <div class="bg-blue-500 text-white p-3 rounded-lg max-w-xs w-auto shadow">
                            <p>${message}</p>
                        </div>
                    </div>
                `);

                // Clear input field after sending
                $('#chatInput').val('');


                // Send the message to the Laravel controller using AJAX
                $.ajax({
                    url: '{{ route('llm.ask') }}', // Laravel route
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Add CSRF token here
                    },
                    data: {
                        message: message,
                        about: "forecast",
                    },
                    success: function(response) {
                        console.log(response);
                        console.log(response.response);
                        console.log(message);


                        // Append the AI's response to the chat container
                        $('#chatMessages').append(`
                            <div class="flex justify-start mb-4">
                                <div class="bg-gray-200 text-gray-700 p-3 rounded-lg max-w-xs w-auto shadow">
                                    <p>${response.response}</p>
                                </div>
                            </div>
                        `);

                        // Scroll to the bottom of the chat
                        $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
                    },
                    error: function(error) {
                        alert("An error occurred. Please try again.");
                    }
                });
            });
        });




        $(document).ready(function() {
            $('#forecastTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": false, // Remove the search box
                "lengthChange": false // Remove the entries dropdown
            });
        });

        const toggleChatButton = document.getElementById("toggleChatButton");
        const chatContainer = document.getElementById("chatContainer");

        toggleChatButton.addEventListener("click", function() {
            if (chatContainer.classList.contains("hidden")) {
                chatContainer.classList.remove("hidden");
                toggleChatButton.textContent = "Hide Chat";
                toggleChatButton.classList.remove("bg-blue-500", "hover:bg-blue-600");
                toggleChatButton.classList.add("bg-red-500", "hover:bg-red-600");
            } else {
                chatContainer.classList.add("hidden");
                toggleChatButton.textContent = "Converse with AI";
                toggleChatButton.classList.remove("bg-red-500", "hover:bg-red-600");
                toggleChatButton.classList.add("bg-blue-500", "hover:bg-blue-600");
            }
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
                    height: 300,
                    toolbar: {
                        show: false,
                    }
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
                    height: 300,
                    toolbar: {
                        show: false,
                    }
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
@endsection
