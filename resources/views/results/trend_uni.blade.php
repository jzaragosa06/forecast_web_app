@extends('layouts.base')

@section('title', 'Trend Result')

@section('page-title', 'Trend Result')

@section('content')
    @if (session('success'))
        <!-- Notification Popup -->
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('success') }}
        </div>
    @elseif (session('fail'))
        <!-- Notification Popup -->
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('fail') }}
        </div>
    @elseif (session('note_success'))
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('note_success') }}
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('notification');
            if (notification) {
                // Hide after 3 seconds (3000 milliseconds)
                setTimeout(() => {
                    notification.classList.add('opacity-0');
                }, 3000);

                // Remove the element completely after the fade-out
                setTimeout(() => {
                    notification.remove();
                }, 3500);
            }
        });
    </script>

    <style>
        .transition-opacity {
            transition: opacity 0.5s ease-in-out;
        }
    </style>


    <div class="container mx-auto my-6 h-screen bg-gray-50"> <!-- Added light gray background -->
        <!-- Layout container with grid -->
        <div id="main-content" class="grid grid-cols-3 gap-4 h-full">

            <!-- Left Column (Graphs and Notes) -->
            <div class="col-span-2 flex flex-col space-y-3 h-full">
                <!-- Graph Section (Top) -->
                <div class="bg-white shadow-md rounded-lg p-1 h-1/2"> <!-- Reduced padding to p-2 -->
                    <div id="chart1"></div> <!-- Placeholder for the graph -->
                </div>

                <!-- New Row with Two Equal Containers -->
                <div class="flex space-x-4 h-full">
                    <!-- First Container -->
                    <div class="flex-1 bg-white shadow-md rounded-lg p-4">
                        <div class="flex items-center text-lg font-semibold mb-2">
                            Data Description
                            <!-- Tooltip Icon -->
                            <div class="relative group ml-2">
                                <i class="fas fa-info-circle text-gray-500 hover:text-gray-700 cursor-pointer"></i>
                                <div
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-sm rounded py-1 px-2">
                                    This describes the data used to make a forecast
                                </div>
                            </div>
                        </div>
                        <div>
                            <!-- Content for Data Description -->
                            {{ $description }}
                        </div>
                    </div>
                    {{-- <!-- Second Container -->
                    <div class="flex-1 bg-white shadow-md rounded-lg p-4">
                        <div class="flex items-center text-lg font-semibold mb-2">
                            Forecast
                            <!-- Tooltip Icon -->
                            <div class="relative group ml-2">
                                <i class="fas fa-info-circle text-gray-500 hover:text-gray-700 cursor-pointer"></i>
                                <div
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-sm rounded py-1 px-2">
                                    This describes the forecast for the given time series
                                </div>
                            </div>
                        </div>
                        <table id="forecast-table-out" class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">Date</th>
                                    <th class="border px-4 py-2">Forecasted Value</th>
                                </tr>
                            </thead>
                            <tbody id="forecastTableBody-out">
                                <!-- Data will be dynamically rendered -->
                            </tbody>
                        </table>
                    </div> --}}
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


        <canvas id="lineChart" width="600" height="400" style="display:none;"></canvas>

        <!-- Download Button -->
        <button id="downloadButton"
            class="fixed bottom-32 right-6 mb-4 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-500 focus:outline-none">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12V4m-4 4l4 4 4-4" />
            </svg>
        </button>

        <!-- Chat with AI Button -->
        <button id="chatButton"
            class="fixed bottom-20 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-500 focus:outline-none">
            <i class="fa-solid fa-robot fa-bounce fa-lg" style="color: #ffffff;"></i>
        </button>

        <!-- Chat with AI Panel -->
        <div id="chatBox"
            class="hidden fixed bottom-5 right-6 w-96 h-96 bg-white rounded-lg shadow-xl overflow-hidden z-50">
            <div class="bg-gray-200 border-b p-3 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <!-- Google Gemini Icon -->
                    <img src="https://lh3.googleusercontent.com/Xtt-WZqHiV8OjACMMMr6wMdoMGE7bABi-HYujupzevufo1kiHUFQZukI1JILhjItrPNrDWLq6pfd=s600-w600"
                        alt="Google Gemini Icon" class="w-5 h-5">
                    <h3 class="text-lg font-semibold text-gray-700">Chat with AI</h3>
                    <span class="text-sm text-gray-500 ml-2">Powered with Google Gemini</span>
                </div>
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
                    <i class="fa-solid fa-arrow-up" style="color: #ffffff;"></i>
                </button>
            </div>
        </div>

        <!-- Notes Side Panel (Initially hidden) -->
        <div id="side-panel"
            class="fixed top-0 right-0 h-full w-80 bg-white shadow-lg p-4 flex flex-col transition-transform duration-300 transform translate-x-full">

            <!-- Panel Header -->
            <h2 class="font-semibold text-gray-700 mb-4">Notes</h2>

            <!-- Editor Container (flex-1 to fill remaining space) -->
            <div class="bg-white p-2 rounded overflow-y-auto flex-1">
                <div id="notesEditor" class="h-full"></div>
            </div>

            <!-- Save Button -->
            <input type="hidden" id="notesContent" name="notesContent">
            <div class="mt-4">
                <button id="saveNotes" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                    Save Notes
                </button>
            </div>
        </div>


        <!-- Notes button-->
        <button id="toggle-button"
            class="fixed bottom-3 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-500 focus:outline-none"
            onclick="togglePanel()">
            <i class="fa-solid fa-pen-to-square fa-lg" style="color: #ffffff;"></i>
        </button>
    </div>
