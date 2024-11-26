<head>
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<div class="comment p-4 bg-white rounded-lg shadow-sm mb-4">
    <div class="flex items-start space-x-3">
        <!-- Profile Image -->
        <img id="profileImage"
            src="{{ $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
            class="w-8 h-8 object-cover rounded-full" alt="Profile Photo">

        <!-- Comment Content -->
        <div class="flex-1">
            <div class="mb-1">
                <strong>
                    <a href="{{ route('profile.public', $comment->user->id) }}" class="text-blue-600 hover:underline">
                        {{ $comment->user->name }}
                    </a>
                </strong>
                <span class="text-gray-600 text-sm ml-2">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-gray-700">{{ $comment->body }}</p>

            <!-- Reply Button -->
            <div class="flex items-center space-x-2 mt-2"
                onclick="document.getElementById('comment-form-section').scrollIntoView({ behavior: 'smooth' })">
                <button class="text-sm text-gray-500 hover:text-blue-600 flex items-center reply-btn"
                    data-comment-id="{{ $comment->id }}" data-username="{{ $comment->user->name }}">
                    <!-- Reply Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="10" width="10"
                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path fill="#2b76f7"
                            d="M205 34.8c11.5 5.1 19 16.6 19 29.2l0 64 112 0c97.2 0 176 78.8 176 176c0 113.3-81.5 163.9-100.2 174.1c-2.5 1.4-5.3 1.9-8.1 1.9c-10.9 0-19.7-8.9-19.7-19.7c0-7.5 4.3-14.4 9.8-19.5c9.4-8.8 22.2-26.4 22.2-56.7c0-53-43-96-96-96l-96 0 0 64c0 12.6-7.4 24.1-19 29.2s-25 3-34.4-5.4l-160-144C3.9 225.7 0 217.1 0 208s3.9-17.7 10.6-23.8l160-144c9.4-8.5 22.9-10.6 34.4-5.4z" />
                    </svg>
                    <span class="ml-1">Reply</span>
                </button>
            </div>



            <!-- Nested Replies -->
            @if ($comment->replies->count() > 0)
                <div class="replies ml-8 mt-4 border-l-2 border-gray-200 pl-4">
                    @foreach ($comment->replies as $reply)
                        @include('posts.partials.comment', ['comment' => $reply])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
