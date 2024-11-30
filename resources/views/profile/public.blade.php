@extends('layouts.base')

@section('title', 'Profile')

@section('page-title', 'Profile')

@section('content')
    <div class="container mx-auto p-8">
        <div class="flex">
            <!-- Left Section (Profile Info) -->
            <div class="w-1/3 bg-white shadow-lg p-4 rounded-lg">
                <!-- Profile Image -->
                <div class="flex items-center justify-center relative group">
                    <img id="profileImage"
                        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                        class="w-32 h-32 object-cover rounded-full" alt="Profile Photo">
                </div>



                <div class="mt-4">
                    <h2 class="text-xl font-bold text-gray-600">{{ $user->name }}</h2>
                    @if ($user->headline)
                        <p class="text-sm text-gray-600">{{ $user->headline }}</p>
                    @else
                        <p class="text-xs text-gray-600">No headline added</p>
                    @endif

                    @if ($user->location)
                        <p class="text-sm text-gray-500">{{ $user->location }}</p>
                    @else
                        <p class="text-xs text-gray-600">No location added</p>
                    @endif

                    @if ($user->contact_num)
                        <p class="text-sm text-gray-500">{{ $user->contact_num }}</p>
                    @else
                        <p class="text-xs text-gray-600">No contact number added</p>
                    @endif


                </div>

                <!-- Social Links -->
                <div class="mt-4">

                    <!-- Social Links -->
                    @if (
                        $user->social_links_linkedin ||
                            $user->social_links_github ||
                            $user->social_links_kaggle ||
                            $user->social_links_medium)
                        <p class="text-sm text-gray-600 mb-1">Social Links:</p>
                        <div class="flex space-x-2">
                            @isset($user->social_links_linkedin)
                                <a href="{{ $user->social_links_linkedin }}" class="text-blue-500" title="LinkedIn">
                                    <i class="fab fa-linkedin text-2xl"></i>
                                </a>
                            @endisset

                            @isset($user->social_links_github)
                                <a href="{{ $user->social_links_github }}" class="text-gray-800" title="GitHub">
                                    <i class="fab fa-github text-2xl"></i>
                                </a>
                            @endisset

                            @isset($user->social_links_kaggle)
                                <a href="{{ $user->social_links_kaggle }}" class="text-blue-400" title="Kaggle">
                                    <i class="fab fa-kaggle text-2xl"></i>
                                </a>
                            @endisset

                            @isset($user->social_links_medium)
                                <a href="{{ $user->social_links_medium }}" class="text-gray-500" title="Medium">
                                    <i class="fab fa-medium text-2xl"></i>
                                </a>
                            @endisset
                        </div>
                    @else
                        <p class="text-xs text-gray-600 mb-1">No social links added</p>
                    @endif

                </div>


                <!-- About Section -->
                <div class="mt-6">
                    <h3 class="font-semibold">About</h3>
                    <p class="text-sm text-gray-700 mt-2">{{ $user->about ?? 'No description added' }}</p>
                </div>

                <!-- Skills Section -->
                <div class="mt-6">
                    <h3 class="font-semibold">Skills</h3>
                    <div class="flex flex-wrap mt-2">

                        @if ($user->skills)
                            @foreach (explode(',', $user->skills) as $skill)
                                <span
                                    class="bg-blue-100 text-blue-600 text-xs font-medium mr-2 mb-2 px-2.5 py-0.5 rounded">{{ $skill }}</span>
                            @endforeach
                        @else
                            <p class="text-gray-500 text-xs">No skills added</p>
                        @endif

                    </div>
                </div>


                                <!-- Total of Results Shared Section -->
                <div class="mt-6">
                    <h3 class="font-semibold">Total Results Shared</h3>
                    <p class="text-sm text-gray-700 mt-2 flex items-center">
                        <i class="fa-solid fa-square-poll-vertical fa-xl text-blue-600 mr-2"></i>
                        {{ $totalshared }}
                    </p>
                </div>

                <!-- Date Joined Section -->
                <div class="mt-6">
                    <h3 class="font-semibold">Joined</h3>
                    <p class="text-sm text-gray-700 mt-2 flex items-center">
                        <i class="fa-solid fa-user fa-xl text-blue-600 mr-2"></i>
                        {{ $user->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            <div class="w-2/3 flex space-x-6">
                <!-- First Part -->
                <div class="rounded-lg flex-grow">
                    <div class="p-6 text-left text-gray-500">
                        <!-- Title for the first part -->
                        <h2 class="text-xl font-semibold text-gray-400 mb-4">Posts</h2>

                        @if ($myPosts->isEmpty())
                            <p class="text-sm text-gray-500 text-center">No post yet</p>
                        @else
                            <div id="my-posts-container" class="grid grid-cols-1 md:grid-cols-2 gap-4 space-y-0">
                                @foreach ($myPosts as $post)
                                    <div class="bg-white rounded-lg shadow hover:shadow-md transition">
                                        <!-- Image section with no padding/margin on edges -->
                                        <div class="w-full h-24 overflow-hidden rounded-t-lg">
                                            <img id="profileImage"
                                                src="{{ $post->post_image ? asset('storage/' . $post->post_image) : 'https://dotdata.com/wp-content/uploads/2020/07/time-series.jpg' }}"
                                                class="w-full h-full object-cover rounded-t-lg" alt="Post Image">
                                        </div>
                                        <div class="p-3">
                                            <h3 class="text-lg font-semibold mb-1">
                                                <a href="{{ route('posts.show', $post->id) }}"
                                                    class="hover:text-blue-600">{{ $post->title }}</a>
                                            </h3>
                                            <p class="text-xs text-gray-500 mb-2">Posted by: {{ $post->user->name }}</p>
                                            <p class="text-xs text-gray-500">{!! Str::limit($post->body, 100) !!}</p>
                                            <div class="flex flex-wrap mt-2">
                                                @foreach (explode(',', $post->topics) as $topic)
                                                    <span
                                                        class="bg-blue-100 text-blue-600 text-xs font-medium mr-2 mb-2 px-2 py-1 rounded">{{ $topic }}</span>
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
                </div>
            </div>

        </div>
    </div>




@endsection
