@extends('layouts.base')

@section('title', 'Time series alignment')

@section('page-title', 'Time series alignment')

@section('content')
    <div class="container mx-auto p-2">
        <!-- Card Container -->
        <div class="bg-gray-50 rounded-lg shadow-md p-4 w-full">
            <!-- Flex container for alignment of text and buttons -->
            <div class="flex justify-between items-center mb-4">
                <!-- Description Text -->
                <p class="text-sm text-gray-700 max-w-xl">
                    Time series alignment allows you to add more time series data to an existing time series.
                    This is useful when you want to include another variable that is helpful in your analysis.
                </p>

                <!-- Button Group -->
                <div class="flex items-center space-x-4">
                    <!-- Dropdown Container -->
                    <div class="relative">
                        <!-- Dropdown Button -->
                        <button id="dropdown-button" class="bg-gray-200 text-gray-700 p-2 rounded-md focus:outline-none">
                            Add
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
                                    <input type="file" id="file-upload" class="hidden" accept=".csv" />
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <button id="save-btn" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <div id="data-container" class="mt-4 w-full">
            <!-- Your content and visualization can go here -->
        </div>

    </div>

    <script>
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

        function convertDate(inputDate) {
            // Parse the input date string into a Date object
            const parsedDate = new Date(inputDate);
            // Format the date as MM/dd/yyyy (full year format)
            const formattedDate = dateFns.format(parsedDate, 'MM/dd/yyyy');
            return formattedDate;
        }


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

            // Initialize and show Google Map when "Open Map" button is clicked
            $('#get-from-maps-btn').on('click', function() {
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

                lat = latLng.lat();
                lon = latLng.lng();



                // Update the latitude and longitude in the form
                $('#lat').text(lat);
                $('#long').text(lon);
            }



            // Geolocation: Use current location
            $('#use-current-loc-btn').on('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {

                        lat = position.coords.latitude;
                        lon = position.coords.longitude;

                        console.log(lat);
                        console.log(lon);

                        if (map) {
                            // Update the map's center and place a marker
                            let currentLocation = new google.maps.LatLng(lat, lon);
                            map.setCenter(currentLocation);
                            placeMarkerAndPanTo(currentLocation, map);
                        }

                        $('#lat').text(lat);
                        $('#long').text(lon);

                    }, function(error) {
                        console.error("Error retrieving location: ", error);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });


            $('#fetch-data-open-meteo-btn').on('click', function(e) {

                e.preventDefault();

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


                console.log(requestUrl);

                // Send the AJAX request
                $.ajax({
                    url: requestUrl,
                    type: 'GET',
                    success: function(response) {
                        // Handle the response from the server
                        console.log('Data fetched successfully:', response);


                        // You can display the data in the modal or elsewhere in the app
                        // =================================================================================================
                        csvData = generateCSV(response, selectedDaily);
                        console.log("generated csv raw", csvData);

                        // we will convert the csv data to 2D array. 
                        let rows = csvData.trim().split('\n');

                        // Split the first row (headers) by commas
                        let headers = rows[0].split(',');
                        // Loop through the rest of the rows and split each by commas
                        let values = rows.slice(1).map(row => row.split(','));
                        console.log(rows);
                        console.log(headers);
                        console.log(values);



                        array2 = values;
                        array1 = combinedArray;
                        combinedArray = align();

                        headers_array.push(headers.slice(1));
                        render_combinedArray_as_table();


                        // Close the modal
                        $('#ts-add-via-api-open-meteo-modal').fadeOut(200, function() {
                            $(this).addClass('hidden');
                        });

                        // ========================================================================================
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        alert('Failed to fetch data. Please try again.');
                    }
                });





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


        // ----------------------------------------------------------------------------------------------------------------
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

        render_combinedArray_as_table();

        $(document).ready(function() {
            $('#dropdown-button').on('click', function() {
                $('#dropdown-menu').toggleClass('hidden');
            });



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
                                array2.push([convertDate(values[0]), ...values.slice(1).map(
                                    Number)]);
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
            $('#save-btn').click(function(e) {
                const csvContent = convertToCSV(combinedArray, headers_array);


                // Create a FormData object to send the CSV and other data
                const blob = new Blob([csvContent], {
                    type: 'text/csv'
                });

                const formData = new FormData();
                formData.append('csv_file', blob, 'data.csv');

                formData.append('file_id', timeSeriesData['file_id']);
                formData.append('type', 'multivariate');
                formData.append('filename', timeSeriesData['filename']);
                formData.append('freq', timeSeriesData['freq']);
                formData.append('source', 'uploads');
                formData.append('description', timeSeriesData['description']);


                $.ajax({
                    url: '{{ route('seqal.tempsave') }}', // Replace with your actual route
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Add CSRF token here
                    },
                    data: formData,
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false, // Let the browser set the content type
                    success: function(response) {
                        console.log('Data saved successfully:');
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
