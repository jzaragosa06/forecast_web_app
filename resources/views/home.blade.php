@extends('layouts.base')

@section('title', 'Home Page')

@section('content')
    <div>
        <div class="container mx-auto p-4">
            <div class="flex space-x-4">
                <div class="w-full md:w-1/3">
                    <div class="border bg-white p-4 rounded-lg shadow-md">
                        <h4 class="text-lg font-semibold mb-4">Analyze</h4>
                        <form action="{{ route('manage.operations') }}" method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="file_id" class="block text-sm font-medium mb-1">Select File</label>
                                <select name="file_id" id="file_id"
                                    class="form-select block w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach (Auth::user()->files as $file)
                                        <option value="{{ $file->file_id }}">{{ $file->filename }}</option>
                                    @endforeach
                                    <option value="" id="add-more-from-option">Add more data +</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="operation" class="block text-sm font-medium mb-1">Select Operation</label>
                                <select name="operation" id="operation"
                                    class="form-select block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="trend">Trend</option>
                                    <option value="seasonality">Seasonality</option>
                                    <option value="forecast">Forecast</option>
                                </select>
                            </div>

                            <button type="submit"
                                class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Analyze</button>
                        </form>
                    </div>
                </div>
                <div class="w-full md:w-1/3">
                    <div class="border bg-white p-4 rounded-lg shadow-md">
                        <h4 class="text-lg font-semibold mb-4">Add Data</h4>
                        <!-- Buttons to add more data -->
                        <button type="button" id="ts-info"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md mb-2 hover:bg-blue-700" data-toggle="modal"
                            data-target="#ts-info-form">
                            Add More data via upload
                        </button>
                        <button type="button" id="ts-add-via-api-open-meteo-btn"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700" data-toggle="modal"
                            data-target="#ts-add-via-api-open-meteo-modal">
                            Add data from Open-Meteo
                        </button>
                    </div>
                </div>
                <div class="w-full md:w-1/3">
                    <div class="border bg-white p-4 rounded-lg shadow-md">
                        <h4 class="text-lg font-semibold mb-4">Recent Results</h4>
                        <ul class="list-disc pl-5">
                            @foreach ($file_assocs as $file_assoc)
                                <li class="mb-2">
                                    <a href="{{ route('manage.results.get', $file_assoc->file_assoc_id) }}"
                                        class="text-blue-600 hover:underline">
                                        <p>{{ $file_assoc->assoc_filename }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-4">

        {{-- we're going to iterate through files by using index instead of loop. --}}
        <div class="container mx-auto p-4">
            <h5 class="text-xl font-semibold mb-4">List of Input Time Series Data</h5>
            <!-- Loop through the time series data -->
            @foreach ($timeSeriesData as $index => $fileData)
                <div class="bg-white border rounded-lg shadow-md mb-4">
                    <div class="p-4">
                        <div class="flex">
                            <div class="w-full lg:w-1/3">
                                <!-- File information -->
                                <h5 class="text-lg font-semibold mb-2">{{ $files[$index]->filename }}</h5>
                                <p class="text-sm mb-1">Type: {{ $files[$index]->type }}</p>
                                <p class="text-sm mb-1">Frequency: {{ $files[$index]->freq }}</p>
                                <p class="text-sm mb-1">Description: {{ $files[$index]->description }}</p>
                            </div>
                            <div class="w-full lg:w-2/3 mt-4 lg:mt-0">
                                <div class="graph-container mt-4" style="height: 300px;">
                                    <div id="graph-{{ $index }}" style="height: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="fixed inset-0 flex items-center justify-center z-50" id="ts-info-form" style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Information About the Time Series Data</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('upload.ts') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium mb-1">Upload from Device</label>
                        <input type="file" name="file" id="file"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium mb-1">Type:</label>
                        <select name="type" class="form-select block w-full border-gray-300 rounded-md shadow-sm"
                            required>
                            <option value="univariate">Univariate</option>
                            <option value="multivariate">Multivariate</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="freq" class="block text-sm font-medium mb-1">Frequency:</label>
                        <select name="freq" class="form-select block w-full border-gray-300 rounded-md shadow-sm"
                            required>
                            <option value="D">Day</option>
                            <option value="W">Week</option>
                            <option value="M">Month</option>
                            <option value="Q">Quarter</option>
                            <option value="Y">Yearly</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium mb-1">Description:</label>
                        <input type="text" name="description"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm">
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

    <!-- Forecast Modal -->
    <div class="fixed inset-0 flex items-center justify-center z-50" id="forecast-modal" style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Forecast Settings</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('manage.operations') }}" method="POST">
                    @csrf
                    <input type="hidden" name="file_id" id="modal_file_id">
                    <input type="hidden" name="operation" value="forecast">

                    <div class="mb-4">
                        <label for="horizon" class="block text-sm font-medium mb-1">Forecast Horizon</label>
                        <input type="number" name="horizon" id="horizon"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Forecast Method</label>
                        <div class="flex items-center">
                            <input type="radio" name="method" value="with_refit" id="with_refit" class="mr-2">
                            <label for="with_refit" class="text-sm">With Refit</label>
                        </div>
                        <div class="flex items-center mt-1">
                            <input type="radio" name="method" value="without_refit" id="without_refit"
                                class="mr-2">
                            <label for="without_refit" class="text-sm">Without Refit</label>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Run
                        Forecast</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Fetch data from open-meteo modal --}}
    <div class="fixed inset-0 flex items-center justify-center z-50" id="ts-add-via-api-open-meteo-modal"
        style="display:none;">
        <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-2/3">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h5 class="text-lg font-semibold">Open Meteo</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="weather_code_daily" name="daily"
                                    value="weather_code">
                                <label class="ml-2" for="weather_code_daily">Weather code</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="temperature_2m_max_daily"
                                    name="daily" value="temperature_2m_max">
                                <label class="ml-2" for="temperature_2m_max_daily">Maximum Temperature (2 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="temperature_2m_min_daily"
                                    name="daily" value="temperature_2m_min">
                                <label class="ml-2" for="temperature_2m_min_daily">Minimum Temperature (2 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="temperature_2m_mean_daily"
                                    name="daily" value="temperature_2m_mean">
                                <label class="ml-2" for="temperature_2m_mean_daily">Mean Temperature (2 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="apparent_temperature_max_daily"
                                    name="daily" value="apparent_temperature_max">
                                <label class="ml-2" for="apparent_temperature_max_daily">Maximum Apparent Temperature (2
                                    m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="apparent_temperature_min_daily"
                                    name="daily" value="apparent_temperature_min">
                                <label class="ml-2" for="apparent_temperature_min_daily">Minimum Apparent Temperature (2
                                    m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="apparent_temperature_mean_daily"
                                    name="daily" value="apparent_temperature_mean">
                                <label class="ml-2" for="apparent_temperature_mean_daily">Mean Apparent Temperature (2
                                    m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="sunrise_daily" name="daily"
                                    value="sunrise">
                                <label class="ml-2" for="sunrise_daily">Sunrise</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="sunset_daily" name="daily"
                                    value="sunset">
                                <label class="ml-2" for="sunset_daily">Sunset</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="daylight_duration_daily" name="daily"
                                    value="daylight_duration">
                                <label class="ml-2" for="daylight_duration_daily">Daylight Duration</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="sunshine_duration_daily" name="daily"
                                    value="sunshine_duration">
                                <label class="ml-2" for="sunshine_duration_daily">Sunshine Duration</label>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="precipitation_sum_daily" name="daily"
                                    value="precipitation_sum">
                                <label class="ml-2" for="precipitation_sum_daily">Precipitation Sum</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="rain_sum_daily" name="daily"
                                    value="rain_sum">
                                <label class="ml-2" for="rain_sum_daily">Rain Sum</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="snowfall_sum_daily" name="daily"
                                    value="snowfall_sum">
                                <label class="ml-2" for="snowfall_sum_daily">Snowfall Sum</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="precipitation_hours_daily"
                                    name="daily" value="precipitation_hours">
                                <label class="ml-2" for="precipitation_hours_daily">Precipitation Hours</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="wind_speed_10m_max_daily"
                                    name="daily" value="wind_speed_10m_max">
                                <label class="ml-2" for="wind_speed_10m_max_daily">Maximum Wind Speed (10 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="wind_gusts_10m_max_daily"
                                    name="daily" value="wind_gusts_10m_max">
                                <label class="ml-2" for="wind_gusts_10m_max_daily">Maximum Wind Gusts (10 m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="wind_direction_10m_dominant_daily"
                                    name="daily" value="wind_direction_10m_dominant">
                                <label class="ml-2" for="wind_direction_10m_dominant_daily">Dominant Wind Direction (10
                                    m)</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="shortwave_radiation_sum_daily"
                                    name="daily" value="shortwave_radiation_sum">
                                <label class="ml-2" for="shortwave_radiation_sum_daily">Shortwave Radiation Sum</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input class="form-checkbox" type="checkbox" id="et0_fao_evapotranspiration_daily"
                                    name="daily" value="et0_fao_evapotranspiration">
                                <label class="ml-2" for="et0_fao_evapotranspiration_daily">Reference Evapotranspiration
                                    (ET₀)</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <!-- Date Pickers -->
                        <label for="start-date" class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" id="start-date"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="end-date" class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" id="end-date"
                            class="form-input block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <!-- Map Display -->
                        <button type="button" id="use-current-loc-btn"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Use Current
                            Location</button>
                        <button type="button" id="get-from-maps-btn"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Open Map</button>

                        <div id="map" class="mt-4 h-96 hidden"></div>
                        <p id="selected-location" class="mt-2 text-sm">Latitude: <span id="lat"></span>, Longitude:
                            <span id="long"></span></p>
                    </div>

                    <button type="submit" id="fetch-data-open-meteo-btn"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Fetch</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let map;
            let marker;
            let lat;
            let lon;


            // =======================================================================================
            // Iterate over each file data to create corresponding graphs

            // Iterate over each file data to create corresponding graphs

            @foreach ($timeSeriesData as $index => $fileData)
                var options = {
                    chart: {
                        type: 'line',
                        height: 300,
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
            // =======================================================================================



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



            $('#operation').on('change', function() {
                if ($(this).val() === 'forecast') {
                    $('#forecast-modal').modal('show');
                    $('#modal_file_id').val($('#file_id').val());
                }
            });


            // Open the 'Add More data' modal when 'Add more data' is selected
            $('#file_id').on('change', function() {
                if ($(this).val() === '') {
                    $('#ts-info-form').modal('show');
                }
            });

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
        });

        // Listen for click event on the fetch button
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

                    // Create a FormData object to send the CSV and other data
                    const blob = new Blob([csvData], {
                        type: 'text/csv'
                    });

                    const formData = new FormData();
                    formData.append('csv_file', blob, 'data.csv');

                    let currentDate = new Date().toISOString().split('T')[0];
                    console.log(currentDate);


                    let type;
                    let freq = 'D';
                    let description = `time sereis data involving ${selectedDaily.join(',')}`;
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

                    // Inspect FormData
                    for (let [key, value] of formData.entries()) {
                        console.log(key, value);
                    }



                    $.ajax({
                        url: '{{ route('save') }}', // URL to your Laravel route
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
                            window.location.href = response.redirect_url;
                        },
                        error: function(xhr, status, error) {
                            console.error('Error saving data:', error);
                        }
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
                    let row = [timeArray[i]];

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
    </script>
@endsection
