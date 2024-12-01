@extends('layouts.base')

@section('title', 'Seasonality Result')

@section('page-title', 'Seasonality Result')

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
    <div class="container mx-auto my-6 h-screen bg-gray-50">
        <!-- Layout container with grid -->
        <div id="button-container" class="flex overflow-x-auto gap-2 mb-4">
            <!-- Dynamic buttons for components will be inserted here -->
        </div>

        <div id="main-content" class="grid grid-cols-3 gap-4">
            <!-- Left Column (Graphs and Notes) -->
            <div class="col-span-2 flex flex-col space-y-3">
                <div id="chart-container" class="flex flex-col gap-6">
                    <!-- Dynamic charts will be inserted here -->
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
                    {{-- <div class="flex-1 bg-white shadow-md rounded-lg p-4">
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

            <div>
                <div class="flex overflow-x-auto space-x-2 hide-scrollbar" id="variable-button-container">
                    <!-- Options will be dynamically added here -->
                </div>
                <!-- Right Column (Info Card) -->
                <div class="bg-white shadow-md rounded-lg p-3 flex flex-col justify-between h-full overflow-y-auto max">
                    <div id="info-card" class="mb-4">
                        <!-- Dynamic explanations will be shown here -->
                    </div>
                </div>
            </div>
        </div>





        <!-- The line graph for pdf. render->capture->include -->
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

    <div id="shareModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 p-6">
            <h3 class="text-lg font-semibold">Share with Users</h3>
            <p class="text-xs text-gray-400 p-2">Share your findings with other users. Contribute to the open access to
                information.</p>

            <input type="text" id="userSearch" placeholder="Search users..."
                class="mb-4 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <form method="POST" action="{{ route('share.with_other') }}">
                @csrf
                <input type="hidden" name="file_assoc_id" id="fileAssocId" value = "{{ $file_assoc_id }}">
                <!-- Hidden field for file_assoc_id -->

                <div class="max-h-64 overflow-y-auto border border-gray-300 rounded p-2 mb-4" id="userList">
                    @foreach ($users as $user)
                        <div class="flex items-center space-x-2 mb-2">
                            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                class="w-8 h-8 object-cover rounded-full" alt="Profile Photo">
                            <div class="flex-1">
                                <p class="text-sm">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                            <input type="checkbox" name="shared_to_user_ids[]" value="{{ $user->id }}"
                                id="user_{{ $user->id }}" class="user-checkbox">
                        </div>
                    @endforeach
                </div>

                <div class="border border-gray-300 rounded p-2 mb-4">
                    <h4 class="text-sm font-semibold">Selected Users:</h4>
                    <div id="selectedUsers" class="text-gray-500">
                        Please select
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                        Share
                    </button>
                    <button type="button" id="closeModalButton"
                        class="ml-4 bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const selectedUsersDiv = document.getElementById('selectedUsers');
            const userSearchInput = document.getElementById('userSearch');

            const sharedUsers = @json($shared_users); // Pass the shared users data to JS

            // Function to update selected users display
            function updateSelectedUsers() {
                const selectedUsers = Array.from(userCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => {
                        const userDiv = checkbox.closest('div'); // Get the user div
                        const name = userDiv.querySelector('p.text-sm').innerText; // Get the user name
                        const email = userDiv.querySelector('p.text-xs').innerText; // Get the user email
                        const profilePic = userDiv.querySelector('img').src; // Get the user profile picture
                        return `<div class="flex items-center space-x-2 mt-2">
                                <img src="${profilePic}" class="w-8 h-8 object-cover rounded-full" alt="Profile Photo">
                                <div>
                                    <p class="text-sm">${name}</p>
                                    <p class="text-xs text-gray-500">${email}</p>
                                </div>
                            </div>`;
                    });

                selectedUsersDiv.innerHTML = selectedUsers.length > 0 ? selectedUsers.join('') : 'Please select';
            }

            // Function to check which users the file is shared with
            function checkSharedUsers(fileAssocId) {
                userCheckboxes.forEach(checkbox => {
                    const userId = checkbox.value;
                    // Check if the user is already shared for this file_assoc_id
                    const isShared = sharedUsers.some(share => share.file_assoc_id == fileAssocId && share
                        .shared_to_user_id == userId);
                    checkbox.checked = isShared;
                });
                updateSelectedUsers();
            }

            // Add event listener to checkboxes
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedUsers);
            });

            // Search functionality
            userSearchInput.addEventListener('input', function() {
                const filter = userSearchInput.value.toLowerCase();
                userCheckboxes.forEach(checkbox => {
                    const userDiv = checkbox.closest('div'); // Get the user div
                    const name = userDiv.querySelector('p.text-sm').innerText
                        .toLowerCase(); // Get user name
                    userDiv.style.display = name.includes(filter) ? '' :
                        'none'; // Show/Hide based on search
                });

                // Reset selected users display on search
                selectedUsersDiv.innerHTML = 'Please select';
            });

            // Get modal and button elements
            const shareButtons = document.querySelectorAll('#shareButton');
            const shareModal = document.getElementById('shareModal');
            const closeModalButton = document.getElementById('closeModalButton');
            const fileAssocIdInput = document.getElementById('fileAssocId');

            window.addEventListener('load', () => {
                const urlParams = new URLSearchParams(window.location.search);

                if (urlParams.get('initial') == 'true') {
                    const fileAssocId = @json($file_assoc_id)

                    checkSharedUsers(fileAssocId); // Check shared users
                    shareModal.classList.remove('hidden');
                    shareModal.classList.add('block');
                }

            });



            // Hide modal when clicking the Close button
            closeModalButton.addEventListener('click', function() {
                shareModal.classList.remove('block');
                shareModal.classList.add('hidden');
            });

            // Hide modal when clicking outside the modal content
            window.addEventListener('click', function(event) {
                if (event.target === shareModal) {
                    shareModal.classList.remove('block');
                    shareModal.classList.add('hidden');
                }
            });
        });
    </script>
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

        $("#downloadButton").click(async function(e) {
            e.preventDefault();

            // Parse JSON data and metadata
            const jsonData = @json($data);
            const data = JSON.parse(jsonData);
            const colnames = data.metadata.colname; // Array of column names (variables)
            const description = stripHTMLTags(@json($description));
            const note = @json(isset($note) ? strip_tags($note->content) : '');

            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF();

            // PDF Header
            pdf.setFillColor(230, 230, 230);
            pdf.rect(0, 0, pdf.internal.pageSize.width, 30, 'F');
            const logoImage = new Image();
            logoImage.src = "{{ asset('storage/idiot-guid-imgs/logo.png') }}";

            let currentChart = null; // Variable to hold the current chart instance
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


                // Process components dynamically
                for (const component of data.components) {
                    pdf.setFillColor(240, 240, 240);
                    pdf.rect(10, 60, pdf.internal.pageSize.width - 20, 12, 'F');
                    pdf.setFont("helvetica", "bold");
                    pdf.setFontSize(14);
                    pdf.text(`${component} Seasonality`, 12, 68, {
                        maxWidth: pdf.internal.pageSize.width - 24
                    });

                    const labels = component === "weekly" ? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat',
                        'Sun'
                    ] : generateYearlyLabels();

                    const datasets = [];
                    const yAxisConfig = {};


                    colnames.forEach((col, index) => {
                        datasets.push({
                            label: col,
                            data: data.seasonality_per_period[col][component].values,
                            borderColor: `hsl(${(index * 360) / colnames.length}, 70%, 50%)`,
                            fill: false,
                            pointRadius: 0,
                            yAxisID: `y-axis-${index + 1}`,
                        })

                        yAxisConfig[`y-axis-${index + 1}`] = {
                            type: 'linear',
                            position: 'left', // Alternating y-axis sides
                            title: {
                                display: true,
                                text: col
                            },
                        };
                    });
                    // Destroy the current chart instance if it exists
                    if (currentChart) {
                        currentChart.destroy();
                    }

                    // Create a new Chart.js instance
                    currentChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets
                        },
                        options: {
                            responsive: false,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: `${capitalize(component)} Seasonality (${colnames.join(", ")})`
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Date/Time',
                                    }
                                },
                                ...yAxisConfig,
                            }
                        }
                    });

                    // Wait for chart rendering
                    await new Promise(resolve => setTimeout(resolve, 100));
                    const imageData = canvas.toDataURL("image/png");
                    pdf.addImage(imageData, 'PNG', 10, 75, 180, 80);

                    colnames.forEach((col, index) => {
                        pdf.addPage();
                        pdf.setFillColor(240, 240, 240);
                        pdf.rect(10, 20, pdf.internal.pageSize.width - 20, 15, 'F');
                        pdf.setFont("helvetica", "bold");
                        pdf.setFontSize(14);
                        pdf.text(
                            `Key Details on ${component} seasonality of ${col} (AI Generated)`,
                            10, 30);

                        // Key details content with pagination
                        pdf.setFont("helvetica", "normal");
                        pdf.setFontSize(10);

                        let response1 = stripHTMLTags(data.explanations[component][col]
                            .response1);
                        let response2 = stripHTMLTags(data.explanations[component][col]
                            .response2);
                        let keyDetails = response1 + response2;

                        // Split text and paginate
                        const lines = pdf.splitTextToSize(keyDetails, pdf.internal.pageSize
                            .width - 20);
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
                    //add new page
                    pdf.addPage();
                }

                // Notes Section
                pdf.addPage();
                pdf.setFillColor(240, 240, 240);
                pdf.rect(10, 20, pdf.internal.pageSize.width - 20, 15, 'F');
                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(14);
                pdf.text("Notes", 10, 30);

                pdf.setFont("helvetica", "normal");
                pdf.setFontSize(10);

                if (note) {
                    pdf.text(note, 10, 40, {
                        maxWidth: pdf.internal.pageSize.width - 20
                    });
                } else {
                    pdf.text("No notes added", 10, 40);
                }

                pdf.save("report.pdf");
            };
        });

        function generateYearlyLabels() {
            const labels = [];
            const arbitraryYear = 2020; // Arbitrary non-leap year
            let currentDate = new Date(arbitraryYear, 0, 1); // Start at January 1

            while (currentDate.getFullYear() === arbitraryYear) {
                labels.push(currentDate.toDateString()); // Use readable date format
                currentDate.setDate(currentDate.getDate() + 1);
            }

            return labels;
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    </script>


    <script>
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
                        about: "forecast",
                        description: @json($description),
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

        $(document).ready(function() {

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
                        height: 300,
                        animations: {
                            enabled: true
                        },
                        toolbar: {
                            show: true
                        },
                        events: {
                            markerClick: function(event, chartContext, opts) {
                                // Get the series index
                                const selectedVariableIndex = opts.seriesIndex;

                                // Fetch the variable name based on the series index
                                const selectedVariable = data.metadata.colname[selectedVariableIndex];

                                // Get the component currently in view (for example, 'weekly' or 'yearly')
                                const component = document.querySelector(
                                    '#button-container button.bg-blue-500').textContent.toLowerCase();

                                // Update the info card with the selected variable's explanation
                                updateInfoCard(component, selectedVariable);


                                // Update the variable buttons to reflect the selected variable
                                updateVariableButtonStyles(selectedVariable);
                            }

                        }
                    },
                    // title: {
                    //     text: 'Seasonality Result',
                    //     align: 'left',
                    //     style: {
                    //         fontSize: '18px', // Font size of the title
                    //         color: '#263238' // Color of the title
                    //     }
                    // },
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
                button.classList.add('font-bold', 'py-2', 'px-4', 'rounded', 'focus:outline-none', 'bg-white',
                    'text-blue-500',
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
                // let explanation = data.explanations[component][variable].response1 + "<br>" + data.explanations[
                //     component][variable].response2 || "No explanation available.";
                let explanation = data.explanations[component][variable].response1 + "<br>" + data.explanations[
                    component][variable].response2 || "No explanation available.";
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
                        updateVariableButtonStyles(
                            variable); // Update button styles on variable selection
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
        });
    </script>
@endsection
