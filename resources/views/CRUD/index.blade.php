@extends('layouts.base')

@section('title', 'Manage Files')

@section('page-title', 'Manage Files')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            <div class="bg-gray-100 rounded-lg shadow p-6 lg:col-span-1">
                <h5 class="text-lg font-semibold mb-4">Files and Results Tree</h5>
                @if ($files->isEmpty())
                    <div class="flex items-center justify-center py-4">

                        <p class="text-gray-600 font-semibold">No input or results available.</p>
                    </div>
                @else
                    <ul class="space-y-6">
                        @php
                            $currentFileId = null;
                        @endphp

                        @foreach ($files as $file)
                            @if ($currentFileId !== $file->file_id)
                                @if ($currentFileId !== null)
                    </ul>
                    </li>
                @endif

                <li class="p-4 bg-white rounded shadow mb-4">
                    <p class="font-medium">{{ $file->filename }}</p>
                    <span class="text-sm text-gray-500">Associated Results:</span>
                    <ul class="ml-6 space-y-3">
                        @php
                            $currentFileId = $file->file_id;
                        @endphp
                        @endif

                        @if ($file->assoc_filename)
                            <li class="flex items-center justify-between"> <!-- Flex container for alignment -->
                                <p class="w-3/4">{{ $file->assoc_filename }}</p>
                                <!-- Set consistent width to align buttons -->
                                {{-- <form action="{{ route('manage.results.post', $file->file_assoc_id) }}" method="post">
                                    @csrf
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">View</button>
                                </form> --}}
                            </li>
                            <hr>
                        @else
                            <li class="text-gray-500">No associated results found.</li>
                        @endif
                        @endforeach

                        @if ($currentFileId !== null)
                    </ul>
                </li>
                @endif
                </ul>
                @endif
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
                                        <button type="button" class="bg-blue-500 text-white px-3 py-1 rounded"
                                            id="shareButton" data-file-assoc-id="{{ $file_assoc->file_assoc_id }}">
                                            Share
                                        </button>
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

        <!-- Modal -->
        <div id="shareModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                <h3 class="text-lg font-semibold mb-4">Share with Users</h3>
                <form method="POST" action="{{ route('share.with_other') }}">
                    @csrf
                    <input type="hidden" name="file_assoc_id" id="fileAssocId"> <!-- Hidden field for file_assoc_id -->

                    <div>
                        @foreach ($users as $user)
                            <div>
                                <input type="checkbox" name="shared_to_user_ids[]" value="{{ $user->id }}"
                                    id="user_{{ $user->id }}">
                                <label for="user_{{ $user->id }}">{{ $user->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                            Share
                        </button>
                        <button type="button" id="closeModalButton"
                            class="ml-4 bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            // Get modal and button elements
            const shareButtons = document.querySelectorAll('#shareButton');
            const shareModal = document.getElementById('shareModal');
            const closeModalButton = document.getElementById('closeModalButton');
            const fileAssocIdInput = document.getElementById('fileAssocId');

            // Show modal when clicking any Share button
            shareButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileAssocId = this.dataset
                        .fileAssocId; // Get the associated file_assoc_id
                    fileAssocIdInput.value = fileAssocId; // Set the hidden input value
                    shareModal.classList.remove('hidden');
                    shareModal.classList.add('block');
                });
            });

            // Hide modal when clicking the Close button
            closeModalButton.addEventListener('click', function() {
                shareModal.classList.remove('block');
                shareModal.classList.add('hidden');
            });

            // Hide modal when clicking outside the modal content
            window.addEventListener('click', function(event) {
                if (event.target === shareModal) {
                    shareModal.classList.remove('block');
                    shareModal.classList.add('hidden');
                }
            });
        });

        $(document).ready(function() {
            $('#filesTable').DataTable(); // Initialize DataTables for input file table
            $('#resultsTable').DataTable(); // Initialize DataTables for results file table
        });
    </script>
@endsection
