@extends('layouts.base')

@section('title', 'Manage Files')

@section('page-title', 'Manage Files & Results')

@section('content')
    @if (session('success'))
        <!-- Notification Popup -->
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('success') }}
        </div>
    @elseif (session('fail'))
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('fail') }}
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('notification');
            if (notification) {
                // Hide after 3 seconds (3000 milliseconds)
                setTimeout(() => {
                    notification.classList.add('opacity-0');
                }, 3000);

                // Remove the element completely after the fade-out
                setTimeout(() => {
                    notification.remove();
                }, 3500);
            }
        });
    </script>

    <style>
        .transition-opacity {
            transition: opacity 0.5s ease-in-out;
        }
    </style>
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-gray-100 rounded-lg shadow p-6 lg:col-span-1">
                <h5 class="text-lg font-semibold mb-4 text-gray-600">Files and Results Tree</h5>
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
                    @php
                        $currentFileId = $file->file_id;
                    @endphp
                    <a class="hover:text-blue-600" href="{{ route('input.file.graph.view.get', $currentFileId) }}">
                        <p class="font-medium text-gray-600 hover:text-blue-600">{{ $file->filename }}</p>
                    </a>
                    <span class="text-sm text-gray-500">Associated Results:</span>
                    <ul class="ml-6 space-y-3">
                        @endif

                        @if ($file->assoc_filename)
                            <li class="flex items-center justify-between text-sm"> <!-- Flex container for alignment -->
                                <a class="hover:text-blue-600"
                                    href="{{ route('manage.results.get', $file->file_assoc_id) }}">
                                    <p class="w-3/4">{{ $file->assoc_filename }}</p>
                                </a>
                            </li>
                            <hr>
                        @else
                            <li class="text-gray-500 text-xs">No associated results found.</li>
                        @endif
                        @endforeach

                        @if ($currentFileId !== null)
                    </ul>
                </li>
                @endif
                </ul>
                @endif
            </div>

            <div x-data="{ selectedTab: 'results' }" class="lg:col-span-2 space-y-6">
                <!-- Toggle Buttons for Files and Results -->
                <div class="flex space-x-4 mb-4">
                    <button @click="selectedTab = 'files'"
                        :class="selectedTab === 'files' ? 'bg-blue-500 text-white' :
                            'bg-white text-blue-500 border border-blue-500'"
                        class="px-4 py-2 rounded font-semibold focus:outline-none">
                        Input Files
                    </button>
                    <button @click="selectedTab = 'results'"
                        :class="selectedTab === 'results' ? 'bg-blue-500 text-white' :
                            'bg-white text-blue-500 border border-blue-500'"
                        class="px-4 py-2 rounded font-semibold focus:outline-none">
                        Results
                    </button>

                    <button @click="selectedTab = 'posts'"
                        :class="selectedTab === 'posts' ? 'bg-blue-500 text-white' :
                            'bg-white text-blue-500 border border-blue-500'"
                        class="px-4 py-2 rounded font-semibold focus:outline-none">
                        Posts
                    </button>
                    <button @click="selectedTab = 'publicly-shared-files'"
                        :class="selectedTab === 'publicly-shared-files' ? 'bg-blue-500 text-white' :
                            'bg-white text-blue-500 border border-blue-500'"
                        class="px-4 py-2 rounded font-semibold focus:outline-none">
                        Publicly-shared Files
                    </button>
                </div>

                <!-- Files Section -->
                <div x-show="selectedTab === 'files'" class="space-y-4">
                    <h5 class="text-base font-semibold mb-2 text-gray-700">Files</h5>
                    @if ($files_input->isEmpty())
                        <p class="text-sm text-gray-500 text-center">No files found</p>
                    @else
                        @foreach ($files_input as $file)
                            <div class="bg-white rounded-lg shadow p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h6 class="font-semibold text-gray-700">{{ $file->filename }}</h6>
                                        <p class="text-sm text-gray-500">Type: {{ $file->type }}</p>
                                        <p class="text-sm text-gray-500">Created on:
                                            {{ $file->created_at->diffForHumans() }}
                                        </p>
                                        <p class="text-sm text-gray-500">Description: {{ $file->description }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('input.file.graph.view.get', $file->file_id) }}">
                                            <button type="button"
                                                class="bg-blue-500 text-white px-3 py-1 rounded">View</button>
                                        </a>
                                        <form action="{{ route('crud.delete.file', $file->file_id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Results Section -->
                <div x-show="selectedTab === 'results'" class="space-y-4">
                    <h5 class="text-base font-semibold mb-2 text-gray-700">Result Files (Forecast, Trend, Seasonality
                        Analysis)</h5>
                    @if ($files_assoc->isEmpty())
                        <p class="text-sm text-gray-500 text-center">No post found</p>
                    @else
                        @foreach ($files_assoc as $file_assoc)
                            <div class="bg-white rounded-lg shadow p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h6 class="font-semibold text-gray-700">{{ $file_assoc->assoc_filename }}</h6>
                                        <p class="text-sm text-gray-500">Operation: {{ $file_assoc->operation }}</p>
                                        <p class="text-sm text-gray-500">Created on:
                                            {{ $file_assoc->created_at->diffForHumans() }}</p>
                                        <p class="text-sm text-gray-500">Description: {{ $file_assoc->description }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="button" class="bg-blue-500 text-white px-3 py-1 rounded"
                                            id="shareButton" data-file-assoc-id="{{ $file_assoc->file_assoc_id }}">
                                            Share
                                        </button>
                                        <a href="{{ route('manage.results.get', $file_assoc->file_assoc_id) }}">
                                            <button type="button"
                                                class="bg-blue-500 text-white px-3 py-1 rounded">View</button>
                                        </a>
                                        <form action="{{ route('crud.delete.file_assoc', $file_assoc->file_assoc_id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div x-show="selectedTab === 'posts'" class="space-y-4">
                    <h5 class="text-base font-semibold mb-2 text-gray-700">Posts</h5>
                    @if ($posts->isEmpty())
                        <p class="text-sm text-gray-500 text-center">No post found</p>
                    @else
                        @foreach ($posts as $post)
                            <div class="bg-white rounded-lg shadow p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h6 class="font-semibold text-gray-700">
                                            {{ Str::limit(strip_tags($post->title), 50, '...') }}</h6>
                                        <!-- Posted By Section -->
                                        <div class="flex items-center mb-2">
                                            <img id="profileImage"
                                                src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                                class="w-5 h-5 object-cover rounded-full mr-2" alt="Profile Photo">
                                            <p class="text-xs text-gray-500">Posted by: {{ $post->user->name }}</p>
                                        </div>
                                        <p class="text-sm text-gray-500 break-words overflow-hidden mb-2">
                                            {{ Str::limit(strip_tags($post->body), 125, '...') }}
                                        </p>
                                        <p class="text-sm text-gray-500">Created on:
                                            {{ $post->created_at->diffForHumans() }}
                                        </p>
                                        <!-- Topics Section -->
                                        <div class="flex flex-wrap mt-2">
                                            @foreach (explode(',', $post->topics) as $topic)
                                                <span
                                                    class="bg-blue-100 text-blue-600 text-xs font-medium mr-2 mb-2 px-3 py-1 rounded-lg">
                                                    {{ $topic }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('posts.show', $post) }}">
                                            <button type="button"
                                                class="bg-blue-500 text-white px-3 py-1 rounded">View</button>
                                        </a>
                                        <form action="{{ route('posts.delete', $post->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

                <div x-show="selectedTab === 'publicly-shared-files'" class="space-y-4">
                    <h5 class="text-base font-semibold mb-2 text-gray-700">Files Shared on Public</h5>

                    @if ($files_shared_on_public->isEmpty())
                        <p class="text-sm text-gray-500 text-center">No post found</p>
                    @else
                        @foreach ($files_shared_on_public as $file)
                            <div class="bg-white rounded-lg shadow p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h6 class="font-semibold text-gray-700">{{ $file->title }}</h6>
                                        <p class="text-sm text-gray-500">Type: {{ $file->freq }}</p>
                                        <p class="text-sm text-gray-500">Created on:
                                            {{ $file->created_at->diffForHumans() }}</p>
                                        <p class="text-sm text-gray-500">Description: {{ $file->description }}</p>
                                        <!-- Topics Section -->
                                        <div class="flex flex-wrap mt-2">
                                            @foreach (explode(',', $file->topics) as $topic)
                                                <span
                                                    class="bg-blue-100 text-blue-600 text-xs font-medium mr-2 mb-2 px-3 py-1 rounded-lg">
                                                    {{ $topic }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('public-files.delete', $file->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>


        </div>


        <div id="shareModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 p-6">
                <h3 class="text-lg font-semibold mb-4">Share with Users</h3>

                <input type="text" id="userSearch" placeholder="Search users..."
                    class="mb-4 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <form method="POST" action="{{ route('share.with_other') }}">
                    @csrf
                    <input type="hidden" name="file_assoc_id" id="fileAssocId"> <!-- Hidden field for file_assoc_id -->

                    <div class="max-h-64 overflow-y-auto border border-gray-300 rounded p-2 mb-4" id="userList">
                        @foreach ($users as $user)
                            <div class="flex items-center space-x-2 mb-2">
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                    class="w-8 h-8 object-cover rounded-full" alt="Profile Photo">
                                <div class="flex-1">
                                    <p class="text-sm">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                                <input type="checkbox" name="shared_to_user_ids[]" value="{{ $user->id }}"
                                    id="user_{{ $user->id }}" class="user-checkbox">
                            </div>
                        @endforeach
                    </div>

                    <div class="border border-gray-300 rounded p-2 mb-4">
                        <h4 class="text-sm font-semibold">Selected Users:</h4>
                        <div id="selectedUsers" class="text-gray-500">
                            Please select
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
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


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const userCheckboxes = document.querySelectorAll('.user-checkbox');
                const selectedUsersDiv = document.getElementById('selectedUsers');
                const userSearchInput = document.getElementById('userSearch');

                const sharedUsers = @json($shared_users); // Pass the shared users data to JS

                // Function to update selected users display
                function updateSelectedUsers() {
                    const selectedUsers = Array.from(userCheckboxes)
                        .filter(checkbox => checkbox.checked)
                        .map(checkbox => {
                            const userDiv = checkbox.closest('div'); // Get the user div
                            const name = userDiv.querySelector('p.text-sm').innerText; // Get the user name
                            const email = userDiv.querySelector('p.text-xs').innerText; // Get the user email
                            const profilePic = userDiv.querySelector('img').src; // Get the user profile picture
                            return `<div class="flex items-center space-x-2 mt-2">
                                <img src="${profilePic}" class="w-8 h-8 object-cover rounded-full" alt="Profile Photo">
                                <div>
                                    <p class="text-sm">${name}</p>
                                    <p class="text-xs text-gray-500">${email}</p>
                                </div>
                            </div>`;
                        });

                    selectedUsersDiv.innerHTML = selectedUsers.length > 0 ? selectedUsers.join('') : 'Please select';
                }

                // Function to check which users the file is shared with
                function checkSharedUsers(fileAssocId) {
                    userCheckboxes.forEach(checkbox => {
                        const userId = checkbox.value;
                        // Check if the user is already shared for this file_assoc_id
                        const isShared = sharedUsers.some(share => share.file_assoc_id == fileAssocId && share
                            .shared_to_user_id == userId);
                        checkbox.checked = isShared;
                    });
                    updateSelectedUsers();
                }

                // Add event listener to checkboxes
                userCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedUsers);
                });

                // Search functionality
                userSearchInput.addEventListener('input', function() {
                    const filter = userSearchInput.value.toLowerCase();
                    userCheckboxes.forEach(checkbox => {
                        const userDiv = checkbox.closest('div'); // Get the user div
                        const name = userDiv.querySelector('p.text-sm').innerText
                            .toLowerCase(); // Get user name
                        userDiv.style.display = name.includes(filter) ? '' :
                            'none'; // Show/Hide based on search
                    });

                    // Reset selected users display on search
                    selectedUsersDiv.innerHTML = 'Please select';
                });

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
                        checkSharedUsers(fileAssocId); // Check shared users
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
        </script>

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
