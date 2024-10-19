<div class="comment">
    <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}</p>

    <!-- Reply button -->
    <button class="reply-btn" data-comment-id="{{ $comment->id }}"
        data-username="{{ $comment->user->name }}">Reply</button>

    <!-- Nested Replies -->
    @if ($comment->replies->count() > 0)
        <div class="replies" style="margin-left: 20px;">
            @foreach ($comment->replies as $reply)
                @include('posts.partials.comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>
