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
                        {{-- <th>Main File</th> --}}
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
                                <!-- View and Delete actions -->

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

</html>


{{-- {
    "tstype": "",
    "colnames": ["var1", "var2", ..."varn"], 
    "components": ["weekly", "yearly", ],
    "seasonality_per_period": {
        "var1": {
            "weekly": {
                "value": [...], 
                "lower": [...], 
                "upper": [...], 
            },
             "yearly": {
                "value": [...], 
                "lower": [...], 
                "upper": [...], 
            }
            
        }
        ...
    }
} --}}
