@extends('layouts.base')

@section('title', 'Profile')

@section('page-title', 'Profile')

@section('content')
    <div class="container mx-auto mt-10 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="col-span-1 mb-6">
                <div class="bg-white shadow-md rounded-lg overflow-hidden h-full">
                    <div class="relative group">
                        <div class="flex justify-center p-6">
                            <img id="profileImage"
                                src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                class="w-32 h-32 object-cover rounded-full" alt="Profile Photo">
                        </div>
                        <span
                            class="absolute top-2 right-2 bg-black bg-opacity-50 text-white p-2 rounded-full cursor-pointer hidden group-hover:block"
                            onclick="showEditForm()">&#9998;</span> <!-- Edit Icon -->
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
            </div>

            <!-- User Information Card -->
            <div class="col-span-2 mb-6">
                <div class="bg-white shadow-md rounded-lg h-full">
                    <div class="bg-gray-200 p-4">
                        <h5 class="font-semibold">User Information</h5>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <li class="p-4"><strong>ID:</strong> {{ $user->id }}</li>
                        <li class="p-4"><strong>Name:</strong> {{ $user->name }}</li>
                        <li class="p-4"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="p-4"><strong>Contact Number:</strong> {{ $user->contact_num }}</li>
                        <li class="p-4"><strong>Created At:</strong> {{ $user->created_at->format('F j, Y, g:i a') }}
                        </li>
                        <li class="p-4"><strong>Updated At:</strong> {{ $user->updated_at->format('F j, Y, g:i a') }}
                        </li>
                    </ul>
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
