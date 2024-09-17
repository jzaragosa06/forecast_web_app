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
            ...
            <!-- Right Side Content -->
            <div class="col-md-9">
                <div>
                    ...
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
                                    ...


                                    <div class="col-md-6">
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                id="precipitation_sum_daily" name="daily" value="precipitation_sum">
                                            <label class="form-check-label" for="precipitation_sum_daily">Precipitation
                                                Sum</label>
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
