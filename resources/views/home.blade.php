<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Time Series Analyzer</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        /* Custom Theme Colors */
        :root {
            --primary-color: #1B3B6F;
            --secondary-color: #21295C;
            --tertiary-color: #1C7293;
            --black-color: #000000;
            --white-color: #FFFFFF;
        }

        body {
            background-color: var(--white-color);
            color: var(--black-color);
        }

        .navbar {
            background-color: var(--primary-color);
            color: var(--white-color);
        }

        .navbar .navbar-brand,
        .navbar .btn {
            color: var(--white-color);
        }

        .sidebar {
            background-color: var(--secondary-color);
            color: var(--white-color);
        }

        .sidebar .nav-link {
            color: var(--white-color);
        }

        .sidebar .nav-link.active {
            background-color: var(--tertiary-color);
            color: var(--white-color);
        }

        .card-header {
            background-color: var(--primary-color);
            color: var(--white-color);
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: var(--white-color);
        }

        .btn-primary:hover {
            background-color: var(--tertiary-color);
            border-color: var(--tertiary-color);
            color: var(--white-color);
        }

        /* Sidebar icons */
        .nav-item .fas {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Time Series Analyzer</a>
        <div class="ml-auto">
            <a class="btn btn-outline-light" href="#">Logout</a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-3 sidebar p-3 min-vh-100 border-end">
                <!-- User Information -->
                <div class="text-center mb-4">
                    <img src="{{ Storage::url(Auth::user()->profile_photo) }}" class="rounded-circle"
                        alt="Profile Photo" width="150" height="150">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                </div>
                <!-- Navigation Links -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog"></i> Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
            
            <!-- Right Content Area -->
            <div class="col-md-9 p-4">
                <!-- Analyze Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Analyze</h4>
                    </div>
                    <div class="card-body">
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

                            <div class="form-group">
                                <label for="operation">Select Operation</label>
                                <select name="operation" id="operation" class="form-control">
                                    <option value="trend">Trend</option>
                                    <option value="seasonality">Seasonality</option>
                                    <option value="forecast">Forecast</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Analyze</button>
                        </form>
                    </div>
                </div>

                <!-- List of Input Time Series Data Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>List of Input Time Series Data</h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach (Auth::user()->files as $file)
                                <li>
                                    <a href="{{ Storage::url($file->filepath) }}">{{ $file->filename }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <button type="button" id="ts-info" class="btn btn-primary" data-toggle="modal"
                            data-target="#ts-info-form">Add More data</button>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Results (Forecast, Trend, Seasonality Analysis)</h5>
                    </div>
                    <div class="card-body">
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
                                            <button type="submit" class="btn btn-secondary">View</button>
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

    <!-- Time Series Info Modal -->
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
                                <option value="D">Daily</option>
                                <option value="W">Weekly</option>
                                <option value="M">Monthly</option>
                                <option value="Y">Yearly</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
