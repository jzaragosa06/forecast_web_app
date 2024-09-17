
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
                    @foreach (Auth::user()->files as $file)
                        <li>
                            <a href="{{ Storage::url($file->filepath) }}">{{ $file->filename }}</a>

                        </li>
                    @endforeach
                    <button type="button" id="ts-info" class="btn btn-primary" data-toggle="modal"
                        data-target="#ts-info-form">Add More data via upload</button>
                    <button type="button" id ="ts-add-via-api-open-meteo-btn" class="btn btn-primary"
                        data-toggle="modal" data-target="#ts-add-via-api-open-meteo-modal">Add data form
                        Open-Meteo</button>
                </div>
                <hr>


                <div>
                    <h5>Results (Forecast, Trend, Seasonality Analysis)</h5>
                    <div class="container">
                        <ul>
                            @php
                                $currentFileId = null;
                            @endphp

                            @foreach ($files as $file)
                                @if ($currentFileId !== $file->file_id)
                                    @if ($currentFileId !== null)
                        </ul>
                        </li>
                        @endif

                        <li>
                            <p>{{ $file->filename }}</p>
                            Associated Results:
                            <ul>
                                @php
                                    $currentFileId = $file->file_id;
                                @endphp
                                @endif

                                @if ($file->assoc_filename)
                                    <li>
                                        <p>{{ $file->assoc_filename }}</p>
                                        <form action="{{ route('manage.results', $file->file_assoc_id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit">View</button>
                                        </form>
                                    </li>
                                @else
                                    <li>No associated results found.</li>
                                @endif
                                @endforeach

                                @if ($currentFileId !== null)
                            </ul>
                        </li>
                        @endif
                        </ul>
                    </div>
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

                        <div class="container">
                            <button type="button" id="use-current-loc-btn">Use Current Location to get lat
                                long</button>
                            <button type ="button" id="get-from-maps-btn">Open Map</button>
                            {{-- <p id="lat">Lat: </p>
                            <p id="long">Long: </p> --}}
                            <p id="location"></p>
                        </div>

                        <button type="submit" class="btn btn-primary">Fetch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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



            $('#use-current-loc-btn').on('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                } else {
                    document.getElementById("location").innerHTML =
                        "Geolocation is not supported by this browser.";
                }
            });

            function showPosition(position) {
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;
                document.getElementById("location").innerHTML = "Latitude: " + lat + "<br>Longitude: " + lon;
            }


            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        document.getElementById("location").innerHTML = "User denied the request for Geolocation.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        document.getElementById("location").innerHTML = "Location information is unavailable.";
                        break;
                    case error.TIMEOUT:
                        document.getElementById("location").innerHTML =
                            "The request to get user location timed out.";
                        break;
                    case error.UNKNOWN_ERROR:
                        document.getElementById("location").innerHTML = "An unknown error occurred.";
                        break;
                }
            }
        });
    </script>
</body>



</html>
