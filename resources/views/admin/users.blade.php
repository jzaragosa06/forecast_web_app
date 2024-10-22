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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile
                            Photo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact
                            Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action
                        </th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">{{ $user->contact_num }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">{{ $user->created_at }}</td>
                            <!-- Action Buttons -->
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
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
