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
                                    class="bg-gray-200 text-gray-800 text-xs font-medium mr-2 mb-2 px-2.5 py-0.5 rounded">{{ $skill }}</span>
                            @endforeach
                        @else
                            <p class="text-gray-500 text-xs">ANo skills added</p>
                        @endif

                    </div>
                </div>
            </div>


            <div class="w-2/3 flex space-x-6">
                <!-- First Part -->
                <div class="bg-gray-100 shadow-inner rounded-lg flex-grow">
                    <div class="p-6 text-left text-gray-500">
                        <!-- Title for the first part -->
                        <h2 class="text-xl font-semibold text-gray-400 mb-4">Posts</h2>

                        @if ($myPosts->isEmpty())
                            <p class="text-sm text-gray-500">No post yet</p>
                        @else
                            <div id="my-posts-container" class="space-y-3">
                                @foreach ($myPosts as $post)
                                    <div class="bg-white p-3 rounded-lg shadow hover:shadow-md transition">
                                        <h3 class="text-lg font-semibold mb-1">
                                            <a href="{{ route('posts.show', $post->id) }}"
                                                class="hover:text-blue-600">{{ $post->title }}</a>
                                        </h3>
                                        <p class="text-xs text-gray-500 mb-2">Posted by: {{ $post->user->name }}</p>
                                        <p class="text-xs text-gray-500">{!! Str::limit($post->body, 100) !!}</p>
                                        <div class="flex flex-wrap mt-2">
                                            @foreach (explode(',', $post->topics) as $topic)
                                                <span
                                                    class="bg-gray-200 text-gray-800 text-xs font-medium mr-2 mb-2 px-2 py-1 rounded">{{ $topic }}</span>
                                            @endforeach
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
