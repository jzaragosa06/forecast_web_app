@extends('layouts.base')

@section('title', 'Discussion')

@section('page-title', 'Discussion')

@section('content')
    @if (session('success'))
        <!-- Notification Popup -->
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('success') }}
        </div>
    @elseif (session('fail'))
        <!-- Notification Popup -->
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


    <!-- Container for Toggle Buttons and Create Post Button -->
    <div class="flex justify-between items-center mb-4">
        <!-- Toggle Buttons for "My Post" and "Others Post" -->
        <div class="flex space-x-2">
            <button id="my-post-btn" class="toggle-btn px-4 py-2 rounded-l text-gray-600 bg-white border border-gray-300"
                onclick="showSection('my-post')">
                My Post
            </button>
            <button id="others-post-btn" class="toggle-btn px-4 py-2 rounded-r text-white bg-blue-600 border border-gray-300"
                onclick="showSection('others-post')">
                Others Post
            </button>
        </div>

        <!-- Button to Create New Post -->
        <button id="create-post-btn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Create Post
            <i class="fa-solid fa-plus fa-beat fa-sm" style="color: #ffffff;"></i>
        </button>
    </div>


    <!-- Section for current user's posts (Left Column) -->
    <div id="my-post-section" class="hidden bg-gray-50 px-20 py-4 rounded-lg shadow-sm">
        <div class="mb-3">
            <input type="text" id="my-posts-search" placeholder="Search your posts..."
                class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
        </div>
        @if ($myPosts->isEmpty())
            <p class="text-sm text-gray-500">You haven't created any posts yet.</p>
        @else
            <!-- Grid for displaying posts -->
            <div id="my-posts-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($myPosts as $post)
                    <div class="bg-white rounded-lg shadow hover:shadow-md transition relative">
                        <!-- Image Section -->
                        <div class="w-full h-24 overflow-hidden rounded-t-lg">
                            <img id="profileImage"
                                src="{{ $post->post_image ? asset('storage/' . $post->post_image) : 'https://dotdata.com/wp-content/uploads/2020/07/time-series.jpg' }}"
                                class="w-full h-full object-cover" alt="Post Image">
                        </div>
                        <div class="p-3">
                            <!-- Post Title -->
                            <h4 class="text-base font-semibold break-words mb-2 text-gray-600 truncate">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="hover:text-blue-600 truncate">{{ $post->title }}</a>
                            </h4>
                            <!-- Posted By Section -->
                            <div class="flex items-center mb-2">
                                <img id="profileImage"
                                    src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                    class="w-5 h-5 object-cover rounded-full mr-2" alt="Profile Photo">
                                <p class="text-xs text-gray-500">Posted by: {{ $post->user->name }} |
                                    {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <!-- Post Body -->
                            <p class="text-sm text-gray-500 break-words overflow-hidden mb-2">
                                {{ Str::limit(strip_tags($post->body), 100, '...') }}
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
                        <hr>
                        <!-- Upvote Section -->
                        <div class="flex items-center text-gray-700 p-4 justify-end">
                            <form action="{{ route('posts.upvote', $post->id) }}" method="POST">
                                @csrf
                                <!-- Upvote Button -->
                                <button type="submit"
                                    class="flex items-center space-x-2 text-blue-500 hover:text-blue-700">
                                    <!-- Upvote Icon -->
                                    <i class="fa-solid fa-circle-up" style="color: #2977ff;"></i>
                                    <!-- Upvote Text -->
                                    <span class="text-sm font-medium">Upvote</span>
                                    <!-- Upvote Count -->
                                    <span class="ml-3 text-sm">{{ $post->upvotes()->count() }}</span>
                                </button>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>

        @endif
    </div>


    <!-- Section for other users' posts (Right Column) -->
    <div id="others-post-section" class="bg-gray-50 px-20 py-4 rounded-lg shadow-sm">
        <div class="mb-3">
            <input type="text" id="other-posts-search" placeholder="Search other users' posts..."
                class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
        </div>
        @if ($otherPosts->isEmpty())
            <p class="text-sm text-gray-500">No posts available from other users.</p>
        @else
            <!-- Grid for displaying posts -->
            <div id="other-posts-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($otherPosts as $post)
                    <div class="bg-white rounded-lg shadow hover:shadow-md transition relative">
                        <!-- Image Section -->
                        <div class="w-full h-24 overflow-hidden rounded-t-lg">
                            <img id="profileImage"
                                src="{{ $post->post_image ? asset('storage/' . $post->post_image) : 'https://dotdata.com/wp-content/uploads/2020/07/time-series.jpg' }}"
                                class="w-full h-full object-cover" alt="Post Image">
                        </div>
                        <div class="p-3">
                            <!-- Post Title -->
                            <h4 class="text-base font-semibold break-words mb-2 text-gray-600 truncate">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="hover:text-blue-600 truncate">{{ $post->title }}</a>
                            </h4>
                            <!-- Posted By Section -->
                            <div class="flex items-center mb-2">
                                <img id="profileImage"
                                    src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                    class="w-5 h-5 object-cover rounded-full mr-2" alt="Profile Photo">
                                <p class="text-xs text-gray-500">Posted by: {{ $post->user->name }} |
                                    {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <!-- Post Body -->
                            <p class="text-sm text-gray-500 break-words overflow-hidden mb-2">
                                {{ Str::limit(strip_tags($post->body), 100, '...') }}
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
                            <hr>
                            <!-- Upvote Section -->
                            <div class="flex items-center text-gray-700 p-4 justify-end">
                                <form action="{{ route('posts.upvote', $post->id) }}" method="POST">
                                    @csrf
                                    <!-- Upvote Button -->
                                    <button type="submit"
                                        class="flex items-center space-x-2 text-blue-500 hover:text-blue-700">
                                        <!-- Upvote Icon -->
                                        <i class="fa-solid fa-circle-up" style="color: #2977ff;"></i>
                                        <!-- Upvote Text -->
                                        <span class="text-sm font-medium">Upvote</span>
                                        <!-- Upvote Count -->
                                        <span class="ml-3 text-sm">{{ $post->upvotes()->count() }}</span>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif
    </div>


    <!-- JavaScript for Toggle Functionality -->
    <script>
        function showSection(section) {
            // Buttons
            const myPostBtn = document.getElementById('my-post-btn');
            const othersPostBtn = document.getElementById('others-post-btn');

            // Sections
            const myPostSection = document.getElementById('my-post-section');
            const othersPostSection = document.getElementById('others-post-section');

            if (section === 'my-post') {
                myPostBtn.classList.add('bg-blue-600', 'text-white');
                myPostBtn.classList.remove('bg-white', 'text-gray-600');
                othersPostBtn.classList.add('bg-white', 'text-gray-600');
                othersPostBtn.classList.remove('bg-blue-600', 'text-white');

                myPostSection.classList.remove('hidden');
                othersPostSection.classList.add('hidden');
            } else {
                othersPostBtn.classList.add('bg-blue-600', 'text-white');
                othersPostBtn.classList.remove('bg-white', 'text-gray-600');
                myPostBtn.classList.add('bg-white', 'text-gray-600');
                myPostBtn.classList.remove('bg-blue-600', 'text-white');

                myPostSection.classList.add('hidden');
                othersPostSection.classList.remove('hidden');
            }
        }

        // Set default to "Others Post"
        document.addEventListener('DOMContentLoaded', () => {
            showSection('others-post');
        });
    </script>


    <!-- Modal for creating a new post -->
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" id="create-post-modal">
        <div
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md transform transition-transform duration-200 scale-100 translate-x-[-50%] translate-y-[-50%] top-[50%] left-[50%] absolute">

            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-semibold text-gray-800">Create Post</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body px-6 py-4 max-h-[80vh] overflow-y-auto">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" required
                            class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
                    </div>

                    <div class="mb-4">
                        <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                        <div id="editor" class="bg-white border border-gray-300 rounded" style="height: 150px;"></div>
                        <input type="hidden" id="body" name="body">
                    </div>

                    <div class="mb-4">
                        <label for="file_assoc_id" class="block text-sm font-medium text-gray-700">Result</label>
                        <p class="text-xs text-gray-500">Select results from your account to discuss</p>
                        <select name="file_assoc_id" id="file_assoc_id"
                            class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
                            @foreach ($file_assocs as $file_assoc)
                                <option value="{{ $file_assoc->file_assoc_id }}">{{ $file_assoc->assoc_filename }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="topics" class="block text-sm font-medium text-gray-700">Topics</label>
                        <p class="text-xs text-gray-500">Separate topics with commas</p>
                        <input type="text" name="topics" required
                            class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300"
                            placeholder="e.g., Forecast,Inflation">
                    </div>

                    <!-- Improved File Upload Styling -->
                    <div class="mb-4">
                        <label for="post_image" class="block text-sm font-medium text-gray-700">Add Thumbnail
                            Image</label>
                        <p class="text-xs text-gray-500">Optional. Default thumbnail will be used</p>
                        <div
                            class="upload-thumbnail border border-dashed border-gray-300 rounded p-4 text-center hover:bg-gray-50">
                            <input type="file" id="post_image" name="post_image" accept=".jpeg,.png,.jpg,.svg"
                                class="hidden" onchange="previewImage(event)">
                            <label for="post_image" class="cursor-pointer text-blue-600 hover:underline">Upload
                                Image</label>
                            <div id="image-preview" class="mt-4 hidden">
                                <img src="" alt="Image Preview" class="max-h-32 mx-auto rounded-md">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                            data-dismiss="modal">Close</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
                    </div>
                </form>
            </div>
            <script>
                function previewImage(event) {
                    const preview = document.getElementById('image-preview');
                    const img = preview.querySelector('img');
                    const file = event.target.files[0];

                    if (file) {
                        img.src = URL.createObjectURL(file);
                        preview.classList.remove('hidden');
                    } else {
                        img.src = '';
                        preview.classList.add('hidden');
                    }
                }
            </script>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Submit the form with Quill content
        $('form').on('submit', function() {
            $('#body').val(quill.root.innerHTML);
        });

        $(document).ready(function() {
            // Show the modal for creating a new post
            $('#create-post-btn').click(function() {
                $('#create-post-modal').fadeIn(200).removeClass('hidden');
            });

            // Close modal
            $('[data-dismiss="modal"]').click(function() {
                $('#create-post-modal').fadeOut(200);
            });

            // Close modal on clicking outside content
            $('.fixed').click(function(e) {
                if ($(e.target).is(this)) {
                    $(this).fadeOut(200);
                }
            });

            // Search functionality for both sections
            // $('#my-posts-search').on('input', function() {
            //     let searchText = $(this).val().toLowerCase();
            //     $('#my-posts-container div').each(function() {
            //         let postTitle = $(this).find('h4').text().toLowerCase(); // Change h3 to h4
            //         $(this).toggle(postTitle.includes(searchText));
            //     });
            // });

            // $('#other-posts-search').on('input', function() {
            //     let searchText = $(this).val().toLowerCase();
            //     $('#other-posts-container div').each(function() {
            //         let postTitle = $(this).find('h4').text().toLowerCase(); // Change h3 to h4
            //         $(this).toggle(postTitle.includes(searchText));
            //     });
            // });

            $(document).ready(function() {
                // Search functionality for both sections
                $('#my-posts-search').on('input', function() {
                    let searchText = $(this).val().toLowerCase();
                    $('#my-posts-container div').each(function() {
                        let postTitle = $(this).find('h4').text()
                            .toLowerCase(); // Look for titles in h4
                        let postBody = $(this).find('p').text()
                            .toLowerCase(); // Include body text as well
                        let postUser = $(this).find('.text-xs').text()
                            .toLowerCase(); // Check poster name
                        let isVisible = postTitle.includes(searchText) || postBody.includes(
                            searchText) || postUser.includes(searchText);

                        $(this).toggle(
                            isVisible); // Toggle visibility based on the search criteria
                    });
                });

                $('#other-posts-search').on('input', function() {
                    let searchText = $(this).val().toLowerCase();
                    $('#other-posts-container div').each(function() {
                        let postTitle = $(this).find('h4').text()
                            .toLowerCase(); // Look for titles in h4
                        let postBody = $(this).find('p').text()
                            .toLowerCase(); // Include body text as well
                        let postUser = $(this).find('.text-xs').text()
                            .toLowerCase(); // Check poster name
                        let isVisible = postTitle.includes(searchText) || postBody.includes(
                            searchText) || postUser.includes(searchText);

                        $(this).toggle(
                            isVisible); // Toggle visibility based on the search criteria
                    });
                });
            });


        });
    </script>
@endsection
