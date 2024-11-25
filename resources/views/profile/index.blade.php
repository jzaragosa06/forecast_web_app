@extends('layouts.base')

@section('title', 'Profile')

@section('page-title', 'Profile')

@section('content')
    @if (session('success'))
        <!-- Notification Popup -->
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('success') }}
        </div>
    @elseif (session('fail'))
        <!-- Notification Popup -->
        <div id="notification"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity opacity-100">
            {{ session('fail') }}
        </div>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('notification');
            if (notification) {
                // Hide after 3 seconds (3000 milliseconds)
                setTimeout(() => {
                    notification.classList.add('opacity-0');
                }, 3000);

                // Remove the element completely after the fade-out
                setTimeout(() => {
                    notification.remove();
                }, 3500);
            }
        });
    </script>

    <style>
        .transition-opacity {
            transition: opacity 0.5s ease-in-out;
        }
    </style>
    <div class="container mx-auto p-8">
        <div class="flex">
            <!-- Left Section (Profile Info) -->
            <div class="w-1/3 bg-white shadow-lg p-4 rounded-lg">
                <!-- Profile Image -->
                <div class="flex items-center justify-center relative group">
                    <img id="profileImage"
                        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                        class="w-32 h-32 object-cover rounded-full" alt="Profile Photo">
                    <span
                        class="absolute top-2 right-2 bg-black bg-opacity-50 text-white p-2 rounded-full cursor-pointer hidden group-hover:block"
                        onclick="showEditForm()">
                        <i class="fas fa-edit"></i> <!-- Edit Icon -->
                    </span>
                </div>

                <!-- Hidden Form for Image Upload -->
                <form id="editForm" class="hidden mt-4" action="{{ route('profile.update.photo') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <input type="file" name="new_profile_photo" id="profilePhotoInput" accept="image/*"
                            class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <div class="flex justify-center gap-2">
                        <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Finish</button>
                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600"
                            onclick="hideEditForm()">Cancel</button>
                    </div>
                </form>

                <div class="mt-4">
                    <h2 class="text-xl font-bold text-gray-600">{{ $user->name }}</h2>
                    @if ($user->headline)
                        <p class="text-sm text-gray-600">{{ $user->headline }}</p>
                    @else
                        <p class="text-xs text-gray-600">Tell us what you do</p>
                    @endif

                    @if ($user->location)
                        <p class="text-sm text-gray-500">{{ $user->location }}</p>
                    @else
                        <p class="text-xs text-gray-600">Add location</p>
                    @endif

                    @if ($user->contact_num)
                        <p class="text-sm text-gray-500">{{ $user->contact_num }}</p>
                    @else
                        <p class="text-xs text-gray-600">Add contact number</p>
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
                    <p class="text-sm text-gray-700 mt-2">{{ $user->about ?? 'Tell more about yourself' }}</p>
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
                            <p class="text-gray-500 text-xs">Add skills</p>
                        @endif

                    </div>
                </div>

                <!-- Edit Profile Button -->
                <div class="mt-8">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md" onclick="toggleModal()">Edit
                        Profile</button>
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

    <!-- Modal for Editing Profile. omitted -->
    <div id="editProfileModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form action="{{ route('user.update') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Edit Profile</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}"
                                    placeholder="Enter your name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Headline -->
                            <div>
                                <label for="headline" class="block text-sm font-medium text-gray-700">Headline</label>
                                <input type="text" name="headline" id="headline" value="{{ $user->headline }}"
                                    placeholder="Enter your headline"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" id="location" value="{{ $user->location }}"
                                    placeholder="Enter your location"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Contact Number -->
                            <div>
                                <label for="contact_num" class="block text-sm font-medium text-gray-700">Contact
                                    Number</label>
                                <input type="text" name="contact_num" id="contact_num"
                                    value="{{ $user->contact_num }}" placeholder="Enter your contact number"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- About -->
                        <div class="mb-4">
                            <label for="about" class="block text-sm font-medium text-gray-700">About</label>
                            <textarea name="about" id="about" placeholder="Tell us about yourself"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 h-24">{{ $user->about }}</textarea>
                        </div>

                        <!-- Skills -->
                        <div class="mb-4">
                            <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                            <input type="text" name="skills" id="skills" value="{{ $user->skills }}"
                                placeholder="Enter your skills"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Social Links -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Social Links</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="social_links_linkedin" class="text-sm">LinkedIn</label>
                                    <input type="text" name="social_links_linkedin" id="social_links_linkedin"
                                        value="{{ $user->social_links_linkedin }}" placeholder="Enter LinkedIn URL"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="social_links_github" class="text-sm">GitHub</label>
                                    <input type="text" name="social_links_github" id="social_links_github"
                                        value="{{ $user->social_links_github }}" placeholder="Enter GitHub URL"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="social_links_medium" class="text-sm">Medium</label>
                                    <input type="text" name="social_links_medium" id="social_links_medium"
                                        value="{{ $user->social_links_medium }}" placeholder="Enter Medium URL"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="social_links_kaggle" class="text-sm">Kaggle</label>
                                    <input type="text" name="social_links_kaggle" id="social_links_kaggle"
                                        value="{{ $user->social_links_kaggle }}" placeholder="Enter Kaggle URL"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save
                            Changes</button>
                        <button type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                            onclick="toggleModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('editProfileModal');
            modal.classList.toggle('hidden');
        }

        function showEditForm() {
            document.getElementById('editForm').classList.remove('hidden');
        }

        function hideEditForm() {
            document.getElementById('editForm').classList.add('hidden');
        }
    </script>
@endsection
