{{-- @extends('layouts.base')

@section('title', 'Univariate Trend Result')

@section('page-title', 'Univariate Trend Result')


@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <!-- Card Container -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Chart Area -->
                <div class="col-span-2">
                    <div id="chart1"></div>
                </div>

                <!-- Info and SMA Description Area -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-gray-700 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. ...</p>

                    <!-- Centered Icons with Flexbox -->
                    <div class="flex justify-center space-x-4">
                        <!-- SMA Icons -->
                        <div class="relative group">
                            <!-- Icon for SMA 5 -->
                            <div
                                class="w-6 h-6 bg-[#546E7A] rounded-full flex items-center justify-center text-white cursor-pointer">
                                5
                            </div>
                            <span
                                class="absolute opacity-0 group-hover:opacity-100 transition-opacity bg-gray-800 text-white text-xs rounded-lg py-1 px-2 bottom-full mb-2 left-1/2 transform -translate-x-1/2">
                                SMA 5 - Short-term trend (5-day moving average).
                            </span>
                        </div>

                        <div class="relative group">
                            <!-- Icon for SMA 10 -->
                            <div
                                class="w-6 h-6 bg-[#1E90FF] rounded-full flex items-center justify-center text-white cursor-pointer">
                                10
                            </div>
                            <span
                                class="absolute opacity-0 group-hover:opacity-100 transition-opacity bg-gray-800 text-white text-xs rounded-lg py-1 px-2 bottom-full mb-2 left-1/2 transform -translate-x-1/2">
                                SMA 10 - Mid-term trend (10-day moving average).
                            </span>
                        </div>

                        <div class="relative group">
                            <!-- Icon for SMA 20 -->
                            <div
                                class="w-6 h-6 bg-[#00E396] rounded-full flex items-center justify-center text-white cursor-pointer">
                                20
                            </div>
                            <span
                                class="absolute opacity-0 group-hover:opacity-100 transition-opacity bg-gray-800 text-white text-xs rounded-lg py-1 px-2 bottom-full mb-2 left-1/2 transform -translate-x-1/2">
                                SMA 20 - Long-term trend (20-day moving average).
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="chatContainer" class="mt-6">
            <div class="flex flex-wrap">
                <!-- Chat Dialog Section -->
                <div class="w-full md:w-1/2 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full border border-gray-200 flex flex-col">
                        <div class="mb-4 flex-grow">
                            <h2 class="font-semibold text-gray-700">Chat with AI</h2>
                            <div id="chatMessages" class="h-64 bg-gray-100 p-4 rounded overflow-y-auto">
                                <!-- Chat messages go here -->
                            </div>
                        </div>

                        <!-- Chat input and button aligned on the same row -->
                        <div class="flex mt-4">
                            <input type="text" id="chatInput"
                                class="w-full p-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Type a message..." />
                            <button id="sendMessage"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded-r hover:bg-blue-600">
                                Send
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Notes Section -->
                <div class="w-full md:w-1/2 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full border border-gray-200">
                        <h2 class="font-semibold text-gray-700 mb-4">Notes</h2>
                        <!-- Notes editor with same height as chat -->
                        <div class="h-64 bg-gray-100 p-4 rounded overflow-y-auto" id="notesEditor"></div>
                        <input type="hidden" id="notesContent" name="notesContent">

                        <!-- Save button aligned with the input field -->
                        <div class="flex mt-4">
                            <button id="saveNotes"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                                Save Notes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Quill editor with basic options
            var quill = new Quill('#notesEditor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'], // Basic formatting
                        [{
                            'background': []
                        }], // Highlighting
                        [{
                            'header': [1, 2, 3, false]
                        }], // Header size
                        ['clean'] // Clear formatting
                    ]
                }
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



        // ------------------------------------

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



        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);

        // Utility function to handle missing values
        const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

        // Clean the data to handle missing values
        const originalData = cleanData(data.trend[`${data.colname}`]);
        const sma5Data = cleanData(data.trend[`${data.colname}_sma_5`]);
        const sma10Data = cleanData(data.trend[`${data.colname}_sma_10`]);
        const sma20Data = cleanData(data.trend[`${data.colname}_sma_20`]);

        // Initialize the chart with ApexCharts
        var options = {
            chart: {
                type: 'line',
                height: 350,
                zoom: {
                    enabled: true
                },
                toolbar: {
                    show: false,
                }
            },
            series: [{
                name: 'Original Value',
                data: originalData,
            }, {
                name: 'SMA 5',
                data: sma5Data,
            }, {
                name: 'SMA 10',
                data: sma10Data,
            }, {
                name: 'SMA 20',
                data: sma20Data,
            }],
            xaxis: {
                categories: data.trend.index, // x-axis labels (dates/times)
                title: {
                    text: 'Date/Time'
                },
                type: 'datetime',
            },
            yaxis: {
                title: {
                    text: `${data.colname}`,
                },
                labels: {
                    formatter: function(value) {
                        // Check if the value is a valid number before applying toFixed
                        return isNaN(value) ? value : value.toFixed(2); // Safely format only valid numeric values
                    }
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            markers: {
                size: 0
            },
            tooltip: {
                enabled: true,
                shared: true,
                intersect: false
            },
            colors: ['#FF4560', '#546E7A', '#1E90FF', '#00E396'] // Corresponding colors
        };

        var chart = new ApexCharts(document.querySelector("#chart1"), options);
        chart.render();
    </script>
@endsection --}}


@extends('layouts.base')

@section('title', 'Univariate Trend Result')

