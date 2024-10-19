

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

                <div class="ml-4 mt-4">
                    <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $user->headline ?? 'Tell us what you do' }}</p>
                    <p class="text-sm text-gray-500">{{ $user->location ?? 'Add location' }}</p>
                    <p class="text-sm text-gray-500">{{ $user->contact_num ?? 'Add contact number' }}</p>
                </div>

                <!-- Social Links -->
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-1">Social Links:</p>
                    <div class="flex space-x-2">
                        <a href="{{ $user->social_links_linkedin ?? '#' }}" class="text-blue-500" title="LinkedIn">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="{{ $user->social_links_github ?? '#' }}" class="text-gray-800" title="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="{{ $user->social_links_kaggle ?? '#' }}" class="text-blue-400" title="Kaggle">
                            <i class="fab fa-kaggle"></i>
                        </a>
                        <a href="{{ $user->social_links_medium ?? '#' }}" class="text-gray-500" title="Medium">
                            <i class="fab fa-medium"></i>
                        </a>
                    </div>
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
                        @foreach (explode(',', $user->skills) as $skill)
                            <span
                                class="bg-gray-200 text-gray-800 text-xs font-medium mr-2 mb-2 px-2.5 py-0.5 rounded">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Edit Profile Button -->
                <div class="mt-8">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md" onclick="toggleModal()">Edit
                        Profile</button>
                </div>
            </div>

            <!-- Right Section (Placeholder for posts) -->
            <div class="w-2/3 bg-gray-100 shadow-inner rounded-lg ml-6">
                <div class="p-6 text-center text-gray-500">
                    List of posts by the user.
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Profile. omitted -->
    <!-- Modal for Editing Profile -->
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
