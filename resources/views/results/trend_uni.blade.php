@extends('layouts.base')

@section('title', 'Univariate Trend Result')

@section('page-title', 'Univariate Trend Result')





@section('content')
    <div class="container mx-auto my-6 h-screen bg-gray-50"> <!-- Added light gray background -->
        <!-- Layout container with grid -->
        <div class="grid grid-cols-3 gap-4 h-full">

            <!-- Left Column (Graphs and Notes) -->
            <div class="col-span-2 flex flex-col space-y-3 h-full">
                <!-- Graph Section (Top) -->
                <div class="bg-white shadow-md rounded-lg p-1 h-1/2"> <!-- Reduced padding to p-2 -->
                    <div id="chart1"></div> <!-- Placeholder for the graph -->
                </div>


                <!-- Notes Section (Bottom) -->
                <div class="bg-white shadow-md rounded-lg p-3 flex-1 flex flex-col"> <!-- Reduced padding to p-3 -->
                    <h2 class="font-semibold text-gray-700 text-sm">Notes</h2> <!-- Reduced font size -->
                    <!-- Quill Editor Wrapper with scrolling -->
                    <div class="bg-gray- p-2 rounded overflow-y-auto flex-1 text-sm"> <!-- Reduced text size -->
                        <div id="notesEditor" class="h-full"></div> <!-- Make Quill editor take full height -->
                    </div>
                    <input type="hidden" id="notesContent" name="notesContent">
                    <div class="mt-2">
                        <button id="saveNotes"
                            class="bg-blue-500 text-white font-bold py-1 px-3 rounded hover:bg-blue-600 text-sm">
                            <!-- Reduced padding and font size -->
                            Save Notes
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column (Info Card) -->
            <div class="bg-white shadow-md rounded-lg p-3 flex flex-col justify-between h-full overflow-y-auto max">
                <!-- Info Section -->
                <div id="info-card-explanations" class="mb-4 overflow-y-auto max">
                    <p class="text-gray-700 text-sm">Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit.</p>
                    <!-- Reduced font size -->
                </div>
            </div>
        </div>


        <!-- This is for Chat with AI-->
        <button id="chatButton"
            class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-500 focus:outline-none">
            <!-- AI Chat Icon -->
            AI Chat 💬
        </button>

        <div id="chatBox" class="hidden fixed bottom-6 right-6 w-96 h-96 bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Chat Header -->
            <div class="bg-gray-200 border-b p-3 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-700">Chat with AI</h3>
                <button id="closeChat" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Chat Body -->
            <div id="chatMessages" class="p-4 h-64 overflow-y-auto bg-gray-50">
                @if ($history)
                    {!! $history->history !!}
                @else
                    <div id="initial-message" class="text-sm text-gray-600">Welcome! How can I assist you today?</div>
                @endif
            </div>

            <!-- Chat Input -->
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

            // Utility function to handle missing values
            const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

            // Clean the data to handle missing values
            const trendData = cleanData(data.trend[`${data.metadata.colname}`]);
            $('#info-card-explanations').html(data.explanations.response1 + "<br>" + data.explanations.response2 +
                "<br>" +
                data.explanations.response3);

            // Initialize the chart with ApexCharts
            var options = {
                chart: {
                    type: 'line',
                    height: 300,
                    zoom: {
                        enabled: true
                    },
                    toolbar: {
                        show: false,
                    }
                },
                title: {
                    text: 'Trend Result',
                    align: 'left',
                    style: {
                        fontSize: '18px', // Font size of the title
                        color: '#263238' // Color of the title
                    }
                },
                series: [{
                    name: `${data.metadata.colname}`,
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
                        text: `${data.metadata.colname}`,
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