@section('page-title', 'Univariate Trend Result')


@section('content')
    <div>
        <!-- Card Container -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Chart Area -->
                <div class="col-span-2">
                    <div id="chart1"></div>
                </div>

                <!-- Info and SMA Description Area -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-gray-700 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. ...</p>

                    <!-- Centered Icons with Flexbox -->
                    <div class="flex justify-center space-x-4">
                        <!-- SMA Icons -->
                        <div class="relative group">
                            <!-- Icon for SMA 5 -->
                            <div
                                class="w-6 h-6 bg-[#546E7A] rounded-full flex items-center justify-center text-white cursor-pointer">
                                5
                            </div>
                            <span
                                class="absolute opacity-0 group-hover:opacity-100 transition-opacity bg-gray-800 text-white text-xs rounded-lg py-1 px-2 bottom-full mb-2 left-1/2 transform -translate-x-1/2">
                                SMA 5 - Short-term trend (5-day moving average).
                            </span>
                        </div>

                        <div class="relative group">
                            <!-- Icon for SMA 10 -->
                            <div
                                class="w-6 h-6 bg-[#1E90FF] rounded-full flex items-center justify-center text-white cursor-pointer">
                                10
                            </div>
                            <span
                                class="absolute opacity-0 group-hover:opacity-100 transition-opacity bg-gray-800 text-white text-xs rounded-lg py-1 px-2 bottom-full mb-2 left-1/2 transform -translate-x-1/2">
                                SMA 10 - Mid-term trend (10-day moving average).
                            </span>
                        </div>

                        <div class="relative group">
                            <!-- Icon for SMA 20 -->
                            <div
                                class="w-6 h-6 bg-[#00E396] rounded-full flex items-center justify-center text-white cursor-pointer">
                                20
                            </div>
                            <span
                                class="absolute opacity-0 group-hover:opacity-100 transition-opacity bg-gray-800 text-white text-xs rounded-lg py-1 px-2 bottom-full mb-2 left-1/2 transform -translate-x-1/2">
                                SMA 20 - Long-term trend (20-day moving average).
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="chatContainer" class="mt-6">
            <div class="flex flex-wrap">
                <!-- Chat Dialog Section -->
                <div class="w-full md:w-1/2 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full border border-gray-200 flex flex-col">
                        <div class="mb-4 flex-grow">
                            <h2 class="font-semibold text-gray-700">Chat with AI</h2>
                            <div id="chatMessages" class="h-64 bg-gray-100 p-4 rounded overflow-y-auto">
                                <!-- Chat messages go here -->
                            </div>
                        </div>

                        <!-- Chat input and button aligned on the same row -->
                        <div class="flex mt-4">
                            <input type="text" id="chatInput"
                                class="w-full p-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Type a message..." />
                            <button id="sendMessage"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded-r hover:bg-blue-600">
                                Send
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Notes Section -->
                <div class="w-full md:w-1/2 p-4">
                    <div class="bg-white shadow-md rounded-lg p-4 h-full border border-gray-200">
                        <h2 class="font-semibold text-gray-700 mb-4">Notes</h2>
                        <!-- Notes editor with same height as chat -->
                        <div class="h-64 bg-gray-100 p-4 rounded overflow-y-auto" id="notesEditor"></div>
                        <input type="hidden" id="notesContent" name="notesContent">

                        <!-- Save button aligned with the input field -->
                        <div class="flex mt-4">
                            <button id="saveNotes"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                                Save Notes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Quill editor with basic options
            var quill = new Quill('#notesEditor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'], // Basic formatting
                        [{
                            'background': []
                        }], // Highlighting
                        [{
                            'header': [1, 2, 3, false]
                        }], // Header size
                        ['clean'] // Clear formatting
                    ]
                }
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



        // ------------------------------------

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
                        about: "trend",
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



        // Fetch and parse JSON data from the server-side
        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);

        // Utility function to handle missing values
        const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

        // Clean the data to handle missing values
        const originalData = cleanData(data.trend[`${data.colname}`]);
        const sma5Data = cleanData(data.trend[`${data.colname}_sma_5`]);
        const sma10Data = cleanData(data.trend[`${data.colname}_sma_10`]);
        const sma20Data = cleanData(data.trend[`${data.colname}_sma_20`]);

        // Initialize the chart with ApexCharts
        var options = {
            chart: {
                type: 'line',
                height: 350,
                zoom: {
                    enabled: true
                },
                toolbar: {
                    show: false,
                }
            },
            series: [{
                name: 'Original Value',
                data: originalData,
            }, {
                name: 'SMA 5',
                data: sma5Data,
            }, {
                name: 'SMA 10',
                data: sma10Data,
            }, {
                name: 'SMA 20',
                data: sma20Data,
            }],
            xaxis: {
                categories: data.trend.index, // x-axis labels (dates/times)
                title: {
                    text: 'Date/Time'
                },
                type: 'datetime',
            },
            yaxis: {
                title: {
                    text: `${data.colname}`,
                },
                labels: {
                    formatter: function(value) {
                        // Check if the value is a valid number before applying toFixed
                        return isNaN(value) ? value : value.toFixed(2); // Safely format only valid numeric values
                    }
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            markers: {
                size: 0
            },
            tooltip: {
                enabled: true,
                shared: true,
                intersect: false
            },
            colors: ['#FF4560', '#546E7A', '#1E90FF', '#00E396'] // Corresponding colors
        };

        var chart = new ApexCharts(document.querySelector("#chart1"), options);
        chart.render();
    </script>
@endsection
