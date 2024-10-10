@extends('layouts.base')

@section('title', 'Univariate Seasonality')

@section('page-title', 'Univariate Seasonality')

@section('content')
    <div class="container mx-auto my-6 h-screen bg-gray-50">
        <!-- Layout container with grid -->

        <div class="grid grid-cols-3 gap-4 h-full">
            <!-- Left Column (Graphs and Notes) -->
            <div class="col-span-2 flex flex-col space-y-3 h-full">
                <div id="button-container" class="flex overflow-x-auto gap-2 mb-4">
                    <!-- Dynamic buttons for components will be inserted here -->
                </div>

                <div id="chart-container" class="flex flex-col gap-6">
                    <!-- Dynamic charts will be inserted here -->
                </div>


                <!-- Notes Section (Bottom) -->
                <div class="bg-white shadow-md rounded-lg p-3 flex-1 flex flex-col">
                    <h2 class="font-semibold text-gray-700 text-sm">Notes</h2>
                    <div class="bg-gray-50 p-2 rounded overflow-y-auto flex-1 text-sm">
                        <div id="notesEditor" class="h-full"></div>
                    </div>
                    <input type="hidden" id="notesContent" name="notesContent">
                    <div class="mt-2">
                        <button id="saveNotes"
                            class="bg-blue-500 text-white font-bold py-1 px-3 rounded hover:bg-blue-600 text-sm">
                            Save Notes
                        </button>
                    </div>
                </div>
            </div>

            <div>
                {{-- <div id="variable-button-container" class="flex overflow-x-auto gap-2 mb-4">
                    <!-- Dynamic buttons for variables will be inserted here -->
                </div> --}}
                <div class="flex overflow-x-auto space-x-2 hide-scrollbar" id="variable-button-container">
                    <!-- Options will be dynamically added here -->
                </div>

                <!-- Right Column (Info Card) -->
                <div class="bg-white shadow-md rounded-lg p-3 flex flex-col justify-between h-full">
                    <div id="info-card" class="mb-4">
                        <!-- Dynamic explanations will be shown here -->
                    </div>
                </div>
            </div>

        </div>

        <!-- Chat Button -->
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

        // Code for quill and chat with AI. 
        const jsonData = @json($data);
        const data = JSON.parse(jsonData);

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
        const yearlyLabels = generateYearlyLabels();

        // Reference to containers
        const chartContainer = document.getElementById('chart-container');
        const buttonContainer = document.getElementById('button-container');
        const variableButtonContainer = document.getElementById('variable-button-container');
        const infoCard = document.getElementById('info-card');

        // Function to create chart
        function createChart(title, labels, seriesData, yAxisConfig, isDatetime = false) {
            const cardDiv = document.createElement('div');
            cardDiv.classList.add('bg-white', 'shadow-lg', 'rounded-lg', 'p-6', 'mb-6');

            const chartDiv = document.createElement('div');
            chartDiv.style.marginBottom = '20px';
            cardDiv.appendChild(chartDiv);
            chartContainer.appendChild(cardDiv);

            const options = {
                chart: {
                    type: 'line',
                    height: 350,
                    animations: {
                        enabled: true
                    },
                    toolbar: {
                        show: false
                    }
                },
                title: {
                    text: title,
                    align: 'left'
                },
                xaxis: {
                    type: isDatetime ? 'datetime' : 'category',
                    categories: labels,
                    labels: {
                        formatter: function(value, timestamp) {
                            if (isDatetime) {
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
                yaxis: yAxisConfig,
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                markers: {
                    size: 0
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    x: {
                        format: 'MMM dd'
                    }
                }
            };

            const chart = new ApexCharts(chartDiv, options);
            chart.render();
        }

        // Function to create buttons for components
        function createButton(label, container, onClick) {
            const button = document.createElement('button');
            button.classList.add('font-bold', 'py-2', 'px-4', 'rounded', 'focus:outline-none', 'bg-white', 'text-blue-500',
                'border', 'border-blue-500');
            button.textContent = label.charAt(0).toUpperCase() + label.slice(1);
            button.onclick = onClick;
            container.appendChild(button);
        }

        // Function to load the component (weekly or yearly)
        function loadComponent(component) {
            chartContainer.innerHTML = '';
            const colnames = data.metadata.colname;
            let seriesData = [];
            let yAxisConfig = [];
            let title =
                `${data.metadata.colname.join(', ')} - ${component.charAt(0).toUpperCase() + component.slice(1)} Seasonality`;

            colnames.forEach((col) => {
                const seasonalityData = data.seasonality_per_period[col];

                if (seasonalityData[component]) {
                    seriesData.push({
                        name: col,
                        data: seasonalityData[component].values
                    });

                    // Add y-axis configuration for this variable
                    yAxisConfig.push({
                        seriesName: col,
                        title: {
                            text: col
                        },
                        labels: {
                            show: true,
                            formatter: function(value) {
                                return isNaN(value) ? value : value.toFixed(2);
                            }
                        },
                    });
                }
            });

            const isDatetime = component === 'yearly';
            createChart(title, isDatetime ? yearlyLabels : weeklyLabels, seriesData, yAxisConfig, isDatetime);
            // Update explanations in the info card
            updateInfoCard(component, colnames[0]); // Pass the first variable for initial load
        }

        // Function to update the info card with explanations
        function updateInfoCard(component, variable) {
            const explanation = data.explanations[component][variable] || "No explanation available.";
            infoCard.innerHTML = `<p class="text-gray-700 text-sm">${explanation}</p>`;
        }

        // Generate buttons based on available components
        data.components.forEach(component => {
            createButton(component, buttonContainer, () => {
                loadComponent(component);
                updateVariableButtons(component); // Update variable buttons on component change
                updateButtonStyles(component, buttonContainer);
            });
        });

        // Function to update button styles for component buttons
        function updateButtonStyles(selectedComponent, container) {
            const buttons = container.querySelectorAll('button');

            buttons.forEach(button => {
                if (button.textContent.toLowerCase() === selectedComponent) {
                    button.classList.add('bg-blue-500', 'text-white');
                    button.classList.remove('bg-white', 'text-blue-500', 'border');
                } else {
                    button.classList.add('bg-white', 'text-blue-500', 'border', 'border-blue-500');
                    button.classList.remove('bg-blue-500', 'text-white');
                }
            });
        }


        // Function to update variable buttons based on the selected component
        function updateVariableButtons(component) {
            variableButtonContainer.innerHTML = ''; // Clear existing variable buttons
            const colnames = data.metadata.colname;

            colnames.forEach(variable => {
                createButton(variable, variableButtonContainer, () => {
                    updateInfoCard(component,
                        variable); // Update the info card with the variable's explanation
                    updateVariableButtonStyles(variable); // Update button styles on variable selection
                });
            });

            // Set the first variable as selected by default
            updateInfoCard(component, colnames[0]); // Update the info card for the first variable
            updateVariableButtonStyles(colnames[0]); // Highlight the first variable button
        }

        // Function to update button styles for variable buttons
        function updateVariableButtonStyles(selectedVariable) {
            const buttons = variableButtonContainer.querySelectorAll('button');

            buttons.forEach(button => {
                if (button.textContent.toLowerCase() === selectedVariable.toLowerCase()) {
                    button.classList.add('bg-blue-500', 'text-white'); // Highlight selected variable
                    button.classList.remove('bg-white', 'text-blue-500'); // Reset non-selected
                } else {
                    button.classList.add('bg-white', 'text-blue-500'); // Reset non-selected
                    button.classList.remove('bg-blue-500', 'text-white'); // Remove highlight
                }
            });
        }

        const initialComponent = data.components[0];
        loadComponent(initialComponent);
        updateVariableButtons(initialComponent);

        updateButtonStyles(data.components[0], buttonContainer);
    </script>
@endsection
