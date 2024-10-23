@extends('layouts.admin_base')

@section('title', 'User Queries')

@section('page-title', 'Queries')

@section('content')
    <div class="overflow-x-auto">
        <table id="queries-table" class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Sent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($userQueries as $query)
                    <tr class="{{ $query->has_responded == '1' ? 'bg-gray-100' : 'bg-blue-100' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">{{ $query->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">{{ $query->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">{{ $query->email }}</td>
                        <td class="px-6 py-4 text-xs text-gray-900">{{ $query->message }}</td>
                        <td class="px-6 py-4 text-xs text-gray-900">{{ $query->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                            @if ($query->has_responded == '1')
                                <span
                                    class="inline-flex px-2 py-1 leading-5 text-gray-700 bg-gray-300 rounded-full">Responded</span>
                            @else
                                <span class="inline-flex px-2 py-1 leading-5 text-blue-700 bg-blue-300 rounded-full">Not
                                    Responded</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                            <form action="{{ route('queries.respond', $query->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="responded"
                                    value="{{ $query->has_responded == '1' ? '0' : '1' }}">
                                <button type="submit"
                                    class="text-xs font-semibold text-white bg-blue-500 px-3 py-1 rounded hover:bg-blue-600">
                                    {{ $query->has_responded == '1' ? 'Mark as Not Responded' : 'Mark as Responded' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#queries-table').DataTable();
        });
    </script>
@endsection
