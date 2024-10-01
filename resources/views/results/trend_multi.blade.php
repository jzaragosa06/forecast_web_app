@extends('layouts.base')

@section('title', 'Multivariate Trend Result')

@section('page-title', 'Multivariate Trend Result')


@section('content')

    <div class="max-w-7xl mx-auto p-6">
        <div class="relative w-full overflow-hidden">
            <div id="chart-container" class="carousel flex">
                <!-- Dynamic charts will be inserted here -->
            </div>
            <button onclick="prevSlide()"
                class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow">❮</button>
            <button onclick="nextSlide()"
                class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow">❯</button>
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
        <form method="POST" action="{{ route('share.with_other') }}">
            @csrf
            <input type="hidden" name="file_assoc_id" value="{{ $file_assoc_id }}"> <!-- ID of the file association -->

            <label for="users">Share with Users:</label>
            <div>
                @foreach ($users as $user)
                    <div>
                        <input type="checkbox" name="shared_to_user_ids[]" value="{{ $user->id }}"
                            id="user_{{ $user->id }}">
                        <label for="user_{{ $user->id }}">{{ $user->name }}</label>
                    </div>
                @endforeach
            </div>

            <button type="submit">Share</button>
        </form>

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

        const jsonData = @json($data); // Server-side rendered data
        const data = JSON.parse(jsonData);
        const chartContainer = document.getElementById('chart-container');
        let currentIndex = 0;

        const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

        function createCharts(data) {
            const index = data.trend.index; // Time index (date or time)

            data.colname.forEach((col) => {
                // Create a new card for each variable chart
                const card = document.createElement('div');
                card.className = "bg-white shadow-md rounded-lg p-6 min-w-full"; // Card layout
                card.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="col-span-2">
                            <div id="chart-${col}"></div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-gray-700 mb-4">Trend analysis for ${col}. This chart shows original values along with the moving averages for better insights.</p>
                        </div>
                    </div>
                `;
                chartContainer.appendChild(card);

                // Clean the data
                const originalData = cleanData(data.trend[col]);
                const sma5Data = cleanData(data.trend[`${col}_sma_5`]);
                const sma10Data = cleanData(data.trend[`${col}_sma_10`]);
                const sma20Data = cleanData(data.trend[`${col}_sma_20`]);

                // Initialize the chart for each variable
                const options = {
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
                        name: `${col} - Original Value`,
                        data: originalData,
                    }, {
                        name: `${col} - SMA 5`,
                        data: sma5Data,
                    }, {
                        name: `${col} - SMA 10`,
                        data: sma10Data,
                    }, {
                        name: `${col} - SMA 20`,
                        data: sma20Data,
                    }],
                    xaxis: {
                        categories: index,
                        title: {
                            text: 'Date/Time'
                        },
                        type: 'datetime',
                    },
                    yaxis: {
                        title: {
                            text: `${col}`
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
                    colors: ['#FF4560', '#546E7A', '#1E90FF', '#00E396'] // Corresponding colors

                };

                // Append the chart
                const chart = new ApexCharts(document.getElementById(`chart-${col}`), options);
                chart.render();
            });
        }

        createCharts(data);

        function showSlide(index) {
            const totalSlides = chartContainer.children.length;
            currentIndex = (index + totalSlides) % totalSlides;
            chartContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        function nextSlide() {
            showSlide(currentIndex + 1);
        }

        function prevSlide() {
            showSlide(currentIndex - 1);
        }
    </script>
@endsection
