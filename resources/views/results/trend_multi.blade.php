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
    @elseif (session('operation_success'))
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('operation_success') }}
        </div>
    @elseif (session('operation_failed'))
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('operation_failed') }}
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
                    <div class="bg-gray-50 p-2 rounded overflow-y-auto flex-1 text-sm">
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
            <div class="bg-white shadow-md rounded-lg p-3 flex flex-col h-full overflow-y-auto max">
                <!-- Options Section -->
                <div class="flex overflow-x-auto space-x-2 hide-scrollbar" id="explanation-options">
                    <!-- Options will be dynamically added here -->
                </div>

                <!-- Info Section (Explanation) -->
                <div id="explanation-content" class="mt-4 flex-1  overflow-y-auto max">
                    <p class="text-gray-700 text-sm">Lorem ipsum dolor sit amet.</p>
                </div>
            </div>
        </div>

        <!-- Download Button -->
        <button id="downloadButton"
            class="fixed bottom-20 right-6 mb-4 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-500 focus:outline-none">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12V4m-4 4l4 4 4-4" />
            </svg>
        </button>
        <!-- The line graph for pdf. render->capture->include -->
        <canvas id="lineChart" width="600" height="400" style="display:none;"></canvas>

        <!-- Chat with AI Button -->
        <button id="chatButton"
            class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-500 focus:outline-none">
            <i class="fa-solid fa-robot fa-bounce" style="color: #ffffff;"></i>
        </button>


        <div id="chatBox" class="hidden fixed bottom-6 right-6 w-96 h-96 bg-white rounded-lg shadow-xl overflow-hidden">
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
        function stripHTMLTags(input) {
            return input.replace(/<[^>]*>/g, '');
        }

        $("#downloadButton").click(function(e) {
            e.preventDefault();

            console.log("download event");

            const jsonData = @json($data);
            const data = JSON.parse(jsonData);
            const colnames = data.metadata.colname;
            const description = @json(strip_tags($description));



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



                // Prepare datasets and y-axis configuration
                const datasets = [];
                const yAxisConfig = {};


                colnames.forEach((col, index) => {
                    datasets.push({
                        label: `${col}`,
                        data: data.trend[`${col}`],
                        borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                        fill: false,
                        yAxisID: `y-axis-${index + 1}`,
                        pointRadius: 0,
                    });

                    yAxisConfig[`y-axis-${index + 1}`] = {
                        type: 'linear',
                        position: 'left', // Alternating y-axis sides
                        title: {
                            display: true,
                            text: col
                        },
                    };
                });

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.trend.index, // x-axis labels (dates/times)
                        datasets: datasets
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date/Time'
                                }
                            },
                            ...yAxisConfig
                        },
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

                colnames.forEach((col, index) => {
                    pdf.addPage();
                    pdf.setFillColor(240, 240, 240);
                    pdf.rect(10, 20, pdf.internal.pageSize.width - 20, 15, 'F');
                    pdf.setFont("helvetica", "bold");
                    pdf.setFontSize(14);
                    pdf.text(`Key Details on ${col} (AI Generated)`, 10, 30);

                    // Key details content with pagination
                    pdf.setFont("helvetica", "normal");
                    pdf.setFontSize(10);

                    let response1 = stripHTMLTags(data.explanations[`${col}`]['response1']);
                    let response2 = stripHTMLTags(data.explanations[`${col}`]['response2']);
                    let keyDetails = response1 + response2;


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
                        // Check if notification element already exists, if not, create it
                        let notification = document.getElementById('notification');
                        if (!notification) {
                            notification = document.createElement('div');
                            notification.id = 'notification';
                            notification.classList.add(
                                'fixed', 'top-4', 'left-1/2', 'transform',
                                '-translate-x-1/2', 'text-white',
                                'px-4', 'py-2', 'rounded-lg', 'shadow-lg',
                                'transition-opacity', 'opacity-100'
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
            const colnames = data.metadata.colname;


            // Utility function to handle missing values
            const cleanData = (arr) => arr.map(value => (value === '' || value === null) ? null : value);

            const seriesData = [];
            const yAxisCongif = [];


            colnames.forEach((col, index) => {
                seriesData.push({
                    name: col,
                    data: cleanData(data.trend[`${col}`])
                });


                yAxisCongif.push({
                    title: {
                        text: `${col}`,
                    },
                    labels: {
                        show: true,
                        formatter: function(value) {
                            return isNaN(value) ? value : value.toFixed(2);
                        }
                    },
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                    }
                });
            });




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
                    },
                    events: {
                        markerClick: function(event, chartContext, opts) {
                            console.log(opts);
                            console.log(opts.seriesIndex);

                            //well fetch the colname from the index
                            handleExplanationSelection(colname_seriesIndexDict[opts.seriesIndex]);


                        }
                    },
                },
                // title: {
                //     text: 'Trend Result',
                //     align: 'left',
                //     style: {
                //         fontSize: '18px', // Font size of the title
                //         color: '#263238' // Color of the title
                //     }
                // },
                series: seriesData,
                xaxis: {
                    categories: data.trend.index, // x-axis labels (dates/times)
                    title: {
                        text: 'Date/Time'
                    },
                    type: 'datetime',
                },
                yaxis: yAxisCongif,
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

            var chart = new ApexCharts(document.querySelector("#chart-container"), options);
            chart.render();


            const explanations = data.explanations;
            // Populate explanation options
            const explanationOptionsContainer = document.getElementById('explanation-options');
            // const explanationContent = document.getElementById('explanation-content');
            let selectedVar = colnames[0]; // Default selection

            let colname_seriesIndexDict = {};


            colnames.forEach((col, index) => {
                const optionButton = document.createElement('button');
                optionButton.className =
                    `px-4 py-2 border rounded ${col === selectedVar ? 'bg-blue-500 text-white' : 'bg-white text-black'}`;
                optionButton.textContent = col;
                optionButton.addEventListener('click', () => handleExplanationSelection(col));
                explanationOptionsContainer.appendChild(optionButton);


                //add data to the dict. well use the index as a key
                colname_seriesIndexDict[index] = col;
            });

            // Handle the explanation selection
            function handleExplanationSelection(selectedCol) {
                selectedVar = selectedCol;

                // Update the explanation content
                $("#explanation-content").html(explanations[selectedVar]['response1'] + "<br>" + explanations[
                    selectedVar]['response2']);

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
            $("#explanation-content").html(explanations[selectedVar]['response1'] + "<br>" + explanations[
                selectedVar]['response2']);

        });
    </script>
@endsection
