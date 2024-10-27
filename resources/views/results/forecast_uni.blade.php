@extends('layouts.base')

@section('title', 'Forecast Result')

@section('page-title', 'Forecast Result')


@section('content')
    <div class="container mx-auto my-6 h-screen">
        <!-- Layout container with grid -->
        <div class="grid grid-cols-3 gap-4 h-full">

            <!-- Left Column (Buttons and Graphs) -->
            <div class="col-span-2 flex flex-col space-y-4 h-full">
                <!-- Toggle buttons aligned to the top left -->
                <div class="flex justify-start mb-4 space-x-2">
                    <button id="outsampleForecastBtn"
                        class="bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none">
                        Outsample Forecast
                    </button>
                    <button id="detailedResultBtn"
                        class="bg-white text-blue-500 font-bold py-2 px-4 rounded focus:outline-none border border-blue-500">
                        Detailed Result
                    </button>
                </div>

                <!-- Outsample Forecast Section (Initially visible) -->
                <div id="outsampleForecast" class="flex flex-col space-y-4 flex-1 h-full">
                    <!-- Graph (Top Section) -->
                    <div class="bg-white shadow-md rounded-lg p-4 h-1/2">
                        <div id="chart1"></div>
                    </div>

                    <!-- Notes Section (Bottom Section) -->
                    <div class="bg-white shadow-md rounded-lg p-4 flex-1 flex flex-col">
                        <h2 class="font-semibold text-gray-700">Notes</h2>
                        <div class="bg-white p-2 rounded overflow-y-auto flex-1">
                            <div id="notesEditor" class="h-full"></div>
                        </div>
                        <input type="hidden" id="notesContent" name="notesContent">
                        <div class="mt-4">
                            <button id="saveNotes"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                                Save Notes
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Detailed Result Section (Initially hidden) -->
                <div id="detailedResult" class="space-y-4 hidden">
                    <!-- Graph (Top Section) -->
                    <div class="bg-white shadow-md rounded-lg p-4 h-80">
                        <div id="chart2"></div>
                    </div>

                    <!-- Table of Detailed Results -->
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
                                <!-- Data will be dynamically rendered -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Info Card Section -->
            <div id="infoOutsample"
                class="bg-white shadow-md rounded-lg p-4 flex flex-col justify-between h-full overflow-y-auto max">
                <div class="mb-4">
                    <p id="explanation-paragraph-out" class="text-gray-700 mb-4">Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit.</p>
                    <div class="flex flex-wrap">
                        <div class="w-1/2 mb-2">
                            <div><span class="font-semibold">Time Series Type:</span>
                                <div id="tstype" class="text-gray-600"></div>
                            </div>
                            <div><span class="font-semibold">Frequency:</span>
                                <div id="freq" class="text-gray-600"></div>
                            </div>
                        </div>
                        <div class="w-1/2 mb-2">
                            <div><span class="font-semibold">Forecast Horizon:</span>
                                <div id="steps" class="text-gray-600"></div>
                            </div>
                            <div><span class="font-semibold">Target:</span>
                                <div id="target" class="text-gray-600"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="detailedMetrics" class="hidden bg-white shadow-md rounded-lg p-4 flex flex-col overflow-y-auto max">

                <!-- Explanation Section -->
                <p id="explanation-paragraph-test" class="text-gray-700 mb-4">
                    Detailed explanation of test results.
                </p>

                <!-- Metrics Section -->
                <div class="flex flex-wrap">
                    <div class="w-1/2 mb-2">
                        <div><span class="font-semibold">MAE:</span>
                            <div id="mae" class="text-gray-600"></div>
                        </div>
                        <div><span class="font-semibold">MSE:</span>
                            <div id="mse" class="text-gray-600"></div>
                        </div>
                    </div>
                    <div class="w-1/2 mb-2">
                        <div><span class="font-semibold">RMSE:</span>
                            <div id="rmse" class="text-gray-600"></div>
                        </div>
                        <div><span class="font-semibold">MAPE:</span>
                            <div id="mape" class="text-gray-600"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Chat with AI-->
        <button id="chatButton"
            class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-500 focus:outline-none">
            AI Chat 💬
        </button>

        <div id="chatBox" class="hidden fixed bottom-6 right-6 w-96 h-96 bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="bg-gray-200 border-b p-3 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-700">Chat with AI</h3>
                <button id="closeChat" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="chatMessages" class="p-4 h-64 overflow-y-auto bg-gray-50">
                @if ($history)
                    {!! $history->history !!}
                @else
                    <div id="initial-message" class="text-sm text-gray-600">Welcome! How can I assist you today?</div>
                @endif
            </div>
            <div class="bg-white p-3 border-t flex items-center space-x-2">
                <input type="text" id="chatInput"
                    class="w-full p-2 rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="Type your message...">
                <button id="sendMessage"
                    class="p-2 bg-blue-600 text-white rounded-full hover:bg-blue-500 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Select elements
            const chatButton = document.getElementById('chatButton');
            const chatBox = document.getElementById('chatBox');
            const closeChat = document.getElementById('closeChat');

            // Toggle chat box visibility
            chatButton.addEventListener('click', () => {
                chatBox.classList.toggle('hidden');
            });

            // Close chat box when 'X' is clicked
            closeChat.addEventListener('click', () => {
                chatBox.classList.add('hidden');
            });
        });

        $(document).ready(function() {
            const jsonData = @json($data);
            const data = JSON.parse(jsonData);
            const colname = data.metadata.colname;

            $('#explanation-paragraph-out').html(data.forecast.pred_out_explanation.response1 + "<br>" + data
                .forecast.pred_out_explanation.response2 + "<br>" + data.forecast.pred_out_explanation.response3
            );

            $('#explanation-paragraph-test').html(data.forecast.pred_test_explanation.response1);

            $('#mae').text(data.forecast.metrics.mae);
            $('#mse').text(data.forecast.metrics.mse);
            $('#rmse').text(data.forecast.metrics.rmse);
            $('#mape').text(data.forecast.metrics.mape);

            $('#tstype').text(data.metadata.tstype);
            $('#freq').text(data.metadata.freq);
            $('#steps').text(data.metadata.steps);
            $('#target').text(data.metadata.colname);

            const outsampleBtn = document.getElementById('outsampleForecastBtn');
            const detailedBtn = document.getElementById('detailedResultBtn');
            const outsampleSection = document.getElementById('outsampleForecast');
            const detailedSection = document.getElementById('detailedResult');
            const infoOutsample = document.getElementById('infoOutsample');
            const detailedMetrics = document.getElementById('detailedMetrics');

            outsampleBtn.addEventListener('click', function() {
                outsampleSection.classList.remove('hidden');
                detailedSection.classList.add('hidden');
                infoOutsample.classList.remove('hidden');
                detailedMetrics.classList.add('hidden');
                outsampleBtn.classList.add('bg-blue-500', 'text-white');
                outsampleBtn.classList.remove('bg-white', 'text-blue-500', 'border', 'border-blue-500');
                detailedBtn.classList.remove('bg-blue-500', 'text-white');
                detailedBtn.classList.add('bg-white', 'text-blue-500', 'border', 'border-blue-500');
            });

            detailedBtn.addEventListener('click', function() {
                outsampleSection.classList.add('hidden');
                detailedSection.classList.remove('hidden');
                infoOutsample.classList.add('hidden');
                detailedMetrics.classList.remove('hidden');
                detailedBtn.classList.add('bg-blue-500', 'text-white');
                detailedBtn.classList.remove('bg-white', 'text-blue-500', 'border', 'border-blue-500');
                outsampleBtn.classList.remove('bg-blue-500', 'text-white');
                outsampleBtn.classList.add('bg-white', 'text-blue-500', 'border', 'border-blue-500');
            });
        });


        $(document).ready(function() {
            // Initialize Quill editor with basic options
            var quill = new Quill('#notesEditor', {
                theme: 'snow',

            });


            @if ($note)
                quill.root.innerHTML = `{!! $note->content !!}`;
            @endif




            // Save Notes button click event
            $('#saveNotes').click(function() {
                // Get the Quill content in Delta format (optional, if needed)
                var delta = quill.getContents();

                console.log(delta);

                // Get the Quill content in HTML format to store in the backend
                var htmlContent = quill.root.innerHTML;

                // Store the formatted content in the hidden input field
                $('#notesContent').val(htmlContent);

                // Optionally, send an AJAX request to store the content in the backend
                $.ajax({
                    url: '{{ route('notes.save') }}', // Replace with your actual route
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Add CSRF token here
                    },
                    data: {
                        notesContent: htmlContent, // Send the HTML formatted content
                        file_assoc_id: '{{ $file_assoc_id }}',
                    },
                    success: function(response) {

                        alert(`${response.message}`);
                    },
                    error: function(error) {
                        alert('An error occurred. Please try again.');
                    }
                });




            });
        });

        $(document).ready(function() {
            // Send message to Laravel when 'Send' button is clicked
            $('#sendMessage').click(function() {
                let message = $('#chatInput').val().trim();

                if (message === '') {
                    alert("Please enter a message.");
                    return;
                }

                $('#initial-message').remove();

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
                        saveChatHistory();
                    },
                    error: function(error) {
                        alert("An error occurred. Please try again.");
                    }
                });
            });



            function saveChatHistory() {
                let chatHistory = $('#chatMessages').html(); // Get the entire chat HTML

                // Send updated chat history to Laravel
                $.ajax({
                    url: '{{ route('llm.save') }}', // Laravel route for saving chat history
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    data: {
                        history: chatHistory, // Send the entire chat HTML as history
                        file_assoc_id: '{{ $file_assoc_id }}',
                    },
                    success: function(response) {
                        console.log("Chat history saved.");
                    },
                    error: function(error) {
                        console.log("Error saving chat history:", error);
                    }
                });
            }

        });

        $(document).ready(function() {
            // Fetch and parse JSON data from the server-side
            const jsonData = @json($data); // Server-side rendered data
            const data = JSON.parse(jsonData);
            const colname = data.metadata.colname;

            renderChart1();
            renderChart2();
            // renderForecastTable_out();
            renderForecastTable_test();

            $('#forecastTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": false, // Remove the search box
                "lengthChange": true // Remove the entries dropdown
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
                    // title: {
                    //     text: 'Forecast Result',
                    //     align: 'left',
                    //     style: {
                    //         fontSize: '18px', // Font size of the title
                    //         color: '#263238' // Color of the title
                    //     }
                    // },
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
                        width: 2,
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
                    title: {
                        text: 'Forecast Result in Test Set',
                        align: 'left',
                        style: {
                            fontSize: '18px', // Font size of the title
                            color: '#263238' // Color of the title
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
                        width: 2,
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

                // Calculate the min and max of actual values for normalization
                const minActualValue = Math.min(...testValues);
                const maxActualValue = Math.max(...testValues);
                const range = maxActualValue - minActualValue;

                forecastIndex.forEach((date, index) => {
                    const value = forecastValues[index];
                    const actualValue = testValues[index];
                    const error = value - actualValue;
                    const absoluteError = Math.abs(error);

                    // Normalize the absolute error based on the range of actual values
                    const normalizedError = range > 0 ? (absoluteError / range) :
                        0; // Avoid division by zero
                    const colorIntensity = Math.min(255, Math.max(0, normalizedError *
                        255)); // Scale to 0-255

                    // Set the color to a gradient from white (no error) to red (maximum error)
                    const errorColor =
                        `rgba(255, ${255 - colorIntensity}, ${255 - colorIntensity}, 0.5)`; // Gradient from white to red

                    rows += `
            <tr class="border-b border-gray-200">
                <td class="py-2 px-4">${date}</td>
                <td class="py-2 px-4">${value}</td>
                <td class="py-2 px-4">${actualValue}</td>
                <td class="py-2 px-4" style="background-color: ${errorColor};">${error.toFixed(2)}</td>
            </tr>
        `;
                });

                tableBody.innerHTML = rows;
            }


        });
    </script>
@endsection
