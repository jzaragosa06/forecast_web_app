@extends('layouts.base')

@section('title', 'Univariate Seasonality')

@section('page-title', 'Univariate Seasonality')


@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex flex-wrap -mx-4">
            <!-- Seasonality Graphs Section -->
            <div id="seasonality-graphs" class="w-full md:w-2/3 px-4 mb-8">
                <div class="bg-gray-100 shadow-lg rounded-lg p-6">
                    <div id="chart-container" class="grid gap-6">
                        <!-- Dynamic charts will be inserted here -->
                    </div>
                </div>
            </div>

            <!-- Chat with AI and Notes Section -->
            <div id="chat-with-AI-and-notes" class="w-full md:w-1/3 px-4 mb-8">
                <div class="bg-gray-100 shadow-lg rounded-lg p-6">
                    <div id="chatContainer" class="flex flex-col space-y-6"> <!-- Flex column and space between sections -->

                        <!-- Chat Dialog Section -->
                        <div class="w-full">
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
                        <div class="w-full">
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

        const jsonData = @json($data);
        const data = JSON.parse(jsonData);

        // Generate x-axis labels for yearly seasonality as dates (Jan 1 to Dec 31 of an arbitrary year)
        const generateYearlyLabels = () => {
            const labels = [];
            const arbitraryYear = 2020; // Arbitrary non-leap year
            let currentDate = new Date(arbitraryYear, 0, 1); // Start at January 1

            while (currentDate.getFullYear() === arbitraryYear) {
                // Convert to timestamp for ApexCharts datetime x-axis
                labels.push(currentDate.getTime());
                // Increment by 1 day
                currentDate.setDate(currentDate.getDate() + 1);
            }

            return labels;
        };

        const weeklyLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const yearlyLabels = generateYearlyLabels(); // Use the new function to generate date labels

        // Reference to the chart container
        const chartContainer = document.getElementById('chart-container');

        // Function to create chart
        function createChart(title, labels, seriesData, isDatetime = false) {
            // Create card div for the chart and the paragraph
            const cardDiv = document.createElement('div');
            cardDiv.classList.add('bg-white', 'shadow-lg', 'rounded-lg', 'p-6', 'mb-6'); // Light gray background

            // Create a div for the chart itself
            const chartDiv = document.createElement('div');
            chartDiv.style.marginBottom = '20px'; // Spacing between chart and paragraph

            cardDiv.appendChild(chartDiv); // Add chart div to card div
            chartContainer.appendChild(cardDiv); // Append card div to chart container

            const options = {
                chart: {
                    type: 'line',
                    height: 350,
                    animations: {
                        enabled: true
                    },
                    toolbar: {
                        show: false,
                    }
                },
                title: {
                    text: title,
                    align: 'left'
                },
                xaxis: {
                    type: isDatetime ? 'datetime' : 'category', // Use 'datetime' for yearly
                    categories: labels,
                    labels: {
                        formatter: function(value, timestamp) {
                            if (isDatetime) {
                                // Format the datetime labels to only show month and day
                                return new Date(timestamp).toLocaleDateString('en-US', {
                                    month: 'short',
                                    day: 'numeric'
                                });
                            } else {
                                return value;
                            }
                        }
                    }
                },
                series: seriesData,
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                markers: {
                    size: 0
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    x: {
                        format: 'MMM dd' // Format the tooltip to show only month and day
                    }
                },
                yaxis: {
                    title: {
                        text: 'Value'
                    },
                    labels: {
                        show: true,
                        formatter: function(value) {
                            return isNaN(value) ? value : value.toFixed(2);
                        }
                    },
                }
            };

            // Render the chart inside the chart div
            const chart = new ApexCharts(chartDiv, options);
            chart.render();

            // Create a paragraph below the chart
            const paragraph = document.createElement('p');
            // paragraph.classList.add('mt-4', 'text-gray-600', 'text-sm'); // Gray text
            paragraph.classList.add('bg-gray-100', 'rounded-lg', 'p-2', 'mt-4');
            paragraph.innerText =
                `This is a detailed description or note for the graph titled: ${title}. You can add more context here.`;

            cardDiv.appendChild(paragraph); // Append paragraph to card div



        }

        // Loop through each variable (colname)
        const colnames = data.colnames;

        if (data.seasonality_per_period && colnames) {
            for (const col in data.seasonality_per_period) {
                const seasonalityData = data.seasonality_per_period[col];

                // Loop through the components (e.g., 'weekly', 'yearly')
                data.components.forEach(component => {
                    if (seasonalityData[component]) {
                        let labels, title, isDatetime = false;
                        if (component === 'weekly') {
                            labels = weeklyLabels;
                            title = `${col} - Weekly Seasonality`;
                        } else if (component === 'yearly') {
                            labels = yearlyLabels;
                            title = `${col} - Yearly Seasonality`;
                            isDatetime = true; // Set datetime flag for yearly
                        }

                        // Prepare series data for ApexCharts
                        const seriesData = [{
                            name: 'Value',
                            data: seasonalityData[component].values
                        }];

                        // Create chart with labels and data
                        createChart(title, labels, seriesData, isDatetime);
                    }
                });
            }
        }
    </script>
@endsection
