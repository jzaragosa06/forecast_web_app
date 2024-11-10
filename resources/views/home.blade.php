@extends('layouts.base')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')


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
    @elseif (session('upload_failed'))
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('upload_failed') }}
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

    <!-- Multi-Step Guide Modal -->
    <div id="guideModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <!-- Added hidden class here -->
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl w-full z-50">
            <h2 class="text-2xl font-semibold text-gray-600 mb-6">Getting Started Guide</h2>
            <!-- Guide Step Content -->
            <div id="guideSteps" class="text-gray-600 flex flex-col items-center">
                <!-- Image for Each Step -->
                <img id="guideImage" src="" alt="Guide Step Image" class="w-2/3 mb-6 rounded-lg shadow-md">
                <!-- Step Text -->
                <div id="guideText" class="text-base text-center">
                    <!-- Placeholder for Step Content -->
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-end mt-6 space-x-4">
                <button id="backButton" onclick="prevStep()"
                    class="hidden bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-6 rounded">
                    Back
                </button>
                <button id="nextButton" onclick="nextStep()"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Next
                </button>
            </div>
        </div>
    </div>
    <!--Script Multi-Step Guide Modal -->
    <script>
        // JavaScript for Step-by-Step Guide with Images
        const steps = [{
                text: "Welcome! Are you ready to know more about your data? This guide will help you get started.",
                img: "{{ asset('storage/idiot-guid-imgs/welcome1.png') }}"
            },
            {
                text: "Step 1: This panel allows you to upload your time series data or get from third party source.",
                img: "{{ asset('storage/idiot-guid-imgs/data-source.png') }}"
            },
            {
                text: "Step 2: Once you uploaded the time series data or fetched from a third-party source, you will be prompted to fill missing values. In this part, it is crucial to describe what the data is about, as it will be used by AI to explain the result.",
                img: "{{ asset('storage/idiot-guid-imgs/cleaning.png') }}"
            },
            {
                text: "Step 3: This panel allows you to select the file containing the time series data and define the operation you want to perform, i.e. trend analysis, seasonality analysis, or perform forecast.",
                img: "{{ asset('storage/idiot-guid-imgs/analyze.png') }}"
            },
            {
                text: "Step 4: The result page includes the graph of the results. It also includes the AI-generated explanation of the result, a chat with AI feature, and integrated notes.",
                img: "{{ asset('storage/idiot-guid-imgs/forecast.png') }}"
            },
        ];
        let currentStep = 0;

        // Function to display the guide modal after registration
        window.addEventListener('load', () => {
            const urlParams = new URLSearchParams(window.location.search);
            // Check if the registered parameter is true
            if (urlParams.get('registered') === 'true') {
                document.getElementById('guideModal').classList.remove('hidden'); // Show the modal
                showStep(currentStep); // Show the first step
            } else {
                closeModal(); // Hide the modal if not registered
            }
        });

        // Function to show the current step
        function showStep(step) {
            const guideText = document.getElementById('guideText');
            const guideImage = document.getElementById('guideImage');
            const nextButton = document.getElementById('nextButton');
            const backButton = document.getElementById('backButton');

            // Update the text and image based on the current step
            guideText.textContent = steps[step].text;
            guideImage.src = steps[step].img;
            // Show or hide the Back button based on the step
            backButton.classList.toggle('hidden', step === 0);

            // Adjust button text for "Start" on welcome step and "Got it!" on the last step
            nextButton.textContent = step === 0 ? 'Start' : (step === steps.length - 1 ? 'Got it!' : 'Next');
        }

        // Function to move to the next step
        function nextStep() {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            } else {
                closeModal(); // Close modal on the last step
            }
        }

        // Function to move to the previous step
        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('guideModal').classList.add('hidden');
        }
    </script>




    <!-- Main Content -->
    <div class="container mx-auto my-6">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Left Side - Two horizontal blocks -->
                <div class="bg-gray-50 col-span-3 space-y-4 h-full w-full">
                    <div class="overflow-auto bg-white rounded-lg">
                        <!-- Major Controls in Time Sereis Analysis -->
                        <div class="w-full max-w-full">
                            <div class="flex space-x-4">
                                <!-- Add Data -->
                                <div class="w-full sm:w-1/2 md:w-1/3 px-2">
                                    <!-- Added px-2 for padding and sm:w-1/2 for better layout on smaller screens -->
                                    <div class="border bg-white p-4 rounded-lg shadow-md h-full flex flex-col">
                                        <h4 class="text-base font-semibold mb-2 text-gray-700">Add Data</h4>
                                        <div class="space-y-4"> <!-- Adjusted space-y for better spacing -->
                                            <!-- Upload Data Button -->
                                            <div class="flex items-center space-x-2">
                                                <p class="text-gray-600 text-xs flex-grow">Upload your time
                                                    series
                                                    data in <a href="{{ route('documentation') }}"
                                                        class="text-gray-600  text-xshover:text-blue-500 underline hover:underline">
                                                        csv format
                                                    </a>.
                                                </p>

                                                <button type="button" id="ts-info"
                                                    class="flex items-center bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 w-28 sm:w-32 md:w-full">
                                                    <!-- Adjusted width on smaller screens -->
                                                    <i class="fas fa-upload text-white"></i>
                                                    <span class="ml-2 text-xs">Upload</span>
                                                </button>
                                            </div>

                                            <!-- Meteorological Data Button -->
                                            <div class="flex items-center space-x-2">
                                                <p class="text-gray-600 text-xs flex-grow ">Get daily time
                                                    series weather data anywhere </p>
                                                <button type="button" id="ts-add-via-api-open-meteo-btn"
                                                    class="flex items-center bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 w-28 sm:w-32 md:w-full">
                                                    <!-- Adjusted width on smaller screens -->
                                                    <i class="fas fa-cloud-sun text-white"></i>

                                                    <span class="ml-2 text-xs">Weather</span>
                                                </button>
                                            </div>

                                            <!-- Stocks Data Button -->
                                            <div class="flex items-center space-x-2">
                                                <p class="text-gray-600 text-xs flex-grow ">Get latest basic
                                                    time
                                                    series stock market data</p>
                                                <button type="button" id="ts-add-via-api-stocks-btn"
                                                    class="flex items-center bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 w-28 sm:w-32 md:w-full">
                                                    <!-- Adjusted width on smaller screens -->
                                                    <i class="fas fa-dollar-sign text-white"></i>
                                                    <span class="ml-2 text-xs">Stocks</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Analyze data-->
                                <div class="w-full md:w-1/3">
                                    <div class="border bg-white p-4 rounded-lg shadow-md h-full flex flex-col">
                                        <h4 class="text-base font-semibold mb-2 text-gray-700">Analyze Data</h4>

                                        <form id="analyze-form1" action="{{ route('manage.operations') }}" method="post"
                                            class="flex-grow">
                                            @csrf
                                            <!-- First Select File -->
                                            <div class="mb-4 relative">
                                                <label for="file_id"
                                                    class="block text-xs font-medium mb-1 text-gray-600">Select File</label>
                                                <div class="flex items-center">
                                                    <select name="file_id" id="file_id"
                                                        class="form-select text-sm border-2 border-gray-300 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                        @foreach (Auth::user()->files as $file)
                                                            <option value="{{ $file->file_id }}">{{ $file->filename }}
                                                            </option>
                                                        @endforeach
                                                        <option value="" id="add-more-from-option">Add more data +
                                                        </option>
                                                    </select>
                                                    <i id="file-info"
                                                        class="fas fa-sm fa-info-circle text-gray-400 ml-2 cursor-pointer"
                                                        data-tooltip="Select the file you want to analyze."></i>

                                                </div>
                                            </div>

                                            <!-- Second Select File -->
                                            <div class="mb-4 relative">
                                                <label for="operation"
                                                    class="block text-xs font-medium mb-1 text-gray-600">Select
                                                    Operation</label>
                                                <div class="flex items-center">
                                                    <select name="operation" id="operation"
                                                        class="form-select text-sm border-2 border-gray-300 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                        <option value="trend">Analyze Trend</option>
                                                        <option value="seasonality">Analyze Seasonality</option>
                                                        <option value="forecast">Perform Forecast</option>
                                                    </select>
                                                    <i id="operation-info"
                                                        class="fas fa-sm fa-info-circle text-gray-400 ml-2 cursor-pointer"
                                                        data-tooltip="Select the operation you want to the selected file above."></i>
                                                </div>
                                            </div>

                                            <div class="flex justify-end mt-4"> <!-- Add this div for alignment -->
                                                <button type="submit"
                                                    class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                                    <i class="fas fa-chart-line text-white"></i>
                                                    <!-- Changed icon for analysis -->
                                                    <span class="ml-2 text-xs">Analyze</span> <!-- Reduced font size -->
                                                </button>
                                            </div>

                                            <div id="loadingModal1"
                                                class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
                                                <div
                                                    class="modal-content bg-gray-800 p-6 rounded-lg shadow-lg flex items-center justify-center">
                                                    <div
                                                        class="loader border-t-transparent border-solid animate-spin rounded-full border-blue-500 border-4 h-12 w-12">
                                                    </div>
                                                    <span class="ml-4 text-white">Processing...</span>
                                                </div>
                                            </div>

                                            <script>
                                                $(document).ready(function() {
                                                    $('#analyze-form1').on('submit', function(e) {
                                                        // Show the modal
                                                        $('#loadingModal1').removeClass('hidden');

                                                        // Allow the form to submit
                                                        return true;
                                                    });

                                                    // Prevent modal from closing when clicking outside of the modal content
                                                    $('#loadingModal1').on('click', function(e) {
                                                        // Only allow clicks outside the modal content to trigger event blocking
                                                        if (!$(e.target).closest('.modal-content').length) {
                                                            e.stopPropagation(); // Prevent the modal from closing
                                                        }
                                                    });
                                                });
                                            </script>
                                        </form>
                                    </div>
                                </div>
                                <!-- Recent Results -->
                                <div class="w-full md:w-1/3">
                                    <div class="border bg-white p-4 rounded-lg shadow-md h-full flex flex-col">
                                        <h4 class="text-base font-semibold mb-2 text-gray-700">Recent Results</h4>
                                        <div class="flex-grow">
                                            @if ($file_assocs->isEmpty())
                                                <p class="text-gray-500 text-xs text-center">No recent results found.</p>
                                            @else
                                                <ul class="space-y-2">
                                                    @foreach ($file_assocs->slice(0, 5) as $index => $file_assoc)
                                                        <li class="flex items-center mb-2">
                                                            <!-- Number indicator -->
                                                            <span
                                                                class="w-6 h-6 bg-blue-600 text-white flex items-center justify-center  mr-3">
                                                                {{ $index + 1 }}
                                                            </span>

                                                            <a href="{{ route('manage.results.get', $file_assoc->file_assoc_id) }}"
                                                                class="text-gray-700 text-xs hover:underline truncate">
                                                                {{ $file_assoc->assoc_filename }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>

                                        @if ($file_assocs->count() > 5)
                                            <div class="mt-2 text-center">
                                                <a href="{{ route('crud.index') }}"
                                                    class="text-blue-600 text-sm hover:underline font-semibold">
                                                    View More
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div>
                            <!-- Buttons for switching inputs -->

                            <div class="flex items-center space-x-2 p-4"> <!-- Center items and reduce space -->
                                <!-- Uploaded Data Button -->
                                <button id="input-via-uploads-Btn"
                                    class="bg-blue-600 text-white border border-blue-600 px-3 py-1 rounded-md text-sm">
                                    Uploaded Data
                                </button>
                                <!-- Weather Data Button -->
                                <button id="input-via-openmeteo-Btn"
                                    class="bg-white text-blue-600 border border-blue-600 px-3 py-1 rounded-md text-sm">
                                    Weather Data
                                </button>
                                <!-- Stocks Data Button -->
                                <button id="input-via-stocks-Btn"
                                    class="bg-white text-blue-600 border border-blue-600 px-3 py-1 rounded-md text-sm">
                                    Stocks Data
                                </button>
                                <!-- Info Icon -->
                                <i id="data-info" class="fas fa-sm fa-info-circle text-gray-400 cursor-pointer ml-2"
                                    data-tooltip="These are buttons for displaying specific type of data"></i>
                            </div>

                            <!-- Graphs and description for uploads -->
                            <div id="input-via-uploads-Container" class="">
                                <div class="container mx-auto p-4">
                                    @php
                                        // Filter the timeSeriesData to check for 'uploads' source
                                        $uploadsExist = false;
                                        foreach ($files as $index => $fileData) {
                                            if ($files[$index]->source == 'uploads') {
                                                $uploadsExist = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    @if ($uploadsExist)
                                        <!-- Loop through timeSeriesData if there is data from 'uploads' -->
                                        @foreach ($timeSeriesData as $index => $fileData)
                                            @if ($files[$index]->source == 'uploads')
                                                <div class="bg-white border rounded-lg shadow-md mb-4">
                                                    <div class="p-4">
                                                        <div class="flex">
                                                            <!-- Left Section (Title, Type, Frequency, etc.) -->
                                                            <div
                                                                class="w-full lg:w-1/3 bg-gray-100 p-4 rounded-lg flex flex-col">
                                                                <h4
                                                                    class="text-base font-semibold mb-2 text-gray-700 hover:text-blue-600">

                                                                    <a
                                                                        href="{{ route('input.file.graph.view.post', $files[$index]->file_id) }}">{{ $files[$index]->filename }}
                                                                    </a>
                                                                </h4>
                                                                <p class="text-xs mb-1">Type: {{ $files[$index]->type }}
                                                                </p>
                                                                <p class="text-xs mb-1">Frequency:
                                                                    {{ $files[$index]->freq }}</p>

                                                                <!-- Description section -->
                                                                <div class="bg-gray-200 flex-grow p-4 rounded-lg">
                                                                    <p class="text-xs mb-1">
                                                                        {{ $files[$index]->description }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Right Section (Dropdown and Graph) -->
                                                            <div
                                                                class="w-full lg:w-2/3 flex flex-col justify-start items-end relative bg-gray-50 p-4 rounded-lg">
                                                                <!-- Dropdown with Icon -->
                                                                <div class="relative">
                                                                    <button id="dropdownButton-{{ $index }}"
                                                                        class="text-gray-600 hover:text-gray-800 focus:outline-none">
                                                                        <!-- Icon (using Heroicons for example) -->
                                                                        <svg class="w-6 h-6" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M19 9l-7 7-7-7"></path>
                                                                        </svg>
                                                                    </button>

                                                                    <!-- Dropdown Menu -->
                                                                    <div id="dropdownMenu-{{ $index }}"
                                                                        class="hidden absolute right-0 bg-white shadow-md rounded-lg mt-2 w-48 z-10">
                                                                        <ul class="py-2 text-sm text-gray-700">

                                                                            <a
                                                                                href="{{ route('seqal.index', $files[$index]->file_id) }}">
                                                                                <li
                                                                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                                                    Series Alignment
                                                                                </li>
                                                                            </a>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                                <!-- Graph Container -->
                                                                <div class="graph-container mt-4 w-full"
                                                                    style="height: 300px;">
                                                                    <div id="graph-{{ $index }}"
                                                                        style="height: 100%; background-color: #f9fafb;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <!-- Display if no 'uploads' data is found -->
                                        <div class="bg-white border rounded-lg shadow-md mb-4 p-4 text-center">
                                            <p class="text-lg font-semibold text-gray-600">No data exists</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Graphs and description for open-meteo -->
                            <div id="input-via-openmeteo-Container" class="hidden">
                                <div class="container mx-auto p-4">
                                    @php
                                        // Filter the timeSeriesData to check for 'uploads' source
                                        $uploadsExist = false;
                                        foreach ($files as $index => $fileData) {
                                            if ($files[$index]->source == 'open-meteo') {
                                                $uploadsExist = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    @if ($uploadsExist)
                                        <!-- Loop through timeSeriesData if there is data from 'uploads' -->
                                        @foreach ($timeSeriesData as $index => $fileData)
                                            @if ($files[$index]->source == 'open-meteo')
                                                <div class="bg-white border rounded-lg shadow-md mb-4">
                                                    <div class="p-4">
                                                        <div class="flex">
                                                            <!-- Left Section (Title, Type, Frequency, etc.) -->
                                                            <div
                                                                class="w-full lg:w-1/3 bg-gray-100 p-4 rounded-lg flex flex-col">
                                                                <h4
                                                                    class="text-base font-semibold mb-2 text-gray-700 hover:text-blue-600">

                                                                    <a
                                                                        href="{{ route('input.file.graph.view.post', $files[$index]->file_id) }}">{{ $files[$index]->filename }}
                                                                    </a>
                                                                </h4>
                                                                <p class="text-xs mb-1">Type: {{ $files[$index]->type }}
                                                                </p>
                                                                <p class="text-xs mb-1">Frequency:
                                                                    {{ $files[$index]->freq }}</p>

                                                                <!-- Description section -->
                                                                <div class="bg-gray-200 flex-grow p-4 rounded-lg">
                                                                    <p class="text-xs mb-1">
                                                                        {{ $files[$index]->description }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Right Section (Dropdown and Graph) -->
                                                            <div
                                                                class="w-full lg:w-2/3 flex flex-col justify-start items-end relative bg-gray-50 p-4 rounded-lg">
                                                                <!-- Dropdown with Icon -->
                                                                <div class="relative">
                                                                    <button id="dropdownButton-{{ $index }}"
                                                                        class="text-gray-600 hover:text-gray-800 focus:outline-none">
                                                                        <!-- Icon (using Heroicons for example) -->
                                                                        <svg class="w-6 h-6" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M19 9l-7 7-7-7"></path>
                                                                        </svg>
                                                                    </button>

                                                                    <!-- Dropdown Menu -->
                                                                    <div id="dropdownMenu-{{ $index }}"
                                                                        class="hidden absolute right-0 bg-white shadow-md rounded-lg mt-2 w-48 z-10">
                                                                        <ul class="py-2 text-sm text-gray-700">
                                                                            {{-- <li
                                                                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                                                Analyze
                                                                                trend
                                                                            </li>
                                                                            <li
                                                                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                                                Seasonality
                                                                            </li>
                                                                            <li
                                                                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                                                Forecast
                                                                            </li> --}}
                                                                            <a
                                                                                href="{{ route('seqal.index', $files[$index]->file_id) }}">
                                                                                <li
                                                                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                                                    Series
                                                                                    Alignment</li>
                                                                            </a>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                                <!-- Graph Container -->
                                                                <div class="graph-container mt-4 w-full"
                                                                    style="height: 300px;">
                                                                    <div id="graph-{{ $index }}"
                                                                        style="height: 100%; background-color: #f9fafb;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <!-- Display if no 'uploads' data is found -->
                                        <div class="bg-white border rounded-lg shadow-md mb-4 p-4 text-center">
                                            <p class="text-lg font-semibold text-gray-600">No data exists</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Graphs and description for stocks -->
                            <div id="input-via-stocks-Container" class="hidden">
                                <div class="container mx-auto p-4">
                                    @php
                                        // Filter the timeSeriesData to check for 'uploads' source
                                        $uploadsExist = false;
                                        foreach ($files as $index => $fileData) {
                                            if ($files[$index]->source == 'stocks') {
                                                $uploadsExist = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    @if ($uploadsExist)
                                        <!-- Loop through timeSeriesData if there is data from 'uploads' -->
                                        @foreach ($timeSeriesData as $index => $fileData)
                                            @if ($files[$index]->source == 'stocks')
                                                <div class="bg-white border rounded-lg shadow-md mb-4">
                                                    <div class="p-4">
                                                        <div class="flex">
                                                            <!-- Left Section (Title, Type, Frequency, etc.) -->
                                                            <div
                                                                class="w-full lg:w-1/3 bg-gray-100 p-4 rounded-lg flex flex-col">
                                                                <h4
                                                                    class="text-base font-semibold mb-2 text-gray-700 hover:text-blue-600">

                                                                    <a
                                                                        href="{{ route('input.file.graph.view.post', $files[$index]->file_id) }}">{{ $files[$index]->filename }}
                                                                    </a>
                                                                </h4>
                                                                <p class="text-xs mb-1">Type: {{ $files[$index]->type }}
                                                                </p>
                                                                <p class="text-xs mb-1">Frequency:
                                                                    {{ $files[$index]->freq }}</p>

                                                                <!-- Description section -->
                                                                <div class="bg-gray-200 flex-grow p-4 rounded-lg">
                                                                    <p class="text-xs mb-1">
                                                                        {{ $files[$index]->description }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Right Section (Dropdown and Graph) -->
                                                            <div
                                                                class="w-full lg:w-2/3 flex flex-col justify-start items-end relative bg-gray-50 p-4 rounded-lg">
                                                                <!-- Dropdown with Icon -->
                                                                <div class="relative">
                                                                    <button id="dropdownButton-{{ $index }}"
                                                                        class="text-gray-600 hover:text-gray-800 focus:outline-none">
                                                                        <!-- Icon (using Heroicons for example) -->
                                                                        <svg class="w-6 h-6" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M19 9l-7 7-7-7"></path>
                                                                        </svg>
                                                                    </button>

                                                                    <!-- Dropdown Menu -->
                                                                    <div id="dropdownMenu-{{ $index }}"
                                                                        class="hidden absolute right-0 bg-white shadow-md rounded-lg mt-2 w-48 z-10">
                                                                        <ul class="py-2 text-sm text-gray-700">
                                                                            {{-- <li
                                                                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                                                Analyze
                                                                                trend
                                                                            </li>
                                                                            <li
                                                                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                                                Seasonality
                                                                            </li>
                                                                            <li
                                                                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                                                Forecast
                                                                            </li> --}}
                                                                            <a
                                                                                href="{{ route('seqal.index', $files[$index]->file_id) }}">
                                                                                <li
                                                                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                                                    Series
                                                                                    Alignment</li>
                                                                            </a>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                                <!-- Graph Container -->
                                                                <div class="graph-container mt-4 w-full"
                                                                    style="height: 300px;">
                                                                    <div id="graph-{{ $index }}"
                                                                        style="height: 100%; background-color: #f9fafb;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <!-- Display if no 'uploads' data is found -->
                                        <div class="bg-white border rounded-lg shadow-md mb-4 p-4 text-center">
                                            <p class="text-lg font-semibold text-gray-600">No data exists</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right side - one vertical block -->
                <div class="border bg-gray-50 p-2 rounded-lg shadow-md h-full flex flex-col mt-4 md:mt-0">
                    <div class="flex items-center mb-2">
                        <h2 class="text-base font-semibold text-gray-700">Public Discussion</h2>
                        <i id="public-discussion-info" class="fas fa-sm fa-info-circle text-gray-400 ml-2 cursor-pointer"
                            data-tooltip="This shows the recently posted discussions"></i>
                    </div>

                    <!-- Added mt-4 for spacing on small screens -->
                    @if ($otherPosts->isEmpty())
                        <p class="text-sm text-gray-500">No posts available from other users.</p>
                    @else
                        <div id="other-posts-container" class="space-y-3">
                            @foreach ($otherPosts as $post)
                                <div
                                    class="bg-white p-3 rounded-lg shadow hover:shadow-md transition relative max-w-full overflow-hidden">
                                    <!-- Add a blue arrow icon at the top-right -->
                                    <a href="{{ route('posts.show', $post) }}"
                                        class="absolute top-3 right-3 text-blue-600">
                                        <!-- Arrow icon or content goes here -->
                                    </a>

                                    <div>
                                        <div>
                                            <img id="profileImage"
                                                src="{{ $post->post_image ? asset('storage/' . $post->post_image) : 'https://dotdata.com/wp-content/uploads/2020/07/time-series.jpg' }}"
                                                class="w-75 h-25 object-cover mr-2" alt="Profile Photo">
                                        </div>
                                        <!-- Post title and other details -->
                                        <h5 class="text-base font-semibold mb-2 text-gray-600">
                                            <a href="{{ route('posts.show', $post) }}"
                                                class="hover:text-blue-600 break-words overflow-hidden">{{ $post->title }}</a>
                                        </h5>

                                        <!-- Flex container for profile image and posted by text -->
                                        <div class="flex items-center mb-2">
                                            <img id="profileImage"
                                                src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                                class="w-5 h-5 object-cover rounded-full mr-2" alt="Profile Photo">
                                            <p class="text-xs text-gray-500">Posted by: {{ $post->user->name }}</p>
                                        </div>

                                        <!-- Post body with overflow control -->
                                        <p class="text-sm text-gray-500 break-words overflow-hidden">
                                            {{ Str::limit(strip_tags($post->body), 100, '...') }}
                                        </p>
                                    </div>

                                    <!-- Topics section -->
                                    <div class="flex flex-wrap mt-2">
                                        @foreach (explode(',', $post->topics) as $topic)
                                            <span
                                                class="bg-gray-200 text-gray-800 text-xs font-medium mr-2 mb-2 px-2 py-1 rounded">
                                                {{ $topic }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>


    <!-- Forecast modal -->
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" id="forecast-modal"
        style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Forecast Settings</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form id="analyze-form2" action="{{ route('manage.operations') }}" method="POST">
                    @csrf
                    <input type="hidden" name="file_id" id="modal_file_id">
                    <input type="hidden" name="operation" value="forecast">



                    <div class="mb-4">
                        <!-- Label and Icon Wrapper -->
                        <div class="flex items-center">
                            <label for="horizon" class="text-sm font-medium">Forecast Horizon</label>

                            <!-- Icon and Tooltip Wrapper -->
                            <div class="relative inline-block ml-2 group">
                                <i id="horizon-info" class="fas fa-sm fa-info-circle text-gray-400 cursor-pointer"></i>
                                <div
                                    class="absolute left-full top-0 ml-2 hidden z-50 bg-black py-1.5 px-3 font-sans text-sm font-normal text-white group-hover:block whitespace-normal break-words w-48">
                                    Forecast horizon is the number of steps you want to forecast. Given a daily interval of
                                    data (D), 12 forecasts the next 12 days.
                                </div>

                            </div>
                        </div>

                        <input type="number" name="horizon" id="horizon"
                            class="form-input block w-full border-2 border-gray-400 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-2"
                            placeholder="e.g., 12" required>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Run
                        Forecast</button>
                </form>
            </div>
        </div>
    </div>

    <!--Forecast -- Loading indicator for forecast -->
    <div id="loadingModal2" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
        <div class="modal-content bg-gray-800 p-6 rounded-lg shadow-lg flex items-center justify-center">
            <div
                class="loader border-t-transparent border-solid animate-spin rounded-full border-blue-500 border-4 h-12 w-12">
            </div>
            <span class="ml-4 text-white">Processing...</span>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#analyze-form2').on('submit', function(e) {
                // Hide the forecast modal
                $('#forecast-modal').hide();

                // Show the loading modal
                $('#loadingModal2').removeClass('hidden');

                // Allow the form to submit
                return true;
            });

            // Prevent modal from closing when clicking outside of the modal content
            $('#loadingModal2').on('click', function(e) {
                // Only allow clicks outside the modal content to trigger event blocking
                if (!$(e.target).closest('.modal-content').length) {
                    e.stopPropagation(); // Prevent the modal from closing
                }
            });
        });
    </script>


    <!-- Upload Modal -->
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" id="ts-info-form"
        style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Information About the Time Series Data</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('upload.ts') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium mb-1">Upload from Device</label>
                        <input type="file" name="file" id="file"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm"
                            accept=".csv, .xls, .xlsx">
                    </div>

                    <div class="mb-4">
                        <!-- Label and Icon Wrapper -->
                        <div class="flex items-center">
                            <label for="description" class="text-sm font-medium">Description:</label>

                            <!-- Icon and Tooltip Wrapper -->
                            <div class="relative inline-block ml-2 group">
                                <i id="description-info"
                                    class="fas fa-sm fa-info-circle text-gray-400 cursor-pointer"></i>

                                <!-- Tooltip -->
                                <div
                                    class="absolute left-full top-0 ml-2 hidden z-50 bg-black py-1.5 px-3 font-sans text-sm font-normal text-white group-hover:block whitespace-normal break-words w-48">
                                    Describe what this data is about. Describe its background, and especially, describe the
                                    variables.
                                </div>
                            </div>
                        </div>

                        <textarea name="description" id="description" cols="10" rows="5"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm mt-2" required
                            placeholder="E.g., The given time series is about the monthly gasoline prices (in $) in United States."></textarea>
                    </div>


                    <div class="flex justify-between">
                        <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
                            data-dismiss="modal">Close</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Fetch data from open-meteo modal -->
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden"
        id="ts-add-via-api-open-meteo-modal" style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-2/3">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Open Meteo</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body  overflow-y-auto max-h-[75vh]">
                <form action="" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        @php
                            // Get all weather options from the config
                            $weatherOptions = config('weather_options.daily');

                            // Split the options into two groups
                            $halfCount = ceil(count($weatherOptions) / 2);
                            $firstHalf = array_slice($weatherOptions, 0, $halfCount, true);
                            $secondHalf = array_slice($weatherOptions, $halfCount, null, true);
                        @endphp

                        {{-- First Column --}}
                        <div>
                            @foreach ($firstHalf as $key => $label)
                                <div class="flex items-center mb-2">
                                    <input class="form-checkbox" type="checkbox" id="{{ $key }}"
                                        name="daily" value="{{ $key }}">
                                    <label class="ml-2" for="{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>

                        {{-- Second Column --}}
                        <div>
                            @foreach ($secondHalf as $key => $label)
                                <div class="flex items-center mb-2">
                                    <input class="form-checkbox" type="checkbox" id="{{ $key }}"
                                        name="daily" value="{{ $key }}">
                                    <label class="ml-2" for="{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    {{-- <div class="mb-4">
                        <!-- Date Pickers -->
                        <label for="start-date" class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" id="start-date"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="end-date" class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" id="end-date"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div> --}}

                    <div class="mb-4">
                        <!-- Date Pickers -->
                        <label for="start-date" class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" id="start-date"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" max="" required>
                    </div>
                    <div class="mb-4">
                        <label for="end-date" class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" id="end-date"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" max="" required>
                    </div>



                    <div class="mb-4">
                        <!-- Map Display -->
                        <button type="button" id="use-current-loc-btn"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-all">
                            Use Current Location
                        </button>
                        <button type="button" id="get-from-maps-btn"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-all">
                            Open Map
                        </button>

                        <div id="map" class="mt-4 h-96 hidden"></div>
                        <p id="selected-location" class="mt-2 text-white text-sm">Latitude: <span id="lat"></span>,
                            Longitude:
                            <span id="long"></span>
                        </p>
                    </div>




                    <!-- Date Pickers and other elements -->
                    <button id="fetch-data-open-meteo-btn" type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Fetch</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Stocks Modal -->
    <div id="ts-add-via-api-stocks-modal"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40 hidden" style="display:none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md md:max-w-lg">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-semibold text-gray-800">Stock Market Data</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>

            <div class="modal-body">
                <!-- Stock selection using Combo Box (Input + Datalist) -->
                <div class="flex flex-col space-y-6">
                    <div class="space-y-2">
                        <!-- Stock Combo Box -->
                        <div>
                            <label for="stock-selection" class="block text-sm font-medium text-gray-700">Select or Enter
                                Stock</label>
                            <input list="stocks" id="stock-selection" name="stock-selection"
                                class="w-full mt-1 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                placeholder="Enter stock symbol or select from the list">
                            <datalist id="stocks">
                                @foreach (config('stock_options.stocks') as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        <!-- Date Range -->
                        <div class="flex space-x-4">
                            <!-- Start Date -->
                            <div class="w-1/2">
                                <label for="start-date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start-date-stocks" max=""
                                    class="w-full mt-1 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            <!-- End Date -->
                            <div class="w-1/2">
                                <label for="end-date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end-date-stocks" max=""
                                    class="w-full mt-1 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                        </div>




                    </div>

                    <!-- Interval Dropdown -->
                    <div>
                        <label for="interval" class="block text-sm font-medium text-gray-700">Interval</label>
                        <select id="interval"
                            class="w-full mt-1 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="1day">1 Day</option>
                            <option value="1week">1 Week</option>
                            <option value="1month">1 Month</option>
                        </select>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end mt-6 space-x-4">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
                        data-dismiss="modal">Close</button>
                    <button id="fetch-data-stocks" type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Fetch</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // JavaScript to set the max attribute to today's date
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split("T")[0];
            document.getElementById("start-date").setAttribute("max", today);
            document.getElementById("end-date").setAttribute("max", today);
            document.getElementById("start-date-stocks").setAttribute("max", today);
            document.getElementById("end-date-stocks").setAttribute("max", today);
        });
    </script>

    <!-- Tooltip Implementation -->
    <style>
        .tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.75);
            color: white;
            border-radius: 4px;
            padding: 5px;
            font-size: 0.75rem;
            z-index: 10;
            white-space: nowrap;
            display: none;
        }
    </style>
    <div class="tooltip" id="tooltip"></div>

    <script>
        $(document).ready(function() {
            const tooltip = $('#tooltip');

            // Function to show the tooltip
            function showTooltip(event) {
                tooltip.text($(this).data('tooltip'));
                tooltip.css({
                    top: event.pageY + 10 + 'px',
                    left: event.pageX + 10 + 'px',
                });
                tooltip.show();
            }

            // Function to hide the tooltip
            function hideTooltip() {
                tooltip.hide();
            }

            // Attach events to the info icons
            $('#file-info').on('mouseenter', showTooltip).on('mouseleave', hideTooltip);
            $('#operation-info').on('mouseenter', showTooltip).on('mouseleave', hideTooltip);
            $('#public-discussion-info').on('mouseenter', showTooltip).on('mouseleave', hideTooltip);
            $('#data-info').on('mouseenter', showTooltip).on('mouseleave', hideTooltip);
            $('#description-info').on('mouseenter', showTooltip).on('mouseleave', hideTooltip);
        });
    </script>
    <script>
        // Toggle dropdown visibility
        document.querySelectorAll('[id^=dropdownButton-]').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.id.split('-')[1];
                const dropdownMenu = document.getElementById('dropdownMenu-' + index);
                dropdownMenu.classList.toggle('hidden');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const uploadsBtn = document.getElementById('input-via-uploads-Btn');
            const openmeteoBtn = document.getElementById('input-via-openmeteo-Btn');
            const stocksBtn = document.getElementById('input-via-stocks-Btn');
            const uploadsContainer = document.getElementById('input-via-uploads-Container');
            const openmeteoContainer = document.getElementById('input-via-openmeteo-Container');
            const stocksContainer = document.getElementById('input-via-stocks-Container');

            // Function to reset button styles
            function resetButtons() {
                uploadsBtn.classList.add('bg-white', 'text-blue-600');
                uploadsBtn.classList.remove('bg-blue-600', 'text-white');

                openmeteoBtn.classList.add('bg-white', 'text-blue-600');
                openmeteoBtn.classList.remove('bg-blue-600', 'text-white');

                stocksBtn.classList.add('bg-white', 'text-blue-600');
                stocksBtn.classList.remove('bg-blue-600', 'text-white');
            }

            // Function to hide all containers
            function hideAllContainers() {
                uploadsContainer.classList.add('hidden');
                openmeteoContainer.classList.add('hidden');
                stocksContainer.classList.add('hidden');
            }

            // Event listeners to toggle between buttons and containers
            uploadsBtn.addEventListener('click', () => {
                resetButtons();
                uploadsBtn.classList.add('bg-blue-600', 'text-white');
                uploadsBtn.classList.remove('bg-white', 'text-blue-600');

                hideAllContainers();
                uploadsContainer.classList.remove('hidden');
            });

            openmeteoBtn.addEventListener('click', () => {
                resetButtons();
                openmeteoBtn.classList.add('bg-blue-600', 'text-white');
                openmeteoBtn.classList.remove('bg-white', 'text-blue-600');

                hideAllContainers();
                openmeteoContainer.classList.remove('hidden');
            });

            stocksBtn.addEventListener('click', () => {
                resetButtons();
                stocksBtn.classList.add('bg-blue-600', 'text-white');
                stocksBtn.classList.remove('bg-white', 'text-blue-600');

                hideAllContainers();
                stocksContainer.classList.remove('hidden');
            });
        });

        $(document).ready(function() {
            // Iterate over each file data to create corresponding graphs
            @foreach ($timeSeriesData as $index => $fileData)
                var options = {
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false,
                        }
                    },
                    series: [
                        @for ($i = 1; $i < count($fileData['header']); $i++)
                            {
                                name: '{{ $fileData['header'][$i] }}',
                                data: {!! json_encode(
                                    array_map(function ($row) use ($i) {
                                        return floatval($row['values'][$i - 1]);
                                    }, $fileData['data']),
                                ) !!},
                                yaxis: {{ $i - 1 }}
                            },
                        @endfor
                    ],
                    xaxis: {
                        categories: {!! json_encode(array_column($fileData['data'], 'date')) !!},
                        type: 'datetime'
                    },

                    yaxis: [
                        @for ($i = 1; $i < count($fileData['header']); $i++)
                            {
                                labels: {
                                    show: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                                axisTicks: {
                                    show: false,
                                },

                            },
                        @endfor
                    ],
                    stroke: {
                        curve: 'smooth'
                    },

                    grid: {
                        show: false,
                    }
                };

                var chart = new ApexCharts(document.querySelector("#graph-{{ $index }}"), options);
                chart.render();
            @endforeach
        });

        $(document).ready(function() {
            $('#operation').on('change', function() {
                if ($(this).val() === 'forecast') {
                    $('#forecast-modal').removeClass('hidden').hide().fadeIn(200);
                    $('#forecast-modal > div').removeClass('scale-95').addClass('scale-100');
                    $('#modal_file_id').val($('#file_id').val());
                }
            });

            // Open the 'Add More data' modal when 'Add more data' is selected
            $('#file_id').on('change', function() {
                if ($(this).val() === '') {
                    $('#ts-info-form').modal('show');
                }
            });

            $('#ts-info').click(function() {
                $('#ts-info-form').removeClass('hidden').hide().fadeIn(200);
                $('#ts-info-form > div').removeClass('scale-95').addClass('scale-100');
            });


        });

        $(document).ready(function() {
            let map;
            let marker;
            let lat;
            let lon;

            $('#ts-add-via-api-open-meteo-btn').click(function() {
                $('#ts-add-via-api-open-meteo-modal').removeClass('hidden').hide().fadeIn(200);
                $('#ts-add-via-api-open-meteo-modal > div').removeClass('scale-95').addClass('scale-100');
            });

            // Close modals
            $('[data-dismiss="modal"]').click(function() {
                $(this).closest('.fixed').css('display', 'none');
            });

            // Close modals when clicking outside the modal content
            $('.fixed').click(function(e) {
                if ($(e.target).is(this)) {
                    $(this).fadeOut(200, function() {
                        $(this).addClass('hidden');
                    });
                }
            });



            $(document).ready(function() {
                const $useCurrentLocBtn = $(
                    '#use-current-loc-btn'); // jQuery reference for Use Current Location button
                const $getFromMapsBtn = $('#get-from-maps-btn'); // jQuery reference for Open Map button
                let originalButtonText = $useCurrentLocBtn
                    .html(); // Save original text for Use Current Location button
                let map; // Declare map variable globally
                let marker; // Declare marker variable globally

                function showSpinner($button, loadingText) {
                    // Change button content to show spinner and loading text
                    $button.html(`
                                    <div class="flex items-center justify-center space-x-2">
                                        <div class="animate-spin rounded-full h-5 w-5 border-t-2 border-b-2 border-white"></div>
                                        <span>${loadingText}</span>
                                    </div>
                                `);
                    $button.prop('disabled', true); // Disable button to prevent multiple clicks
                    $button.removeClass('bg-blue-600 hover:bg-blue-700').addClass(
                        'bg-blue-400 cursor-not-allowed');
                }

                function hideSpinner($button, successText, colorClass) {
                    // Revert button content to indicate completion and success
                    $button.html(successText);
                    $button.prop('disabled', false); // Enable button
                    $button.removeClass('bg-blue-400 cursor-not-allowed').addClass(colorClass);
                }

                function resetButtons() {
                    // Reset both buttons to blue color and original text
                    $useCurrentLocBtn.html(originalButtonText).removeClass(
                        'bg-green-600 hover:bg-green-700').addClass('bg-blue-600 hover:bg-blue-700');
                    $getFromMapsBtn.html('Open Map').removeClass('bg-green-600 hover:bg-green-700')
                        .addClass('bg-blue-600 hover:bg-blue-700');
                    $useCurrentLocBtn.prop('disabled', false);
                    $getFromMapsBtn.prop('disabled', false);
                }

                // Geolocation: Use current location
                $useCurrentLocBtn.on('click', function() {
                    resetButtons(); // Reset both buttons to blue
                    showSpinner($useCurrentLocBtn, 'Fetching Location...'); // Show spinner

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            let lat = position.coords.latitude;
                            let lon = position.coords.longitude;

                            console.log(lat);
                            console.log(lon);

                            if (map) {
                                // Update the map's center and place a marker
                                let currentLocation = new google.maps.LatLng(lat, lon);
                                map.setCenter(currentLocation);
                                placeMarkerAndPanTo(currentLocation, map);
                            }

                            // Update the latitude and longitude in the HTML
                            $('#lat').text(lat);
                            $('#long').text(lon);

                            hideSpinner($useCurrentLocBtn,
                                `Location Selected (${lat.toFixed(2)}, ${lon.toFixed(2)})`,
                                'bg-green-600 hover:bg-green-700'
                            ); // Hide spinner and indicate success
                        }, function(error) {
                            console.error("Error retrieving location: ", error);
                            resetButtons(); // Reset both buttons on error
                        });
                    } else {
                        alert("Geolocation is not supported by this browser.");
                    }
                });

                // Button to open the map
                $getFromMapsBtn.on('click', function() {
                    if ($('#map').is(':visible')) {
                        // If the map is already open, close it and reset buttons
                        $('#map').hide();
                        resetButtons();
                        return;
                    }

                    resetButtons(); // Reset both buttons to blue
                    showSpinner($getFromMapsBtn, 'Loading Map...'); // Show spinner

                    // Show map
                    $('#map').css('display', 'block');

                    // Initialize Google Map
                    if (!map) {
                        map = new google.maps.Map(document.getElementById('map'), {
                            center: {
                                lat: -34.397,
                                lng: 150.644
                            }, // Set default center
                            zoom: 8
                        });

                        // Add marker on click
                        map.addListener('click', function(e) {
                            placeMarkerAndPanTo(e.latLng, map);
                        });
                    }

                    // Simulate map loading completion
                    setTimeout(() => {
                        hideSpinner($getFromMapsBtn, 'Map Opened',
                            'bg-green-600 hover:bg-green-700'
                        ); // Hide spinner and indicate success
                    }, 1000); // Simulating delay, you can adjust or remove this as necessary
                });

                // Place a marker on map and pan to it
                function placeMarkerAndPanTo(latLng, map) {
                    if (marker) {
                        marker.setPosition(latLng);
                    } else {
                        marker = new google.maps.Marker({
                            position: latLng,
                            map: map
                        });
                    }
                    map.panTo(latLng);

                    let lat = latLng.lat();
                    let lon = latLng.lng();

                    // Update the latitude and longitude in the form
                    $('#lat').text(lat);
                    $('#long').text(lon);
                }
            });



            // Listen for click event on the fetch button
            $('#fetch-data-open-meteo-btn').on('click', function(e) {
                e.preventDefault();

                // Use jQuery for the button for consistency
                const $button = $('#fetch-data-open-meteo-btn');

                function showSpinner() {
                    // Use jQuery to manipulate button content
                    $button.html(`
                <div class="flex items-center justify-center space-x-2">
                    <div class="animate-spin rounded-full h-5 w-5 border-t-2 border-b-2 border-white"></div>
                    <span>Loading...</span>
                </div>
            `);
                    $button.prop('disabled', true); // Disable button
                    $button.addClass('opacity-50 cursor-not-allowed');
                }

                function hideSpinner() {
                    $button.html('Submit'); // Revert button text
                    $button.prop('disabled', false); // Re-enable button
                    $button.removeClass('opacity-50 cursor-not-allowed');
                }

                showSpinner();


                // Extract latitude and longitude
                let lat = $('#lat').text().trim(); // Assuming lat and long values are stored here
                let long = $('#long').text().trim();

                // Get the selected checkboxes
                let selectedDaily = [];
                $('input[name="daily"]:checked').each(function() {
                    selectedDaily.push($(this).val());
                });

                // If no checkboxes are selected, alert the user
                if (selectedDaily.length === 0) {
                    alert('Please select at least one data field');
                    return;
                }

                // Build the API request URL
                let apiUrl = 'https://archive-api.open-meteo.com/v1/archive';
                let startDate = $('#start-date').val(); // Extracting start date
                let endDate = $('#end-date').val(); // Extracting end date

                let dailyParams = selectedDaily.join(',');

                let requestUrl =
                    `${apiUrl}?latitude=${lat}&longitude=${long}&start_date=${startDate}&end_date=${endDate}&daily=${dailyParams}&timezone=auto`;

                // Send the AJAX request
                $.ajax({
                    url: requestUrl,
                    type: 'GET',
                    success: function(response) {
                        // Handle the response from the server
                        console.log('Data fetched successfully:', response);

                        csvData = generateCSV(response, selectedDaily);
                        console.log("generated csv raw", csvData);

                        // Create a FormData object to send the CSV and other data
                        const blob = new Blob([csvData], {
                            type: 'text/csv'
                        });

                        const formData = new FormData();
                        formData.append('csv_file', blob, 'data.csv');


                        let currentDate = Math.floor(Date.now() / 1000);


                        let type;
                        let freq = 'D';
                        let description =
                            `time sereis data involving ${selectedDaily.join(',')}`;
                        let filename = `${selectedDaily.join('-')}-${currentDate}.csv`;

                        if (selectedDaily.length == 1) {
                            type = "univariate";
                        } else {
                            type = "multivariate";
                        }


                        formData.append('type', type);
                        formData.append('freq', freq);
                        formData.append('description', description);
                        formData.append('filename', filename);
                        formData.append('source', 'open-meteo');

                        $.ajax({
                            url: '{{ route('seqal.tempsave_external') }}', // URL to your Laravel route
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content') // Add CSRF token here
                            },
                            data: formData,
                            processData: false, // Prevent jQuery from automatically transforming the data into a query string
                            contentType: false, // Let the browser set the content type
                            success: function(response) {
                                console.log('Data saved successfully:');
                                hideSpinner();
                                window.location.href = response.redirect_url;
                            },
                            error: function(xhr, status, error) {
                                hideSpinner();
                                console.error('Error saving data:', error);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        hideSpinner();
                        alert('Failed to fetch data. Please try again.');
                    }
                });


                function convertDate(inputDate) {
                    // Parse the input date string into a Date object
                    const parsedDate = new Date(inputDate);

                    // Format the date as MM/dd/yyyy (full year format)
                    const formattedDate = dateFns.format(parsedDate, 'MM/dd/yyyy');
                    return formattedDate;
                }


                function generateCSV(data, selectedVariables) {


                    // Extract time array from the response
                    const timeArray = data.daily.time;

                    // Initialize CSV content with headers
                    let csvContent = 'time,' + selectedVariables.join(',') + '\n';

                    // Loop through each day (time array)
                    for (let i = 0; i < timeArray.length; i++) {
                        // Start each row with the time (date)
                        // let row = [timeArray[i]];
                        let row = [convertDate(timeArray[i])];

                        // For each selected variable, add the corresponding value to the row
                        selectedVariables.forEach(variable => {

                            row.push(data.daily[variable][i]);


                        });

                        // Add the row to CSV content
                        csvContent += row.join(',') + '\n';
                    }

                    return csvContent;
                }



            });

        });

        $(document).ready(function() {
            $('#ts-add-via-api-stocks-btn').click(function() {
                $('#ts-add-via-api-stocks-modal').removeClass('hidden').hide().fadeIn(200);
                $('#ts-add-via-api-stocks-modal > div').removeClass('scale-95').addClass('scale-100');
            });

            // Close modals
            $('[data-dismiss="modal"]').click(function() {
                $(this).closest('.fixed').css('display', 'none');
            });

            // Close modals when clicking outside the modal content
            $('.fixed').click(function(e) {
                if ($(e.target).is(this)) {
                    $(this).fadeOut(200, function() {
                        $(this).addClass('hidden');
                    });
                }
            });


            $('#fetch-data-stocks').click(function(e) {
                e.preventDefault();
                // Use jQuery for the button for consistency
                const $button = $('#fetch-data-stocks');

                function showSpinner() {
                    // Use jQuery to manipulate button content
                    $button.html(`
                <div class="flex items-center justify-center space-x-2">
                    <div class="animate-spin rounded-full h-5 w-5 border-t-2 border-b-2 border-white"></div>
                    <span>Loading...</span>
                </div>
            `);
                    $button.prop('disabled', true); // Disable button
                    $button.addClass('opacity-50 cursor-not-allowed');
                }

                function hideSpinner() {
                    $button.html('Submit'); // Revert button text
                    $button.prop('disabled', false); // Re-enable button
                    $button.removeClass('opacity-50 cursor-not-allowed');
                }

                showSpinner();



                // Fetch the values from the inputs
                const stockSymbol = $('#stock-selection').val(); // Fetch stock symbol input
                const startDate = $('#start-date-stocks').val(); // Extracting start date
                const endDate = $('#end-date-stocks').val(); // Extracting end date
                let interval = $('#interval').val(); // Fetch interval dropdown


                // Validation logic: Check if any field is empty
                if (!stockSymbol) {
                    alert("Stock symbol is required!");
                    $('#stock-selection').focus(); // Focus the empty input
                    return;
                }

                if (!startDate) {
                    alert("Start date is required!");
                    $('#start-date-stocks').focus();
                    return;
                }

                if (!endDate) {
                    alert("End date is required!");
                    $('#end-date-stocks').focus();
                    return;
                }

                if (!interval) {
                    alert("Interval is required!");
                    $('#interval').focus();
                    return;
                }

                // build the http request. 
                let requestURLStocks =
                    `https://api.twelvedata.com/time_series?apikey=e7bd90a9e6b24f85aec8b6d9a0f07b10&interval=${interval}&end_date=${endDate}&start_date=${startDate}&symbol=${stockSymbol}&format=JSON`;
                $.ajax({
                    type: "GET",
                    url: requestURLStocks,

                    success: function(response) {

                        console.log('success', response);
                        let csvData = extractToCSV(response);
                        console.log(csvData);
                        const blob = new Blob([csvData], {
                            type: 'text/csv'
                        });

                        const formData = new FormData();
                        formData.append('csv_file', blob, 'data.csv');

                        let currentDate = Math.floor(Date.now() / 1000);

                        let type = "multivariate";
                        let freq;
                        if (interval === "1day") {
                            freq = 'D';
                        }
                        if (interval === "1week") {
                            freq = 'W';
                        }
                        if (interval === "1month") {
                            freq = 'M';
                        }

                        let description =
                            `Time sereis data involving the ${stockSymbol} stocks between ${startDate} and ${endDate}. `;
                        let filename = `Stock-${stockSymbol}-${currentDate}.csv`;


                        formData.append('type', type);
                        formData.append('freq', freq);
                        formData.append('description', description);
                        formData.append('filename', filename);
                        formData.append('source', 'stocks');

                        $.ajax({
                            url: '{{ route('seqal.tempsave_external') }}', // URL to your Laravel route
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content') // Add CSRF token here
                            },
                            data: formData,
                            processData: false, // Prevent jQuery from automatically transforming the data into a query string
                            contentType: false, // Let the browser set the content type
                            success: function(response) {
                                hideSpinner();
                                console.log('Data saved successfully:');
                                window.location.href = response.redirect_url;
                            },
                            error: function(xhr, status, error) {
                                hideSpinner();
                                console.error('Error saving data:', error);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        hideSpinner();
                        alert('Failed to fetch data. Please try again.');
                    }
                });

            });

            function extractToCSV(response) {
                // Check if response has values array
                if (!response || !response.values || response.values.length === 0) {
                    console.error("No values found in the response.");
                    return;
                }

                // Extract data from the values array
                const values = response.values;

                // Define the CSV headers
                const headers = ['datetime', 'open', 'high', 'low', 'close', 'volume'];

                // Create an array for CSV rows starting with the headers
                let csvContent = headers.join(",") + "\n";

                // Sort the values in ascending order based on datetime
                values.sort((a, b) => new Date(a.datetime) - new Date(b.datetime));

                // Loop through the sorted values and extract the fields to append to the CSV content
                values.forEach(item => {
                    const row = [
                        convertDate(item.datetime), // Assuming this function formats the date
                        item.open,
                        item.high,
                        item.low,
                        item.close,
                        item.volume
                    ].join(",");
                    csvContent += row + "\n";
                });

                return csvContent;
            }


            function convertDate(inputDate) {
                // Parse the input date string into a Date object
                const parsedDate = new Date(inputDate);

                // Format the date as MM/dd/yyyy (full year format)
                const formattedDate = dateFns.format(parsedDate, 'MM/dd/yyyy');
                return formattedDate;
            }

        });
    </script>
@endsection
