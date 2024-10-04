@extends('layouts.base')

@section('title', 'Logs')

@section('page-title', 'User Activity Logs')

@section('content')
    <div class="container mx-auto px-4">
        <div class="bg-white shadow-lg rounded-lg p-6">

            @if ($logs->isEmpty())
                <p class="text-gray-600 text-center">No logs found for this user.</p>
            @else
                <div class="overflow-x-auto">
                    <!-- Add a unique ID for the table to initialize DataTables -->
                    <table id="logs-table" class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Action</th>
                                <th class="py-3 px-6 text-left">Description</th>
                                <th class="py-3 px-6 text-left">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($logs as $log)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <span class="font-medium">{{ $log->action }}</span>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ $log->description }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ $log->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Initialize DataTables on the logs table -->
    <script>
        $(document).ready(function() {
            $('#logs-table').DataTable({
                "paging": true, // Enables pagination
                "ordering": true, // Enables sorting
                "info": true, // Shows table info
                "searching": true, // Enables searching
                "order": [
                    [2, 'desc']
                ] // Default ordering by the timestamp (column 2)
            });
        });
    </script>
@endsection
