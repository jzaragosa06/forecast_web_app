
@extends('layouts.base')

@section('title', 'Multivariate Trend Result')

@section('page-title', 'Multivariate Trend Result')

@section('content')
    <div class="container mx-auto my-6 h-screen bg-gray-50"> <!-- Added light gray background -->
        <!-- Layout container with grid -->
        <div class="grid grid-cols-3 gap-4 h-full">

            <!-- Left Column (Graphs and Notes) -->
            <div class="col-span-2 flex flex-col space-y-3 h-full">
                <!-- Graph Section (Top) -->
                <div class="bg-white shadow-md rounded-lg p-1 h-1/2"> <!-- Reduced padding to p-2 -->

                    <!-- Placeholder for the graph -->
                    <div id="chart-container"></div>
                </div>

                <!-- Notes Section (Bottom) -->
                <div class="bg-white shadow-md rounded-lg p-3 flex-1 flex flex-col">
                    <h2 class="font-semibold text-gray-700 text-sm">Notes</h2>
                    <!-- Quill Editor Wrapper with scrolling -->
                    <div class="bg-gray-200 p-2 rounded overflow-y-auto flex-1 text-sm">
                        <div id="notesEditor" class="h-full"></div> <!-- Make Quill editor take full height -->
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

            <!-- Right Column (Info Card) -->
            <div class="bg-white shadow-md rounded-lg p-3 flex flex-col justify-between h-full">
                <!-- Explanation Selector -->
                <div class="flex overflow-x-auto space-x-2 hide-scrollbar" id="explanation-options">
                    <!-- Options will be dynamically added here -->
                </div>


                <!-- Info Section -->
                <div class="mt-4">
                    <h3 class="text-gray-700 font-semibold">Explanation</h3>
                    <p id="explanation-content" class="text-gray-700 text-sm">Lorem ipsum dolor sit amet.</p>
                </div>
            </div>
        </div>

        <!-- This is for Chat with AI-->
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
            // Initialize the Quill editor
            var quill = new Quill('#notesEditor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{
                            'background': []
                        }],
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['clean']
                    ]
                }
            });

            @if ($note)
                quill.root.innerHTML = `{!! $note->content !!}`;
            @endif

            // Fetch and parse the JSON data
            const jsonData = @json($data); // Assuming $data is passed from the backend
            const data = JSON.parse(jsonData);

            // Utility function to handle missing values
            const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

            const colnames = data.metadata.colname;
          

            // Populate explanation options
            const explanationOptionsContainer = document.getElementById('explanation-options');
            const explanationContent = document.getElementById('explanation-content');
            let selectedVar = colnames[0]; // Default selection

            colnames.forEach((col, index) => {
                const optionButton = document.createElement('button');
                optionButton.className =
                    `px-4 py-2 border rounded ${col === selectedVar ? 'bg-blue-500 text-white' : 'bg-white text-black'}`;
                optionButton.textContent = col;
                optionButton.addEventListener('click', () => handleExplanationSelection(col));
                explanationOptionsContainer.appendChild(optionButton);
            });

            // Handle the explanation selection
            function handleExplanationSelection(selectedCol) {
                selectedVar = selectedCol;

                // Update the explanation content
                explanationContent.textContent = explanations[selectedCol];

                // Update the selected button styles
                Array.from(explanationOptionsContainer.children).forEach(button => {
                    if (button.textContent === selectedCol) {
                        button.classList.remove('bg-white', 'text-black');
                        button.classList.add('bg-blue-500', 'text-white');
                    } else {
                        button.classList.remove('bg-blue-500', 'text-white');
                        button.classList.add('bg-white', 'text-black');
                    }
                });
            }

            // Set default explanation content
            explanationContent.textContent = explanations[selectedVar];

            // Handle chart initialization
            const seriesData = colnames.map(col => ({
                name: col,
                data: cleanData(data.trend[col])
            }));

            const options = {
                chart: {
                    type: 'line',
                    height: 350,
                    zoom: {
                        enabled: true
                    },
                    toolbar: {
                        show: false
                    },
                },
                series: seriesData,
                xaxis: {
                    categories: data.trend.index,
                    title: {
                        text: 'Date/Time'
                    },
                    type: 'datetime',
                },
                yaxis: colnames.map(col => ({
                    title: {
                        text: col
                    },
                    labels: {
                        formatter: value => isNaN(value) ? value : value.toFixed(2)
                    }
                })),
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                markers: {
                    size: 0,
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                    intersect: false,
                },
            };

            var chart = new ApexCharts(document.querySelector("#chart-container"), options);
            chart.render();
        });
    </script>
@endsection
