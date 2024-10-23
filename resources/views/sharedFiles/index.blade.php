@extends('layouts.base')

@section('title', 'Share Results')

@section('page-title', 'Share Results with Other')

@section('content')

    <div class="container mx-auto p-4">
        <div class="flex flex-col lg:flex-row lg:space-x-8">
            <!-- Files I Shared with Others -->
            <div class="lg:w-1/2 w-full bg-white shadow-md rounded-lg p-4 mb-6 lg:mb-0">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Files I Shared with Others</h2>
                <!-- Search Bar for Files I Shared -->
                <input type="text" id="searchSharedByMe" placeholder="Search files or shared to..."
                    class="mb-4 p-2 border border-gray-300 rounded w-full" />

                @if ($filesSharedByMe->isEmpty())
                    <p class="text-gray-500">You haven't shared any files yet.</p>
                @else
                    <ul id="sharedByMeList" class="divide-y divide-gray-200">
                        @foreach ($filesSharedByMe as $file)
                            <li class="py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">{{ $file->assoc_filename }}</p>
                                    <p class="text-xs text-gray-500">Shared to: {{ $file->shared_to }}</p>
                                    <p class="text-xs text-gray-400">On: {{ $file->shared_at }}</p>
                                </div>
                                <a href="{{ $file->associated_file_path }}" class="text-indigo-500 text-sm hover:underline">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Files Shared with Me -->
            <div class="lg:w-1/2 w-full bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Files Shared with Me</h2>

                <!-- Search Bar for Files Shared with Me -->
                <input type="text" id="searchSharedWithMe" placeholder="Search files or shared by..."
                    class="mb-4 p-2 border border-gray-300 rounded w-full" />

                @if ($sharedWithMe->isEmpty())
                    <p class="text-gray-500">No files have been shared with you yet.</p>
                @else
                    <ul id="sharedWithMeList" class="divide-y divide-gray-200">
                        @foreach ($sharedWithMe as $file)
                            <li class="py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">{{ $file->assoc_filename }}</p>
                                    <p class="text-xs text-gray-500">Shared by: {{ $file->shared_by }}</p>
                                    <p class="text-xs text-gray-400">On: {{ $file->shared_at }}</p>
                                </div>
                                <a href="{{ route('share.view_file', ['file_assoc_id' => $file->file_assoc_id, 'user_id' => $file->user_id]) }}"
                                    class="text-indigo-500 text-sm hover:underline">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Search functionality for "Files I Shared with Others"
        document.getElementById('searchSharedByMe').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let list = document.getElementById('sharedByMeList');
            let items = list.getElementsByTagName('li');

            Array.from(items).forEach(function(item) {
                let fileName = item.querySelector('p.text-sm').textContent.toLowerCase();
                let sharedTo = item.querySelector('p.text-xs.text-gray-500').textContent.toLowerCase();

                if (fileName.includes(filter) || sharedTo.includes(filter)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Search functionality for "Files Shared with Me"
        document.getElementById('searchSharedWithMe').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let list = document.getElementById('sharedWithMeList');
            let items = list.getElementsByTagName('li');

            Array.from(items).forEach(function(item) {
                let fileName = item.querySelector('p.text-sm').textContent.toLowerCase();
                let sharedBy = item.querySelector('p.text-xs.text-gray-500').textContent.toLowerCase();

                if (fileName.includes(filter) || sharedBy.includes(filter)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
@endsection
