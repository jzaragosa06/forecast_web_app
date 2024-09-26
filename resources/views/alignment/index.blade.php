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
                <button id="save-btn" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded-md hover:bg-blue-600">
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

        // Colors for each group of headers (files)
        const groupColors = ['bg-red-50', 'bg-blue-50', 'bg-green-50', 'bg-yellow-50', 'bg-purple-50'];

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

            // Create table with minimalistic styling
            const table = $('<table class="min-w-full bg-white border-collapse">');
            const thead = $('<thead class="bg-gray-100">');
            const tbody = $('<tbody>');

            // Create table headers
            let headerRow = $('<tr>');
            headerRow.append(
                '<th class="text-left text-gray-600 font-semibold py-2 px-3">Date</th>'); // First column for date

            let colorIndex = 0; // Color index for each group of headers

            headers_array.forEach((headers, index) => {
                const colorClass = groupColors[index % groupColors.length]; // Rotate through the colors
                headers.forEach(header => {
                    headerRow.append(
                        `<th class="text-left text-gray-600 font-semibold py-2 px-3 ${colorClass}">${header}</th>`
                    );
                });
            });

            thead.append(headerRow);
            table.append(thead);

            // Create table rows
            combinedArray.forEach(row => {
                const tableRow = $('<tr>');
                row.forEach((cell, index) => {
                    // Apply color to cells that belong to the same header group
                    const headerGroupIndex = Math.floor((index - 1) / headers_array[0].length);
                    const cellColorClass = groupColors[headerGroupIndex % groupColors.length];

                    // Apply gray background if value is missing or empty
                    const cellContent = cell === '' ?
                        `<td class="py-2 px-3 bg-gray-200 text-gray-500">${cell}</td>` :
                        `<td class="py-2 px-3 ${cellColorClass}">${cell}</td>`;
                    tableRow.append(cellContent);
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

                console.log('combined Array: ', combinedArray);

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


        $(document).ready(function() {



            function convertToCSV(combinedArray, headers_array) {
                let csvContent = "";

                // Add the header row to CSV (combining 'Date' and headers_array)
                const headers = ['Date', headers_array.flat().join(',')];
                csvContent = headers + "\n";


                // Add data rows to CSV
                combinedArray.forEach(row => {
                    const csvRow = row.map(cell => (cell === '' ? '' : cell)); // Handle empty values
                    csvContent += csvRow.join(',') + "\n";
                });

                return csvContent;
            }


            $('#save-btn').click(function(e) {
                const csvContent = convertToCSV(combinedArray, headers_array);


                console.log(csvContent);
                // make a temporary variable for header and the data. 
                csvContent_temp_array = csvContent.split('\n');
                let headers = csvContent_temp_array[0];
                let data = csvContent_temp_array.slice(1).join('\n');

                console.log("header of temp: ", headers);
                console.log("data: ", data);


                $.ajax({
                    url: '{{ route('seqal.save_preprocess') }}', // Replace with your actual route
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Add CSRF token here
                    },
                    data: {
                        file_id: timeSeriesData['file_id'],
                        type: 'multivariate',
                        filename: timeSeriesData['filename'],
                        freq: timeSeriesData['freq'],
                        description: timeSeriesData['description'],
                        headers: headers,
                        data: data,
                    },
                    success: function(response) {
                        window.location.href = response.redirect_url;

                    },
                    error: function(error) {
                        alert('An error occurred. Please try again.');
                    }
                });


            });
        });
    </script>
@endsection
