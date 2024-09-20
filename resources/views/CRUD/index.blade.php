@extends('layouts.base')

@section('title', 'Manage Files')

@section('page-title', 'Manage Files')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Files and Results Tree on the left -->
            <div class="bg-white rounded-lg shadow p-4 lg:col-span-1">
                <h5 class="text-lg font-semibold mb-4">Files and Results Tree</h5>
                <ul class="space-y-4">
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
                    <p class="font-medium">{{ $file->filename }}</p>
                    <span class="text-sm text-gray-500">Associated Results:</span>
                    <ul class="ml-4 space-y-2">
                        @php
                            $currentFileId = $file->file_id;
                        @endphp
                        @endif

                        @if ($file->assoc_filename)
                            <li class="flex items-center justify-between">
                                <p>{{ $file->assoc_filename }}</p>
                                <form action="{{ route('manage.results.post', $file->file_assoc_id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">View</button>
                                </form>
                            </li>
                        @else
                            <li class="text-gray-500">No associated results found.</li>
                        @endif
                        @endforeach

                        @if ($currentFileId !== null)
                    </ul>
                </li>
                @endif
                </ul>
            </div>

            <!-- Datatables on the right -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Input File Datatable -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h5 class="text-lg font-semibold mb-4">Files</h5>
                    <table id="filesTable" class="min-w-full divide-y divide-gray-200 text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">File Name</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Description</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($files_input as $file)
                                <tr>
                                    <td class="px-4 py-2">{{ $file->file_id }}</td>
                                    <td class="px-4 py-2">{{ $file->filename }}</td>
                                    <td class="px-4 py-2">{{ $file->type }}</td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <form action="{{ route('input.file.graph.view.post', $file->file_id) }}"
                                            method="post" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="bg-blue-500 text-white px-3 py-1 rounded">View</button>
                                        </form>
                                        <form action="{{ route('crud.delete.file', $file->file_id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Result Files Datatable -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h5 class="text-lg font-semibold mb-4">Result Files (Forecast, Trend, Seasonality Analysis)</h5>
                    <table id="resultsTable" class="min-w-full divide-y divide-gray-200 text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">File ID</th>
                                <th class="px-4 py-2">Result File Name</th>
                                <th class="px-4 py-2">Operation</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($files_assoc as $file_assoc)
                                <tr>
                                    <td class="px-4 py-2">{{ $file_assoc->file_assoc_id }}</td>
                                    <td class="px-4 py-2">{{ $file_assoc->assoc_filename }}</td>
                                    <td class="px-4 py-2">{{ $file_assoc->operation }}</td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <form action="{{ route('manage.results.post', $file_assoc->file_assoc_id) }}"
                                            method="post" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="bg-blue-500 text-white px-3 py-1 rounded">View</button>
                                        </form>
                                        <form action="{{ route('crud.delete.file_assoc', $file_assoc->file_assoc_id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
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
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#filesTable').DataTable(); // Initialize DataTables for input file table
            $('#resultsTable').DataTable(); // Initialize DataTables for results file table
        });
    </script>
@endsection
