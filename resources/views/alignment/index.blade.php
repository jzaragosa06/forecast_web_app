{{-- @extends('layouts.base')

@section('title', 'Time series alignment')

@section('page-title', 'Time series alignment')

@section('content')
    <div class="container mx-auto p-2">
        <!-- Card Container -->
        <div class="bg-gray-50 rounded-lg shadow-md p-4 w-full">
            <div class="flex justify-end items-center mb-4">
                <div class="relative">
                    <!-- Dropdown Button -->
                    <button id="dropdown-button" class="bg-gray-200 text-gray-700 p-2 rounded-md focus:outline-none">
                        Add via Upload
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                        <ul class="py-1">
                            <li class="flex items-center">
                                <!-- Styled File Input -->
                                <label for="file-upload"
                                    class="cursor-pointer text-gray-700 px-2 py-2 hover:bg-gray-200 w-full text-left">
                                    Add via Upload
                                </label>
                                <input type="file" id="file-upload" class="hidden" />
                            </li>
                            <li>
                                <button class="dropdown-item text-left w-full px-4 py-2 hover:bg-gray-200">Add via Third
                                    Party Source</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Save Button -->
                <button class="bg-blue-500 text-white px-4 py-2 ml-4 rounded-md hover:bg-blue-600">
                    Save
                </button>
            </div>
        </div>

        <div id="data-container" class="mt-4 w-full">
            <!-- Your content and visualization can go here -->
        </div>
    </div>

    <script>
        // The time series data passed from the controller
        const timeSeriesData = @json($timeSeriesData);
        const data = timeSeriesData['data'];


        // Initialize the 2D array
        let array1 = [];
        let array2 = [];
        let combinedArray = [];
        let headers_array = [];


        // Iterate over the timeSeriesData to form the 2D array
        data.forEach(item => {
            let row = [item.date, ...item.values]; // Combine date and values in one array
            array1.push(row); // Push to 2D array
        });
        // Excluding the index
        headers_array.push(timeSeriesData.header.slice(1));
        combinedArray = array1;


        $(document).ready(function() {
            $('#dropdown-button').on('click', function() {
                $('#dropdown-menu').toggleClass('hidden');
            });
        });

        $(document).ready(function() {
            function align() {
                // Convert arrays into objects for easier access by the shared column (the first element)
                const dict1 = Object.fromEntries(array1.map(row => [row[0], row.slice(1)]));
                const dict2 = Object.fromEntries(array2.map(row => [row[0], row.slice(1)]));

                // Get all unique keys (shared column values) from both arrays
                const allKeys = [...new Set([...array1.map(row => row[0]), ...array2.map(row => row[0])])].sort();

                // Determine the maximum number of columns in each array (excluding the shared column)
                const maxColumns1 = Math.max(...array1.map(row => row.length - 1)); // Exclude the first column
                const maxColumns2 = Math.max(...array2.map(row => row.length - 1)); // Exclude the first column


                // Prepare the combined array
                combinedArray_temp = allKeys.map(key => {
                    const row1 = dict1[key] || Array(maxColumns1).fill(
                        ''); // If key is not in array1, use empty values
                    const row2 = dict2[key] || Array(maxColumns2).fill(
                        ''); // If key is not in array2, use empty values
                    return [key, ...row1, ...
                        row2
                    ]; // Combine key (shared column) with corresponding values from both arrays
                });

                return combinedArray_temp
            }


            function render_combinedArray_as_table() {

            }


            $('#file-upload').on('change', function(event) {
                array1 = combinedArray;
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    // Read the CSV file
                    reader.onload = function(e) {
                        const text = e.target.result;
                        const rows = text.split('\n');


                        // Create arrays for headers and data
                        let headers = [];


                        // Process the first row (headers)
                        if (rows.length > 0) {
                            headers = rows[0].split(',');
                            headers_array.push(headers.slice(1));
                        }

                        // Process remaining rows (data)
                        rows.slice(1).forEach(row => {
                            const values = row.split(',');

                            // Check if row is not empty
                            if (values.length > 1) {
                                // Add row data to array1 (parse numeric values)
                                array1.push([values[0], ...values.slice(1).map(Number)]);
                            }
                        });

                        console.log("Headers:", headers); // First row (header)
                        console.log("Data Array1:", array1); // Subsequent rows (data)


                    };
                    // Read file as text
                    reader.readAsText(file);

                    //call a function to align the array1 and array2. then empty array2
                    combinedArray = align();
                    array2 = [];
                    //render the combinedArray in the screen. 

                }
            });
        });
    </script>
@endsection --}}


@extends('layouts.base')

@section('title', 'Time series alignment')

