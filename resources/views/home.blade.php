<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHELiMiSckEBBGpn5KaM9TZVlYGevcKTg&libraries=places">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">





</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Left Side Panel -->
            <div class="col-md-3 bg-light p-3 min-vh-100 border-end">
                <!-- User Information -->
                <div class="text-center mb-4">
                    <img src="{{ Storage::url(Auth::user()->profile_photo) }}" class="rounded-circle"
                        alt="Profile Photo" width="150" height="150">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                </div>
                <!-- Links -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('crud.show') }}">Manage Results</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
            <!-- Right Side Content -->
            {{-- <div class="col-md-9">
                <div>
                    <h4>Analyze</h4>
                    <form action="{{ route('manage.operations') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="file_id">Select File</label>
                            <select name="file_id" id="file_id" class="form-control">
                                @foreach (Auth::user()->files as $file)
                                    <option value="{{ $file->file_id }}">{{ $file->filename }}</option>
                                @endforeach
                                <option value="" id="add-more-from-option"> Add more data +</option>
                            </select>
                        </div>

                        <div>
                            <label for="operation">Select Operation</label>
                            <select name="operation" id="operation" class="form-control">

                                <option value="trend">Trend</option>
                                <option value="seasonality">Seasonality</option>
                                <option value="forecast">Forecast</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-secondary">Analyze</button>
                    </form>

                </div>
                <hr>
                <div>
                    <h5>List of Input Time Series Data</h5>
                    @foreach (Auth::user()->files as $file)
                        <div>
                            <p>{{ $file->filename }}</p>
                            <p>{{ $file->type }}</p>
                            <p>{{ $file->freq }}</p>
                            <p>{{ $file->description }}</p>

                        </div>
                    @endforeach
                    <button type="button" id="ts-info" class="btn btn-primary" data-toggle="modal"
                        data-target="#ts-info-form">Add More data via upload</button>
                    <button type="button" id ="ts-add-via-api-open-meteo-btn" class="btn btn-primary"
                        data-toggle="modal" data-target="#ts-add-via-api-open-meteo-modal">Add data form
                        Open-Meteo</button>
                </div>

            </div> --}}

            <div class="col-md-9">
                <div>
                    <h4>Analyze</h4>
                    <form action="{{ route('manage.operations') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="file_id">Select File</label>
                            <select name="file_id" id="file_id" class="form-control">
                                @foreach (Auth::user()->files as $file)
                                    <option value="{{ $file->file_id }}">{{ $file->filename }}</option>
                                @endforeach
                                <option value="" id="add-more-from-option"> Add more data +</option>
                            </select>
                        </div>

                        <div>
                            <label for="operation">Select Operation</label>
                            <select name="operation" id="operation" class="form-control">
                                <option value="trend">Trend</option>
                                <option value="seasonality">Seasonality</option>
                                <option value="forecast">Forecast</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-secondary">Analyze</button>
                    </form>
                </div>

                <hr>

                <div>
                    <h5>List of Input Time Series Data</h5>

                    <!-- Loop through the files and display each inside a Bootstrap card -->
                    @foreach (Auth::user()->files as $file)
                        <div class="card mb-3">
                            <div class="card-body">
                                <!-- File information -->
                                <h5 class="card-title">{{ $file->filename }}</h5>
                                <p class="card-text">Type: {{ $file->type }}</p>
                                <p class="card-text">Frequency: {{ $file->freq }}</p>
                                <p class="card-text">Description: {{ $file->description }}</p>

                                <!-- Placeholder for graph (can be replaced with an actual graph later) -->
                                <div class="graph-placeholder mt-4" style="height: 200px; background-color: #f7f7f7;">
                                    <!-- Graph will be added here later -->
                                    <p class="text-center text-muted" style="line-height: 200px;">Graph Placeholder</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Buttons to add more data -->
                    <button type="button" id="ts-info" class="btn btn-primary" data-toggle="modal"
                        data-target="#ts-info-form">
                        Add More data via upload
                    </button>
                    <button type="button" id="ts-add-via-api-open-meteo-btn" class="btn btn-primary"
                        data-toggle="modal" data-target="#ts-add-via-api-open-meteo-modal">
                        Add data from Open-Meteo
                    </button>
                </div>
            </div>

        </div>
    </div>



    <div class="modal fade" id="ts-info-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Information About the Time Series Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('upload.ts') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload from Device</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="type">Type:</label>
                            <select name="type" class="form-control" required>
                                <option value="univariate">Univariate</option>
                                <option value="multivariate">Multivariate</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="freq">Frequency:</label>
                            <select name="freq" class="form-control" required>
                                <option value="D">Day</option>
                                <option value="W">Week</option>
                                <option value="M">Month</option>
                                <option value="Q">Quarter</option>
                                <option value="Y">Yearly</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>

            </div>
        </div>

    </div>




    <!-- Forecast Modal -->
    <div class="modal fade" id="forecast-modal" tabindex="-1" role="dialog" aria-labelledby="forecastModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forecastModalLabel">Forecast Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('manage.operations') }}" method="POST">
                        @csrf
                        <input type="hidden" name="file_id" id="modal_file_id">
                        <input type="hidden" name="operation" value="forecast">

                        <div class="form-group">
                            <label for="horizon">Forecast Horizon</label>
                            <input type="number" name="horizon" id="horizon" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="method">Forecast Method</label><br>
                            <input type="radio" name="method" value = "with_refit">With
                            Refit<br>
                            <input type="radio" name="method" value = "without_refit">Without
                            Refit <br>
                        </div>
                        <button type="submit" class="btn btn-primary">Run Forecast</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- fetch data from open-meteo modal --}}
    <div class="modal fade" id="ts-add-via-api-open-meteo-modal" tabindex="-1" role="dialog"
        aria-labelledby="forecastModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forecastModalLabel">Open Meteo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="weather_code_daily" name="daily" value="weather_code"> <label
                                            class="form-check-label" for="weather_code_daily">Weather code</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="temperature_2m_max_daily" name="daily" value="temperature_2m_max">
                                        <label class="form-check-label" for="temperature_2m_max_daily">Maximum
                                            Temperature (2
                                            m)</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="temperature_2m_min_daily" name="daily" value="temperature_2m_min">
                                        <label class="form-check-label" for="temperature_2m_min_daily">Minimum
                                            Temperature (2
                                            m)</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="temperature_2m_mean_daily" name="daily"
                                            value="temperature_2m_mean"> <label class="form-check-label"
                                            for="temperature_2m_mean_daily">Mean Temperature (2
                                            m)</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="apparent_temperature_max_daily" name="daily"
                                            value="apparent_temperature_max"> <label class="form-check-label"
                                            for="apparent_temperature_max_daily">Maximum Apparent Temperature (2
                                            m)</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="apparent_temperature_min_daily" name="daily"
                                            value="apparent_temperature_min"> <label class="form-check-label"
                                            for="apparent_temperature_min_daily">Minimum Apparent Temperature (2
                                            m)</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="apparent_temperature_mean_daily" name="daily"
                                            value="apparent_temperature_mean"> <label class="form-check-label"
                                            for="apparent_temperature_mean_daily">Mean Apparent Temperature (2
                                            m)</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="sunrise_daily" name="daily" value="sunrise"> <label
                                            class="form-check-label" for="sunrise_daily">Sunrise</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="sunset_daily" name="daily" value="sunset"> <label
                                            class="form-check-label" for="sunset_daily">Sunset</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="daylight_duration_daily" name="daily" value="daylight_duration">
                                        <label class="form-check-label" for="daylight_duration_daily">Daylight
                                            Duration</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="sunshine_duration_daily" name="daily" value="sunshine_duration">
                                        <label class="form-check-label" for="sunshine_duration_daily">Sunshine
                                            Duration</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="precipitation_sum_daily" name="daily" value="precipitation_sum">
                                        <label class="form-check-label" for="precipitation_sum_daily">Precipitation
                                            Sum</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="rain_sum_daily" name="daily" value="rain_sum"> <label
                                            class="form-check-label" for="rain_sum_daily">Rain Sum</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="snowfall_sum_daily" name="daily" value="snowfall_sum"> <label
                                            class="form-check-label" for="snowfall_sum_daily">Snowfall Sum</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="precipitation_hours_daily" name="daily"
                                            value="precipitation_hours"> <label class="form-check-label"
                                            for="precipitation_hours_daily">Precipitation
                                            Hours</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="wind_speed_10m_max_daily" name="daily" value="wind_speed_10m_max">
                                        <label class="form-check-label" for="wind_speed_10m_max_daily">Maximum Wind
                                            Speed (10
                                            m)</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="wind_gusts_10m_max_daily" name="daily" value="wind_gusts_10m_max">
                                        <label class="form-check-label" for="wind_gusts_10m_max_daily">Maximum Wind
                                            Gusts (10
                                            m)</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="wind_direction_10m_dominant_daily" name="daily"
                                            value="wind_direction_10m_dominant"> <label class="form-check-label"
                                            for="wind_direction_10m_dominant_daily">Dominant Wind Direction (10
                                            m)</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="shortwave_radiation_sum_daily" name="daily"
                                            value="shortwave_radiation_sum"> <label class="form-check-label"
                                            for="shortwave_radiation_sum_daily">Shortwave Radiation Sum</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="et0_fao_evapotranspiration_daily" name="daily"
                                            value="et0_fao_evapotranspiration"> <label class="form-check-label"
                                            for="et0_fao_evapotranspiration_daily">Reference Evapotranspiration
                                            (ET₀)</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="container mt-3">
                            <!-- Date Pickers -->
                            <div class="form-group">
                                <label for="start-date">Start Date</label>
                                <input type="date" id="start-date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="end-date">End Date</label>
                                <input type="date" id="end-date" class="form-control" required>
                            </div>
                        </div>


                        <div class="container">
                            <!-- Map Display -->
                            <button type="button" id="use-current-loc-btn">Use Current Location</button>
                            <button type="button" id="get-from-maps-btn">Open Map</button>

                            <div id="map" class="mt-3" style="height: 400px; display: none;"></div>
                            <p id="selected-location" class="mt-2">Latitude: <span id="lat"></span>,
                                Longitude: <span id="long"></span></p>
                        </div>


                        <button type="submit" id="fetch-data-open-meteo-btn" class="btn btn-primary">Fetch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let map;
            let marker;
            let lat;
            let lon;


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



                    // Send the data using AJAX
                    // $.ajax({
                    //     url: '{{ route('save') }}', // URL to your Laravel route
                    //     type: 'POST',
                    //     data: formData,
                    //     processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    //     contentType: false, // Let the browser set the content type
                    //     success: function(response) {
                    //         console.log('Data saved successfully:');

                    //         // Redirect the user manually
                    //         window.location.href = response.redirect_url;
                    //     },
                    //     error: function(xhr, status, error) {
                    //         console.error('Error saving data:', error);
                    //     }
                    // });

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
</body>



</html>
