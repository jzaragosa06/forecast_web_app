@extends('layouts.base')

@section('title', 'Discussion')

@section('page-title', 'Discussion')

@section('content')
    <!-- Button to Create New Post -->
    <div class="flex justify-end mb-4">
        <button id="create-post-btn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Create New
            Post</button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Section for current user's posts (Left Column) -->
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold mb-4 text-gray-600">Your Posts</h2>
            <!-- Search bar for user's posts -->

            <div class="mb-3">
                <input type="text" id="my-posts-search" placeholder="Search your posts..."
                    class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
            </div>

            @if ($myPosts->isEmpty())
                <p class="text-sm text-gray-500">You haven't created any posts yet.</p>
            @else
                <div id="my-posts-container" class="space-y-3">
                    @foreach ($myPosts as $post)
                        <div
                            class="bg-white p-3 rounded-lg shadow hover:shadow-md transition relative max-w-full overflow-hidden">
                            <!-- Add a blue arrow icon at the top-right -->
                            <a href="{{ route('posts.show', $post->id) }}" class="absolute top-3 right-3 text-blue-600">
                                <!-- Arrow icon or content goes here -->
                            </a>

                            <div>
                                <!-- Post title and other details -->
                                <h4 class="text-base font-semibold mb-2 text-gray-600">
                                    <a href="{{ route('posts.show', $post) }}"
                                        class="hover:text-blue-600 truncate">{{ $post->title }}</a>
                                </h4>

                                <!-- Flex container for profile image and posted by text -->
                                <div class="flex items-center mb-2">
                                    <img id="profileImage"
                                        src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                        class="w-5 h-5 object-cover rounded-full mr-2" alt="Profile Photo">
                                    <p class="text-xs text-gray-500">Posted by: {{ $post->user->name }}</p>
                                </div>

                                <!-- Post body with overflow control -->
                                <p class="text-sm text-gray-500 break-words overflow-hidden">
                                    {{ Str::limit(strip_tags($post->body), 100, '...') }}
                                </p>
                            </div>

                            <!-- Topics section -->
                            <div class="flex flex-wrap mt-2">
                                @foreach (explode(',', $post->topics) as $topic)
                                    <span class="bg-gray-200 text-gray-800 text-xs font-medium mr-2 mb-2 px-2 py-1 rounded">
                                        {{ $topic }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>


            @endif
        </div>

        <!-- Section for other users' posts (Right Column) -->
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold mb-4 text-gray-600">Other Users' Posts</h2>
            <!-- Search bar for other users' posts -->
            <div class="mb-3">
                <input type="text" id="other-posts-search" placeholder="Search other users' posts..."
                    class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
            </div>

            @if ($otherPosts->isEmpty())
                <p class="text-sm text-gray-500">No posts available from other users.</p>
            @else
                <div id="other-posts-container" class="space-y-3">
                    @foreach ($otherPosts as $post)
                        <div
                            class="bg-white p-3 rounded-lg shadow hover:shadow-md transition relative max-w-full overflow-hidden">
                            <!-- Add a blue arrow icon at the top-right -->
                            <a href="{{ route('posts.show', $post->id) }}" class="absolute top-3 right-3 text-blue-600">
                                <!-- Arrow icon or content goes here -->
                            </a>

                            <div>
                                <!-- Post title and other details -->
                                <h4 class="text-base font-semibold mb-2 text-gray-600">
                                    <a href="{{ route('posts.show', $post) }}"
                                        class="hover:text-blue-600 truncate">{{ $post->title }}</a>
                                </h4>

                                <!-- Flex container for profile image and posted by text -->
                                <div class="flex items-center mb-2">
                                    <img id="profileImage"
                                        src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                        class="w-5 h-5 object-cover rounded-full mr-2" alt="Profile Photo">
                                    <p class="text-xs text-gray-500">Posted by: {{ $post->user->name }}</p>
                                </div>

                                <!-- Post body with overflow control -->
                                <p class="text-sm text-gray-500 break-words overflow-hidden">
                                    {{ Str::limit(strip_tags($post->body), 250, '...') }}
                                </p>
                            </div>

                            <!-- Topics section -->
                            <div class="flex flex-wrap mt-2">
                                @foreach (explode(',', $post->topics) as $topic)
                                    <span class="bg-gray-200 text-gray-800 text-xs font-medium mr-2 mb-2 px-2 py-1 rounded">
                                        {{ $topic }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modal for creating a new post -->
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" id="create-post-modal">
        <div
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md transform transition-transform duration-200 scale-100 translate-x-[-50%] translate-y-[-50%] top-[50%] left-[50%] absolute">

            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-semibold text-gray-800">Create Post</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" required
                            class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
                    </div>

                    <div class="mb-4">
                        <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                        <div id="editor" class="bg-white border border-gray-300 rounded" style="height: 300px;"></div>
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

                    <div class="flex justify-end space-x-4">
                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                            data-dismiss="modal">Close</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
                    </div>
                </form>
            </div>
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
            $('#my-posts-search').on('input', function() {
                let searchText = $(this).val().toLowerCase();
                $('#my-posts-container div').each(function() {
                    let postTitle = $(this).find('h3').text().toLowerCase();
                    $(this).toggle(postTitle.includes(searchText));
                });
            });

            $('#other-posts-search').on('input', function() {
                let searchText = $(this).val().toLowerCase();
                $('#other-posts-container div').each(function() {
                    let postTitle = $(this).find('h3').text().toLowerCase();
                    $(this).toggle(postTitle.includes(searchText));
                });
            });
        });
    </script>
@endsection
