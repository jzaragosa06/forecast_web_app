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
                                @foreach ($files as $file)
                                    <option value="{{ $file->file_id }}">{{ $file->filename }}</option>
                                @endforeach
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
                        data-target="#ts-info-form">Add More data</button>
                </div>
                <hr>
                {{-- <div>
                    <h5>Results (Forecast, Trend, Seasonality Analysis)</h5>
                    <div class="container">
                        <h1>Results</h1>
                        <ul>
                            @foreach ($files as $file)
                                <li>
                                    <p>{{ $file->filename }}</p>
                                    <p>File ID: {{ $file->file_id }}</p>
                                    <p>File ID: {{ $file->id }}</p>

                                    <br>Associated Results:
                                    <ul>
                                        @if ($file->associations->isEmpty())
                                            <p>No associations found for this file.</p>
                                        @else
                                            @foreach ($file->associations as $association)
                                                <li>
                                                    <p>Association Filename: {{ $association->assoc_filename }}</p>
                                                    <p>File Association ID: {{ $association->file_assoc_id }}</p>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div> --}}

                {{-- <div>
                    <h5>Results (Forecast, Trend, Seasonality Analysis)</h5>
                    <div class="container">
                        @foreach ($assoc_files as $association)
                            <li>
                                <p>{{ $association->assoc_filename }} - modified:
                                    {{ $association->updated_at }}</p>
                                <form action="{{ route('manage.results', $association->file_assoc_id) }}"
                                    method="post">
                                    <button type="submit">View</button>
                                </form>
                            </li>
                        @endforeach




                    </div>
                </div> --}}

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

    <script>
        $(document).ready(function() {
            $('#operation').on('change', function() {
                if ($(this).val() === 'forecast') {
                    $('#forecast-modal').modal('show');
                    $('#modal_file_id').val($('#file_id').val());
                }
            });
        });
    </script>
</body>



</html>