@endsection

@section('scripts')

    <script>
        // Function to toggle the side panel visibility
        function togglePanel() {
            const sidePanel = document.getElementById("side-panel");
            const mainContent = document.getElementById("main-content");

            // Check if the side panel is currently open
            const isOpen = !sidePanel.classList.contains("translate-x-full");

            if (isOpen) {
                // Close the side panel
                sidePanel.classList.add("translate-x-full");
                mainContent.classList.remove("mr-80");
            } else {
                // Open the side panel
                sidePanel.classList.remove("translate-x-full");
                mainContent.classList.add("mr-80");
            }
        }
    </script>

    <script>
        function stripHTMLTags(input) {
            return input.replace(/<[^>]*>/g, '');
        }

        $("#downloadButton").click(function(e) {
            e.preventDefault();

            console.log("download event");

            const jsonData = @json($data);
            const data = JSON.parse(jsonData);
            const colname = data.metadata.colname;
            const description = @json(strip_tags($description));
            const value = data.trend[`${data.metadata.colname}`];
            const index = data.trend.index;

            const response1 = stripHTMLTags(data.explanations.response1);
            const response2 = stripHTMLTags(data.explanations.response2);
            const response3 = stripHTMLTags(data.explanations.response3);
            const keyDetails = response1 + response2 + response3;

            @if ($note)
                const note = @json(strip_tags($note->content));
            @else
                const note = "";
            @endif

            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF();

            // Header background and title
            pdf.setFillColor(230, 230, 230);
            pdf.rect(0, 0, pdf.internal.pageSize.width, 30, 'F');
            const logoImage = new Image();
            logoImage.src = "{{ asset('storage/idiot-guid-imgs/logo.png') }}";
            logoImage.onload = async () => {
                const logoWidth = 20;
                const logoHeight = 20;
                pdf.addImage(logoImage, 'PNG', 10, 5, logoWidth, logoHeight);
                pdf.setFontSize(22);
                pdf.setFont("helvetica", "bold");
                pdf.text("DataForesight", 40, 20);
                pdf.setFontSize(12);
                pdf.setFont("helvetica", "normal");
                pdf.text("The following describes the result of analysis.", 40, 25);

                // Background for Data section
                pdf.setFillColor(240, 240, 240);
                pdf.rect(10, 35, pdf.internal.pageSize.width - 20, 20, 'F');
                pdf.setFontSize(10);
                pdf.text("Background of the data used for analysis: " + description, 12, 42, {
                    maxWidth: pdf.internal.pageSize.width - 24
                });

                // Add chart (adjust this part for your image dimensions)
                const canvas = document.getElementById("lineChart");
                const ctx = canvas.getContext("2d");
                const originalWidth = canvas.width;
                const originalHeight = canvas.height;
                canvas.width = originalWidth * 2;
                canvas.height = originalHeight * 2;
                ctx.scale(2, 2);

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: index,
                        datasets: [{
                            label: `${colname}`,
                            data: value,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: false,
                            yAxisID: 'y-axis-1',
                            pointRadius: 0
                        }],
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true, // Enable the title
                                text: `Trend Analysis for ${colname}`, // Set the title text
                                font: {
                                    size: 16 // Optionally, set the font size for the title
                                },
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Dates'
                                }
                            },
                            'y-axis-1': {
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: `${colname}`
                                }
                            }
                        }
                    }
                });

                await new Promise(resolve => setTimeout(resolve, 100));
                const imageData = canvas.toDataURL("image/png");
                pdf.addImage(imageData, 'PNG', 10, 60, 180, 80);

                // Notes section
                pdf.setFillColor(240, 240, 240);
                pdf.rect(10, 145, pdf.internal.pageSize.width - 20, 15, 'F');
                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(14);
                pdf.text("Notes", 10, 155);

                if (note != "") {
                    pdf.setFont("helvetica", "normal");
                    pdf.setFontSize(10);
                    pdf.text(note, 10, 165, {
                        maxWidth: pdf.internal.pageSize.width - 20
                    });
                } else {
                    pdf.setFont("helvetica", "normal");
                    pdf.setFontSize(10);
                    pdf.text("No notes added", 10, 165, {
                        maxWidth: pdf.internal.pageSize.width - 20
                    });
                }

                // Add a new page for Key Details
                pdf.addPage();
                pdf.setFillColor(240, 240, 240);
                pdf.rect(10, 20, pdf.internal.pageSize.width - 20, 15, 'F');
                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(14);
                pdf.text("Key Details (AI Generated)", 10, 30);

                // Key details content with pagination
                pdf.setFont("helvetica", "normal");
                pdf.setFontSize(10);

                // Split text and paginate
                const lines = pdf.splitTextToSize(keyDetails, pdf.internal.pageSize.width - 20);
                let yPosition = 40; // Start position for the first line

                lines.forEach(line => {
                    if (yPosition > pdf.internal.pageSize.height -
                        10) { // Check if we are near the bottom of the page
                        pdf.addPage(); // Add a new page
                        yPosition = 20; // Reset y position for the new page
                    }
                    pdf.text(line, 10, yPosition);
                    yPosition += 10; // Move y position down for each line
                });


                // Save the PDF
                pdf.save("report.pdf");
            };
        });
    </script>

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
                        // Check if notification element already exists, if not, create it
                        let notification = document.getElementById('notification');
                        if (!notification) {
                            notification = document.createElement('div');
                            notification.id = 'notification';
                            notification.classList.add(
                                'fixed', 'top-4', 'left-1/2', 'transform', '-translate-x-1/2',
                                'text-white',
                                'px-4', 'py-2', 'rounded-lg', 'shadow-lg', 'transition-opacity',
                                'opacity-100'
                            );
                            document.body.appendChild(notification);
                        }

                        // Set the message and apply success styles
                        notification.classList.remove('bg-red-500');
                        notification.classList.add('bg-green-500');
                        notification.textContent = response.message;

                        // Display the notification
                        notification.classList.remove('opacity-0');

                        // Automatically hide the notification after a few seconds
                        setTimeout(() => {
                            notification.classList.add('opacity-0');
                        }, 3000);
                        setTimeout(() => {
                            notification.remove();
                        }, 3500);
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
                // title: {
                //     text: 'Trend Result',
                //     align: 'left',
                //     style: {
                //         fontSize: '18px', // Font size of the title
                //         color: '#263238' // Color of the title
                //     }
                // },
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
