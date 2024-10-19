@extends('layouts.base')

@section('title', 'Profile')

@section('page-title', 'Profile')

@section('content')
    <div class="container mx-auto mt-10 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="col-span-1 flex flex-col space-y-6">
                <div class="bg-white shadow-md rounded-lg overflow-hidden flex-grow">
                    <div class="relative group">
                        <div class="flex justify-center p-6">
                            <img id="profileImage"
                                src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                class="w-32 h-32 object-cover rounded-full" alt="Profile Photo">
                        </div>
                        <span
                            class="absolute top-2 right-2 bg-black bg-opacity-50 text-white p-2 rounded-full cursor-pointer hidden group-hover:block"
                            onclick="showEditForm()">
                            <i class="fas fa-edit"></i> <!-- Edit Icon -->
                        </span>
                    </div>
                    <div class="p-4 text-center">
                        <h5 class="text-lg font-semibold">{{ $user->name }}</h5>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <p class="text-gray-600">{{ $user->contact_num }}</p>
                        <p class="text-sm text-gray-500">Member since {{ $user->created_at->format('F Y') }}</p>

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
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
                    <h5 class="text-lg font-semibold text-center mb-4">User Stats</h5>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-project-diagram text-4xl text-indigo-600 mb-2"></i> <!-- Projects Icon -->
                            <p class="font-semibold text-xl">{{ $resultCount }}</p>
                            <p class="text-gray-500">Projects</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-4xl text-indigo-600 mb-2"></i> <!-- Collaborators Icon -->
                            <p class="font-semibold text-xl">{{ $collabCount }}</p>
                            <p class="text-gray-500">Collaborators</p>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showEditForm() {
            document.getElementById('editForm').classList.remove('hidden');
        }

        function hideEditForm() {
            document.getElementById('editForm').classList.add('hidden');
        }
    </script>
@endsection
