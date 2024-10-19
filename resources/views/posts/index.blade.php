@extends('layouts.base')

@section('title', 'Discussion')

@section('page-title', 'Discussion')

@section('content')
    <!-- Button to Create New Post -->
    <div class="flex justify-end mb-4">
        <button id="create-post-btn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Create New
            Post</button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Section for current user's posts (Left Column) -->
        <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Your Posts</h2>

            <!-- Search bar for user's posts -->
            <div class="mb-4">
                <input type="text" id="my-posts-search" placeholder="Search your posts..."
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            @if ($myPosts->isEmpty())
                <p class="text-gray-500">You haven't created any posts yet.</p>
            @else
                <div id="my-posts-container" class="space-y-4">
                    @foreach ($myPosts as $post)
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold"><a href="{{ route('posts.show', $post->id) }}"
                                    class="hover:text-blue-600">{{ $post->title }}</a></h3>
                            <p class="text-sm text-gray-500">Posted by: {{ $post->user->name }}</p>
                            <p class="text-gray-700 mt-2">{{ Str::limit($post->body, 100) }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Section for other users' posts (Right Column) -->
        <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Other Users' Posts</h2>

            <!-- Search bar for other users' posts -->
            <div class="mb-4">
                <input type="text" id="other-posts-search" placeholder="Search other users' posts..."
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            @if ($otherPosts->isEmpty())
                <p class="text-gray-500">No posts available from other users.</p>
            @else
                <div id="other-posts-container" class="space-y-4">
                    @foreach ($otherPosts as $post)
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold"><a href="{{ route('posts.show', $post) }}"
                                    class="hover:text-blue-600">{{ $post->title }}</a></h3>
                            <p class="text-sm text-gray-500">Posted by: {{ $post->user->name }}</p>
                            <p class="text-gray-700 mt-2">{{ Str::limit($post->body, 100) }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modal for creating a new post -->
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" id="create-post-modal"
        style="display:none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md md:max-w-lg">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-semibold text-gray-800">Create Post</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal"
                    aria-label="Close">&times;</button>
            </div>

            <div class="modal-body">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="title" class="block font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" required
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mt-4">
                        <label for="body" class="block font-medium text-gray-700">Body</label>
                        <textarea id="body" name="body" rows="5" required
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="mt-4">
                        <label for="file_assoc_id" class="block font-medium text-gray-700">Result</label>
                        <select name="file_assoc_id" id="file_assoc_id"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            @foreach ($file_assocs as $file_assoc)
                                <option value="{{ $file_assoc->file_assoc_id }}">{{ $file_assoc->assoc_filename }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end mt-6 space-x-4">
                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
                            data-dismiss="modal">Close</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Show the modal for creating a new post
            $('#create-post-btn').click(function() {
                $('#create-post-modal').removeClass('hidden').hide().fadeIn(200);
                $('#create-post-modal > div').removeClass('scale-95').addClass('scale-100');
            });

            // Close modals
            $('[data-dismiss="modal"]').click(function() {
                $(this).closest('.fixed').fadeOut(200);
            });

            // Close modal when clicking outside content
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
                    if (postTitle.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('#other-posts-search').on('input', function() {
                let searchText = $(this).val().toLowerCase();
                $('#other-posts-container div').each(function() {
                    let postTitle = $(this).find('h3').text().toLowerCase();
                    if (postTitle.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
@endsection