@section('page-title', 'Time series alignment')

@section('content')
    <div class="container mx-auto p-2">
        <!-- Card Container -->
        <div class="bg-gray-50 rounded-lg shadow-md p-4 w-full">
            <div class="flex justify-end items-center mb-4">
                <div class="relative">
                    <!-- Dropdown Button -->
                    <button id="dropdown-button" class="bg-gray-200 text-gray-700 p-2 rounded-md focus:outline-none">
                        Add via Upload
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                        <ul class="py-1">
                            <li class="flex items-center">
                                <!-- Styled File Input -->
                                <label for="file-upload"
                                    class="cursor-pointer text-gray-700 px-2 py-2 hover:bg-gray-200 w-full text-left">
                                    Add via Upload
                                </label>
                                <input type="file" id="file-upload" class="hidden" />
                            </li>
                            <li>
                                <button class="dropdown-item text-left w-full px-4 py-2 hover:bg-gray-200">Add via Third
                                    Party Source</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Save Button -->
                <button class="bg-blue-500 text-white px-4 py-2 ml-4 rounded-md hover:bg-blue-600">
                    Save
                </button>
            </div>
        </div>

        <div id="data-container" class="mt-4 w-full">
            <!-- Your content and visualization can go here -->
        </div>
    </div>

    <script>
        // The time series data passed from the controller
        const timeSeriesData = @json($timeSeriesData);
        const data = timeSeriesData['data'];

        // Initialize the 2D array
        let array1 = [];
        let array2 = [];
        let combinedArray = [];
        let headers_array = [];

        // Iterate over the timeSeriesData to form the 2D array
        data.forEach(item => {
            let row = [item.date, ...item.values]; // Combine date and values in one array
            array1.push(row); // Push to 2D array
        });
        // Excluding the index
        headers_array.push(timeSeriesData.header.slice(1));
        combinedArray = array1;

        function render_combinedArray_as_table() {
            // Clear previous data
            $('#data-container').empty();

            // Create table
            const table = $('<table class="min-w-full bg-white border border-gray-300">');
            const thead = $('<thead class="bg-gray-200">');
            const tbody = $('<tbody>');

            // Create table headers
            let headerRow = $('<tr>');
            headerRow.append('<th class="border px-4 py-2">Date</th>'); // First column for date
            headers_array.forEach(headers => {
                headers.forEach(header => {
                    headerRow.append(`<th class="border px-4 py-2">${header}</th>`);
                });
            });
            thead.append(headerRow);
            table.append(thead);

            // Create table rows
            combinedArray.forEach(row => {
                const tableRow = $('<tr>');
                row.forEach(cell => {
                    tableRow.append(`<td class="border px-4 py-2">${cell}</td>`);
                });
                tbody.append(tableRow);
            });

            table.append(tbody);
            $('#data-container').append(table);
        }

        render_combinedArray_as_table();

        $(document).ready(function() {
            $('#dropdown-button').on('click', function() {
                $('#dropdown-menu').toggleClass('hidden');
            });

            function align() {
                const dict1 = Object.fromEntries(array1.map(row => [row[0], row.slice(1)]));
                const dict2 = Object.fromEntries(array2.map(row => [row[0], row.slice(1)]));
                const allKeys = [...new Set([...array1.map(row => row[0]), ...array2.map(row => row[0])])].sort();

                const maxColumns1 = Math.max(...array1.map(row => row.length - 1));
                const maxColumns2 = Math.max(...array2.map(row => row.length - 1));

                combinedArray = allKeys.map(key => {
                    const row1 = dict1[key] || Array(maxColumns1).fill('');
                    const row2 = dict2[key] || Array(maxColumns2).fill('');
                    return [key, ...row1, ...row2];
                });

                return combinedArray;
            }



            $('#file-upload').on('change', function(event) {
                const file = event.target.files[0];
                array1 = combinedArray;


                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const text = e.target.result;
                        const rows = text.split('\n');
                        let headers = [];

                        // Process the first row (headers)
                        if (rows.length > 0) {
                            headers = rows[0].split(',');
                            headers_array.push(headers.slice(1));
                        }

                        // Process remaining rows (data)
                        rows.slice(1).forEach(row => {
                            const values = row.split(',');
                            if (values.length > 1) {
                                array2.push([values[0], ...values.slice(1).map(Number)]);
                            }
                        });

                        // Call the function to align the array1 and array2
                        combinedArray = align();
                        array2 = [];

                        // Render the combinedArray in the screen
                        render_combinedArray_as_table();
                    };
                    // Read file as text
                    reader.readAsText(file);
                }
            });
        });
    </script>
@endsection
