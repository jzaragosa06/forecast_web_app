@extends('layouts.base')

@section('title', 'Logs')

@section('page-title', 'User Activity Logs')

@section('content')
    <h1>All Posts</h1>

    <!-- btm to Create New Post -->
    <button id="create-post-btn">Create New Post</button>
    @foreach ($posts as $post)
        <hr>
        <div>
            <h2><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
            <p>Posted by: {{ $post->user->name }}</p>
            <p>{{ $post->body }}</p>
        </div>



        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden" id="create-post-modal"
            style="display:none;">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md md:max-w-lg">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-semibold text-gray-800">Create Post</h5>
                    <button type="button" class="text-gray-600 hover:text-gray-800" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>

                <div class="modal-body">
                    <div class="flex flex-col space-y-6">
                        <form action="{{ route('posts.store') }}" method="POST">
                            @csrf
                            <div>
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" required>
                            </div>

                            <div class="flex space-x-4">
                                <label for="body">Body</label>
                                <textarea id="body" name="body" rows="5" required></textarea>
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
        </div>
    @endforeach
@endsection




@section('scripts')
    <script>
        $('#create-post-btn').click(function() {
            $('#create-post-modal').removeClass('hidden').hide().fadeIn(200);
            $('#create-post-modal > div').removeClass('scale-95').addClass('scale-100');
        });

        // Close modals
        $('[data-dismiss="modal"]').click(function() {
            $(this).closest('.fixed').css('display', 'none');
        });

        // Close modals when clicking outside the modal content
        $('.fixed').click(function(e) {
            if ($(e.target).is(this)) {
                $(this).fadeOut(200, function() {
                    $(this).addClass('hidden');
                });
            }
        });
    </script>
@endsection
