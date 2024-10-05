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
                                @if ($history)
                                    {!! $history->history !!}
                                @endif
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



        // ---------------------------------------
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
        // ------------------------------------

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
                        saveChatHistory();
                    },
                    error: function(error) {
                        alert("An error occurred. Please try again.");
                    }
                });
            });
        });



        $(document).ready(function() {
            // Fetch and parse JSON data from the server-side
            const jsonData = @json($data); // Server-side rendered data
            const data = JSON.parse(jsonData);

            // Utility function to handle missing values
            const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

            // Clean the data to handle missing values
            const trendData = cleanData(data.trend[`${data.colname}`]);


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
                    name: `${data.colname}`,
                    data: trendData,
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
                            return isNaN(value) ? value : value.toFixed(
                            2); // Safely format only valid numeric values
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
            };

            var chart = new ApexCharts(document.querySelector("#chart1"), options);
            chart.render();
        });
    </script>
@endsection
