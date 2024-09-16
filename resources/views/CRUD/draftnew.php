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
        <h5 class="my-4">Results (Forecast, Trend, Seasonality Analysis)</h5>
        <div class="container">
            <table id="resultsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Main File</th>
                        <th>Associated Result</th>
                        <th>Operation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentFileId = null;
                    @endphp

                    @foreach ($files as $file)
                        {{-- Check if the current file is different from the previous one --}}
                        @if ($currentFileId !== $file->file_id)
                            {{-- If it's not the first file, close the previous file's row --}}
                            @if ($currentFileId !== null)
                                </td>
                                </tr>
                            @endif

                            {{-- Start a new row for the new file --}}
                            <tr>
                                <td>{{ $file->filename }}</td> {{-- Main file name --}}
                                <td>
                                    @if ($file->assoc_filename)
                                        {{ $file->assoc_filename }}
                                    @else
                                        No associated results found.
                                    @endif
                                </td>
                                <td>{{ $file->operation ?? 'N/A' }}</td> {{-- Operation if available --}}
                                <td>
                                    {{-- View Associated File Button --}}
                                    @if ($file->assoc_filename)
                                        {{-- <form action="{{ route('manage.results', $file->file_assoc_id) }}" method="post" style="display: inline-block;"> --}}
                                        <form action="{{ route('manage.results', $file->file_assoc_id) }}"
                                            method="post" style="display: inline-block;">

                                            @csrf
                                            {{-- <button type="submit" class="btn btn-primary btn-sm">View</button> --}}
                                        </form>
                                    @endif

                                    {{-- Delete Button --}}
                                    {{-- <form action="{{ route('delete.result', $file->file_assoc_id) }}" method="post" --}}
                                    <form action="{{ route('crud.delete', $file->file_assoc_id) }}" method="post"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>

                                    {{-- Update Button --}}
                                    {{-- <a href="{{ route('edit.result', $file->file_assoc_id) }}"
                                        class="btn btn-warning btn-sm">Update</a> --}}
                                </td>
                            </tr>

                            {{-- Update the current file ID --}}
                            @php
                                $currentFileId = $file->file_id;
                            @endphp
                        @endif
                    @endforeach

                    {{-- Close the last open row --}}
                    @if ($currentFileId !== null)
                        </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#resultsTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

</body>

</html>
