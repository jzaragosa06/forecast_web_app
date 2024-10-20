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
            <div class="flex items-center space-x-2 mt-2">
                <button class="text-sm text-gray-500 hover:text-blue-600 flex items-center reply-btn"
                    data-comment-id="{{ $comment->id }}" data-username="{{ $comment->user->name }}">
                    <!-- Reply Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h7m0 0l-4-4m4 4l-4 4m11-4h-1a3 3 0 00-3 3v4a3 3 0 003 3h1m0 0l4-4m-4 4l4-4" />
                    </svg>
                    Reply
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
