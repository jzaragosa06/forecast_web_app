{{-- 
@extends('layouts.admin_base')

@section('title', 'Admin Users')

@section('page-title', 'Users')

@section('content')

    <div class="container mx-auto p-4">
        <!-- Constrain height and make this scrollable -->
        <div class="grid grid-cols-1 gap-4 bg-gray-50 max-h-[500px] overflow-y-scroll p-4">
            @foreach ($users as $user)
                <div
                    class="flex items-center bg-white shadow-md rounded-lg p-4 hover:shadow-lg transition-shadow duration-300">
                    <!-- Profile Photo -->
                    <div class="flex-shrink-0">
                        <img class="h-16 w-16 rounded-full"
                            src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                            alt="{{ $user->name }}">
                    </div>
                    <!-- User Info -->
                    <div class="ml-4 flex-grow">
                        <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <p class="text-gray-500 text-sm">{{ $user->contact_num }}</p>
                        <p class="text-gray-500 text-sm">Date Created: {{ $user->created_at }}</p>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex space-x-2">

                        <form action="{{ route('admin.delete', $user->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection --}}

@extends('layouts.admin_base')

@section('title', 'Admin Users')

@section('page-title', 'Users')

@section('content')

    <div class="container mx-auto p-4">
        <!-- User Table -->
        <div class="bg-gray-50 p-4 shadow-md rounded-lg">
            <table id="users-table" class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Profile Photo</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Contact Number</th>
                        <th class="py-2 px-4 border-b">Date Created</th>
                        <th class="py-2 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <!-- Profile Photo -->
                            <td class="py-2 px-4 border-b">
                                <img class="h-12 w-12 rounded-full"
                                    src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                    alt="{{ $user->name }}">
                            </td>
                            <!-- User Info -->
                            <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->contact_num }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->created_at }}</td>
                            <!-- Action Buttons -->
                            <td class="py-2 px-4 border-b">
                                <form action="{{ route('admin.delete', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- DataTables Script -->
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search bar
                "lengthChange": true, // Enable entries per page options
                "info": true // Display info about table status
            });
        });
    </script>
@endsection
