@extends('layouts.base')

@section('title', 'Logs')

@section('page-title', 'User Activity Logs')

@section('content')
    <h1>Create a New Post</h1>

    <!-- Form to create a new post -->
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div>
            <label for="body">Body</label>
            <textarea id="body" name="body" rows="5" required></textarea>
        </div>

        <div>
            <button type="submit">Create Post</button>
        </div>
    </form>

@endsection

@section('scripts')
    <script></script>
@endsection
