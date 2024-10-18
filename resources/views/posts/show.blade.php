{{-- @extends('layouts.base')

@section('title', 'Logs')

@section('page-title', 'User Activity Logs')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>Posted by: {{ $post->user->name }}</p>
    <p>{{ $post->body }}</p>
    <hr>
    <h2>Comments</h2>

    <!-- Display Comments and Replies -->
    <div id="comments-section">
        @foreach ($post->comments as $comment)
            <div class="comment">
                <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}</p>
                
                <!-- Replies for this comment -->
                <div class="replies" style="margin-left: 20px;">
                    @foreach ($comment->replies as $reply)
                        <p><strong>{{ $reply->user->name }}:</strong> {{ $reply->body }}</p>
                    @endforeach
                </div>

                <!-- Reply button for this comment -->
                <button class="reply-btn" data-comment-id="{{ $comment->id }}"
                    data-username="{{ $comment->user->name }}">Reply</button>
            </div>
        @endforeach
    </div>

    <!-- Comment or Reply Form -->
    <div id="comment-form-section">
        <h3 id="comment-header">Post a comment</h3>
        <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" id="parent_id" name="parent_id" value="">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea id="comment-body" name="body" rows="4" placeholder="Write your comment here..."></textarea>
            <button type="submit">Submit</button>
            <button type="button" id="cancel-reply" style="display:none;">Cancel Reply</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentForm = document.getElementById('comment-form');
            const parentIdField = document.getElementById('parent_id');
            const commentHeader = document.getElementById('comment-header');
            const commentBody = document.getElementById('comment-body');
            const cancelReplyButton = document.getElementById('cancel-reply');
            const replyButtons = document.querySelectorAll('.reply-btn');

            // When reply button is clicked, set the parent_id and update form header
            replyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const username = this.getAttribute('data-username');

                    parentIdField.value = commentId; // Set parent_id to the comment ID
                    commentHeader.textContent = `Replying to ${username}`;
                    commentBody.placeholder = `Reply to ${username}...`;

                    cancelReplyButton.style.display = 'inline'; // Show the cancel button
                });
            });

            // When cancel reply is clicked, reset the form to post a new comment
            cancelReplyButton.addEventListener('click', function() {
                parentIdField.value = ''; // Reset parent_id
                commentHeader.textContent = 'Post a comment';
                commentBody.placeholder = 'Write your comment here...';

                cancelReplyButton.style.display = 'none'; // Hide the cancel button
            });
        });
    </script>
@endsection --}}

{{-- 
@extends('layouts.base')

@section('title', 'Logs')

@section('page-title', 'User Activity Logs')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>Posted by: {{ $post->user->name }}</p>
    <p>{{ $post->body }}</p>
    <hr>
    <h2>Comments</h2>

    <!-- Display Comments and Replies -->
    <div id="comments-section">
        @foreach ($post->comments as $comment)
            <div class="comment" style="margin-bottom: 20px;">
                <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}</p>

                <!-- Replies for this comment -->
                @if ($comment->replies->count())
                    <div class="replies" style="margin-left: 20px;">
                        @foreach ($comment->replies as $reply)
                            <div class="reply">
                                <p><strong>{{ $reply->user->name }}:</strong> {{ $reply->body }}</p>

                                <!-- Nested Replies (if needed) -->
                                @if ($reply->replies->count())
                                    <div class="replies" style="margin-left: 20px;">
                                        @foreach ($reply->replies as $nestedReply)
                                            <p><strong>{{ $nestedReply->user->name }}:</strong> {{ $nestedReply->body }}</p>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Reply button for this reply -->
                                <button class="reply-btn" data-comment-id="{{ $reply->id }}"
                                    data-username="{{ $reply->user->name }}">Reply</button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Reply button for this comment -->
                <button class="reply-btn" data-comment-id="{{ $comment->id }}"
                    data-username="{{ $comment->user->name }}">Reply</button>
            </div>
        @endforeach
    </div>

    <!-- Comment or Reply Form -->
    <div id="comment-form-section" style="margin-top: 40px;">
        <h3 id="comment-header">Post a comment</h3>
        <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" id="parent_id" name="parent_id" value="">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea id="comment-body" name="body" rows="4" placeholder="Write your comment here..." required></textarea>
            <button type="submit">Submit</button>
            <button type="button" id="cancel-reply" style="display:none;">Cancel Reply</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentForm = document.getElementById('comment-form');
            const parentIdField = document.getElementById('parent_id');
            const commentHeader = document.getElementById('comment-header');
            const commentBody = document.getElementById('comment-body');
            const cancelReplyButton = document.getElementById('cancel-reply');
            const replyButtons = document.querySelectorAll('.reply-btn');

            // When a reply button is clicked, set the parent_id and update form header
            replyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const username = this.getAttribute('data-username');

                    parentIdField.value = commentId; // Set parent_id to the comment/reply ID
                    commentHeader.textContent = `Replying to ${username}`;
                    commentBody.placeholder = `Reply to ${username}...`;

                    cancelReplyButton.style.display = 'inline'; // Show the cancel button
                });
            });

            // When cancel reply is clicked, reset the form to post a new comment
            cancelReplyButton.addEventListener('click', function() {
                parentIdField.value = ''; // Reset parent_id
                commentHeader.textContent = 'Post a comment';
                commentBody.placeholder = 'Write your comment here...';

                cancelReplyButton.style.display = 'none'; // Hide the cancel button
            });
        });
    </script>
@endsection --}}

@extends('layouts.base')

@section('title', 'Post Details')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>Posted by: {{ $post->user->name }}</p>
    <p>{{ $post->body }}</p>
    <hr>

    <h2>Comments</h2>

    <!-- Display Comments and Replies -->
    <div id="comments-section">
        @foreach ($post->comments->where('parent_id', null) as $comment)
            @include('posts.partials.comment', ['comment' => $comment])
        @endforeach
    </div>

    <!-- Comment or Reply Form -->
    <div id="comment-form-section">
        <h3 id="comment-header">Post a comment</h3>
        <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" id="parent_id" name="parent_id" value="">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea id="comment-body" name="body" rows="4" placeholder="Write your comment here..."></textarea>
            <button type="submit">Submit</button>
            <button type="button" id="cancel-reply" style="display:none;">Cancel Reply</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentForm = document.getElementById('comment-form');
            const parentIdField = document.getElementById('parent_id');
            const commentHeader = document.getElementById('comment-header');
            const commentBody = document.getElementById('comment-body');
            const cancelReplyButton = document.getElementById('cancel-reply');
            const replyButtons = document.querySelectorAll('.reply-btn');

            // When reply button is clicked, set the parent_id and update form header
            replyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const username = this.getAttribute('data-username');

                    parentIdField.value = commentId; // Set parent_id to the comment ID
                    commentHeader.textContent = `Replying to ${username}`;
                    commentBody.placeholder = `Reply to ${username}...`;

                    cancelReplyButton.style.display = 'inline'; // Show the cancel button
                });
            });

            // When cancel reply is clicked, reset the form to post a new comment
            cancelReplyButton.addEventListener('click', function() {
                parentIdField.value = ''; // Reset parent_id
                commentHeader.textContent = 'Post a comment';
                commentBody.placeholder = 'Write your comment here...';

                cancelReplyButton.style.display = 'none'; // Hide the cancel button
            });
        });
    </script>
@endsection
