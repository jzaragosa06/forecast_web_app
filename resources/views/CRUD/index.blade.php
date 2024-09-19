<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Result Files</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row">

            <div class="col-lg-4">
                <div class="container">
                    <h5>Files and Results Tree</h5>
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
                                    <form action="{{ route('manage.results', $file->file_assoc_id) }}" method="post">
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

            <div class="col-lg-8">
                <div>
                    <div class="container">
                        <h5>Files</h5>
                        <table id="resultsTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>File Name</th>
                                    <th>Type</th>
                                    <th>Description</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files_input as $file)
                                    <tr>
                                        <td>{{ $file->file_id }}</td>
                                        <td>{{ $file->filename }}</td>
                                        <td>{{ $file->type }}</td>
                                        <td>
                                            <form action="{{ route('input.file.graph.view.post', $file->file_id) }}"
                                                method="post" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">View</button>

                                            </form>

                                            <form action="{{ route('crud.delete.file', $file->file_id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>


                    <div class="container">
                        <h5>Result Files (Forecast, Trend, Seasonality Analysis)</h5>

                        <table id="resultsTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>File ID</th>
                                    <th>Result File Name</th>
                                    <th>Operation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files_assoc as $file_assoc)
                                    <tr>
                                        <td>{{ $file_assoc->file_assoc_id }}</td>
                                        <td>{{ $file_assoc->assoc_filename }}</td>
                                        <td>{{ $file_assoc->operation }}</td>
                                        <td>
                                            <form action="{{ route('manage.results', $file_assoc->file_assoc_id) }}"
                                                method="post" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">View</button>
                                            </form>

                                            <form
                                                action="{{ route('crud.delete.file_assoc', $file_assoc->file_assoc_id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>





    </div>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#resultsTable').DataTable(); // Initialize DataTables
        });
    </script>

</body>

</html>
