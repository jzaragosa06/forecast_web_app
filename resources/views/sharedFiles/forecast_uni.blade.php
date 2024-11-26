@extends('layouts.base')

@section('title', 'Forecast Result')

@section('page-title', 'Forecast Result (Read-Only)')


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


    <div class="container mx-auto my-6 h-screen">
        <!-- Layout container with grid -->
        <div id="main-content" class="grid grid-cols-3 gap-4 h-full transition-all duration-300">
            <!-- Left Column (Buttons and Graphs) -->
            <div class="col-span-2 flex flex-col space-y-4 h-full">
                <!-- Toggle buttons aligned to the top left -->
                <div class="flex justify-start mb-4 space-x-2">
                    <button id="outsampleForecastBtn"
                        class="bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none">
                        Forecast
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
                        <!-- Second Container -->
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
        <!-- The line graph for pdf. render->capture->include -->
        <canvas id="lineChart" width="600" height="400" style="display:none;"></canvas>

        <!-- Download Button -->
        <button id="downloadButton"
            class="fixed bottom-20 right-6 mb-4 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-500 focus:outline-none">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12V4m-4 4l4 4 4-4" />
            </svg>
        </button>


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
                <div class="group relative">
                    <button id="saveNotes" class="px-4 py-2 rounded-md bg-gray-300 text-gray-500 cursor-not-allowed peer"
                        disabled>
                        Save Note
                    </button>
                    <span class="absolute top-full left-0 mt-1 text-sm text-gray-500 opacity-0 group-hover:opacity-100">
                        This feature is disabled. Read only
                    </span>
                </div>
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

            const jsonData = @json($data);
            const data = JSON.parse(jsonData);
            const colname = data.metadata.colname;
            const description = @json(strip_tags($description));
            const value = data.forecast.pred_out[`${colname}`];
            const index = data.forecast.pred_out.index;

            // Use map() to create an array of pairs, each containing the month and forecast value
            const tableData = index.map((month, i) => [month, value[i]]);
            tableData.unshift(["Date", `Forecast on ${colname}`]);

            const response1 = stripHTMLTags(data.forecast.pred_out_explanation.response1);
            const response2 = stripHTMLTags(data.forecast.pred_out_explanation.response2);
            const response3 = stripHTMLTags(data.forecast.pred_out_explanation.response3);
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
                        labels: data.forecast.pred_out.index,
                        datasets: [{
                            label: `${colname}`,
                            data: value,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: false,
                            yAxisID: 'y-axis-1',
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true, // Enable the title
                                text: `Forecast Chart for ${colname}`, // Set the title text
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
                                    text: `Forecast on ${colname}`
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

                // Forecast table on a new page
                pdf.addPage();
                pdf.setFontSize(16);
                pdf.setFont("helvetica", "bold");
                pdf.text("Forecast", 10, 20);

                // Add forecast table using autoTable
                pdf.autoTable({
                    startY: 30,
                    head: [tableData[0]],
                    body: tableData.slice(1),
                    theme: 'grid',
                    headStyles: {
                        fillColor: [230, 230, 230]
                    },
                    styles: {
                        halign: 'center'
                    }
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
                readOnly: true,
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
            // Fetch and parse JSON data from the server-side
            const jsonData = @json($data); // Server-side rendered data
            const data = JSON.parse(jsonData);
            const colname = data.metadata.colname;

            renderChart1();
            renderChart2();
            renderForecastTable_out();
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
                            show: true,
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
                        name: `${colname}`,
                        data: origDataValue,

                    }, {
                        name: `Forecast on ${colname}`,
                        data: forecastData_null,

                    }],
                    xaxis: {
                        categories: full_index,
                        type: 'datetime'
                    },
                    yaxis: {
                        title: {
                            text: `${colname}`,
                        },
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
                            show: true,
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
                                    <td class="py-2 px-4 text-center">${date}</td>
                                    <td class="py-2 px-4 text-center">${value}</td>
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
