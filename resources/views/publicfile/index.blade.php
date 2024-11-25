@extends('layouts.base')

@section('title', 'Public Files')

@section('page-title', 'Publicly Shared Time Series Data')

@section('content')
    @if (session('upload_success'))
        <!-- Notification Popup -->
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('upload_success') }}
        </div>
    @elseif (session('upload_failed'))
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('upload_failed') }}
        </div>
    @elseif (session('add_success'))
        <!-- Notification Popup -->
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('add_success') }}
        </div>
    @elseif (session('add_failed'))
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('add_failed') }}
        </div>
    @elseif (session('upvote_success'))
        <!-- Notification Popup -->
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('upvote_success') }}
        </div>
    @elseif (session('upvote_failed'))
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('upvote_failed') }}
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
    <div class="flex justify-end items-center mb-6">
        <button onclick="toggleModal(true)"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            Add Data
        </button>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6 border">
        @foreach ($publicfiles as $file)
            <div onclick="openModal('{{ $file->id }}')"
                class="cursor-pointer bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                <!-- Thumbnail -->
                <div class="w-full h-24 overflow-hidden rounded-t-lg">
                    <img src="{{ $file->thumbnail ? asset('storage/' . $file->thumbnail) : 'https://dotdata.com/wp-content/uploads/2020/07/time-series.jpg' }}"
                        class="w-full h-full object-cover" alt="Thumbnail">
                </div>

                <!-- Content inside the container with padding -->
                <div class="p-5 border">
                    <!-- Title -->
                    <h4 class="text-base font-semibold text-gray-700 text-lg break-words hover:text-blue-600">
                        {{ $file->title }}
                    </h4>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm mt-2 mb-2 break-words overflow-hidden">
                        {{ Str::limit($file->description, 50) }}
                    </p>

                    <!-- Uploaded By & Date -->
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <img src="{{ $file->user->profile_photo ? asset('storage/' . $file->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                            class="w-6 h-6 rounded-full mr-3" alt="Profile Photo">
                        <div>
                            <span class="font-medium text-xs">{{ $file->user->name }}</span>
                            <span class="mx-1 text-xs">•</span>
                            <span class="text-xs">{{ $file->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <hr>
                    <!-- Upvote Section -->
                    <div class="flex items-center text-gray-700 mt-3 justify-end">
                        <form action="{{ route('public-files.upvote', $file->id) }}" method="post">
                            @csrf
                            <!-- Upvote Button -->
                            <button type="submit" class="flex items-center space-x-2 text-blue-500 hover:text-blue-700">
                                <!-- Upvote Icon -->
                                <i class="fa-solid fa-circle-up" style="color: #2977ff;"></i>
                                <!-- Upvote Text -->
                                <span class="text-sm font-medium">Upvote</span>
                                <!-- Upvote Count -->
                                <span class="ml-3 text-sm">{{ $file->upvotes()->count() }}</span>
                            </button>
                        </form>

                    </div>
                </div>


            </div>



            <!-- Modal for displaying full details -->
            <div id="modal-{{ $file->id }}"
                class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-800 bg-opacity-50"
                onclick="handleOutsideClick(event, '{{ $file->id }}')">
                <div class="bg-white rounded-lg shadow-lg max-w-lg w-full relative" onclick="event.stopPropagation();">
                    <!-- Prevent click propagation -->
                    <!-- Close Button -->
                    <button onclick="closeModal('{{ $file->id }}')"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                    <!-- Modal Content -->
                    <div class="w-full h-40 overflow-hidden rounded-t-lg">
                        <img src="{{ $file->thumbnail ? asset('storage/' . $file->thumbnail) : 'https://dotdata.com/wp-content/uploads/2020/07/time-series.jpg' }}"
                            class="w-full h-full object-cover" alt="Thumbnail">
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-blue-600 mb-3 break-words overflow-hidden">
                            {{ $file->title }}</h2>
                        <p class="text-gray-700 mb-2">{{ $file->description }}</p>
                        <div class="flex items-center mb-2 space-x-2">
                            <img id="profileImage"
                                src="{{ $file->user->profile_photo ? asset('storage/' . $file->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                class="w-6 h-6 object-cover rounded-full" alt="Profile Photo">
                            <p class="text-gray-600 text-sm">Uploaded by: {{ $file->user->name }}</p>
                        </div>
                        <p class="text-gray-500 text-sm">Created: {{ $file->created_at->format('M d, Y') }}</p>
                    </div>

                    <!-- Add to Account Button with Tooltip -->
                    <div class="absolute bottom-6 right-6 flex items-center space-x-4">
                        <!-- Tooltip Trigger Icon -->
                        <div class="relative group">
                            <form action="{{ route('public-files.add-data-to-user-account', $file->id) }}" method="POST">
                                @csrf
                                <button
                                    class="bg-blue-600 text-white p-2 rounded-full shadow-lg hover:bg-blue-700 focus:outline-none">
                                    <i class="fas fa-plus"></i> <!-- Plus icon -->
                                </button>
                            </form>
                            <!-- Tooltip Text -->
                            <span
                                class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 hidden group-hover:block text-xs bg-gray-800 text-white py-1 px-2 rounded">
                                Add this public data to your account
                            </span>
                        </div>

                        <!-- Upvote Section -->
                        <div class="relative group">
                            <form action="{{ route('public-files.upvote', $file->id) }}" method="POST">
                                @csrf
                                <!-- Upvote Button -->
                                <button type="submit"
                                    class="flex items-center space-x-2 bg-gray-100 text-blue-500 hover:bg-gray-200 p-2 rounded-full shadow focus:outline-none">
                                    <!-- Upvote Icon -->
                                    <i class="fa-solid fa-circle-up text-blue-500"></i>
                                    <!-- Upvote Text -->
                                    <span class="text-sm font-medium">Upvote: {{ $file->upvotes()->count() }}</span>
                                </button>
                            </form>
                            <!-- Tooltip Text -->
                            <span
                                class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 hidden group-hover:block text-xs bg-gray-800 text-white py-1 px-2 rounded">
                                Upvote this file to show your appreciation
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div id="dataModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-3xl w-full relative">
            <!-- Close button -->
            <button onclick="toggleModal(false)"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                &times;
            </button>

            <h3 class="text-xl font-semibold mb-6 text-blue-600">Upload Public File</h3>

            <!-- Form with two columns -->
            <form action="{{ route('public-files.upload') }}" method="post" enctype="multipart/form-data"
                class="grid grid-cols-2 gap-6">
                @csrf

                <!-- Title -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-gray-700 font-medium">Title</label>
                    <input type="text" name="title"
                        class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600"
                        placeholder="Enter title for the file" required>
                    <p class="text-sm text-gray-500 mt-1">Provide a brief title for your data file.</p>
                </div>

                <!-- File -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-gray-700 font-medium">File</label>
                    <input type="file" name="file" accept=".csv, .xls, .xlsx"
                        class="w-full p-2 border border-gray-300 rounded" required>
                    <p class="text-sm text-gray-500 mt-1">Upload your data file (CSV, XLS, or XLSX).</p>
                </div>

                <!-- Frequency -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-gray-700 font-medium">Frequency</label>
                    <select name="freq"
                        class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600">
                        <option value="D">Daily</option>
                        <option value="W">Weekly</option>
                        <option value="M">Monthly</option>
                        <option value="Q">Quarterly</option>
                        <option value="Y">Yearly</option>
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Choose how frequently the data is recorded.</p>
                </div>

                <!-- Description -->
                <div class="col-span-2">
                    <label class="block text-gray-700 font-medium">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600"
                        placeholder="Brief description of the file contents" required></textarea>
                    <p class="text-sm text-gray-500 mt-1">A short summary of the data provided in the file.</p>
                </div>

                <!-- Topics -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-gray-700 font-medium">Topics</label>
                    <input type="text" name="topics"
                        class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600"
                        placeholder="e.g., finance, health, technology" required>
                    <p class="text-sm text-gray-500 mt-1">List relevant topics separated by commas.</p>
                </div>

                <!-- Thumbnail -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-gray-700 font-medium">Thumbnail</label>
                    <input type="file" name="thumbnail" accept=".jpg, .jpeg, .png"
                        class="w-full p-2 border border-gray-300 rounded">
                    <p class="text-sm text-gray-500 mt-1">Optional: Upload a thumbnail (JPEG or PNG).</p>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 text-right">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function handleOutsideClick(event, modalId) {
            const modal = document.getElementById(`modal-${modalId}`);
            if (modal && event.target === modal) {
                closeModal(modalId);
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(`modal-${modalId}`);
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function toggleModal(show) {
            const modal = document.getElementById('dataModal');
            if (show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }
    </script>

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
        }
    </script>
@endsection
