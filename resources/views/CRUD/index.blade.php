{{-- <!DOCTYPE html>
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
    <div>
        <h5>Results (Forecast, Trend, Seasonality Analysis)</h5>
        <div class="container">


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Result File</th>
                        <th>Operation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->filename }}</td>
                            <td>{{ $file->assoc_filename }}</td>
                            <td>{{ $file->operation }}</td>
                            <td>
                                <form action="{{ route('manage.results', $file->file_assoc_id) }}" method="post"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                </form>

                                <form action="{{ route('crud.delete', $file->file_assoc_id) }}" method="POST"
                                    style="display:inline-block;">
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


</body>

</html> --}}
{{-- 
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
    <div>
        <h5>Results (Forecast, Trend, Seasonality Analysis)</h5>
        <div class="container">


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>File ID</th>
                        <th>Result File Name</th>
                        <th>Operation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->file_assoc_id }}</td>
                            <td>{{ $file->assoc_filename }}</td>
                            <td>{{ $file->operation }}</td>

                            <td>
                                <form action="{{ route('manage.results', $file->file_assoc_id) }}" method="post"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                </form>

                                <form action="{{ route('crud.delete', $file->file_assoc_id) }}" method="POST"
                                    style="display:inline-block;">
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


</body>

</html> --}}


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
    <div>
        <h5>Results (Forecast, Trend, Seasonality Analysis)</h5>
        <div class="container">
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
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->file_assoc_id }}</td>
                            <td>{{ $file->assoc_filename }}</td>
                            <td>{{ $file->operation }}</td>
                            <td>
                                <form action="{{ route('manage.results', $file->file_assoc_id) }}" method="post"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                </form>

                                <form action="{{ route('crud.delete', $file->file_assoc_id) }}" method="POST"
                                    style="display:inline-block;">
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
