@extends('layouts.base')

@section('title', 'Share Results')

@section('page-title', 'Share Results')

@section('content')
    <div x-data="{ selectedTab: 'sharedWithMe' }" class="flex justify-center p-4">
        <div class="w-full max-w-2xl">
            <!-- Toggle Buttons for "Shared with Others" and "Shared with Me" -->
            <div class="flex justify-center space-x-4 mb-6">
                <button @click="selectedTab = 'sharedByMe'"
                    :class="selectedTab === 'sharedByMe' ? 'bg-blue-500 text-white' :
                        'bg-white text-blue-500 border border-blue-500'"
                    class="px-4 py-2 rounded-full font-semibold focus:outline-none">
                    Shared with Others
                </button>
                <button @click="selectedTab = 'sharedWithMe'"
                    :class="selectedTab === 'sharedWithMe' ? 'bg-blue-500 text-white' :
                        'bg-white text-blue-500 border border-blue-500'"
                    class="px-4 py-2 rounded-full font-semibold focus:outline-none">
                    Shared with Me
                </button>
            </div>

            <div class="flex flex-col space-y-6">
                <!-- Files I Shared with Others -->
                <div x-show="selectedTab === 'sharedByMe'" class="bg-white shadow-md rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800">Files I Shared with Others</h2>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-square-poll-horizontal fa-xl text-blue-600"></i>
                            <span class="text-gray-800">Total: {{ $shareByMeCount }}</span>
                        </div>
                    </div>

                    <!-- Minimalist Search Bar for Files I Shared -->
                    <input type="text" id="searchSharedByMe" placeholder="Search files by name or recipient..."
                        class="mt-4 mb-4 p-2 border border-gray-300 rounded-full w-full focus:outline-none" />
                    @if ($filesSharedByMe->isEmpty())
                        <p class="text-gray-500 text-center">You haven't shared any files yet.</p>
                    @else
                        <ul id="sharedByMeList" class="divide-y divide-gray-200">
                            @foreach ($filesSharedByMe as $file)
                                <li class="py-3 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">{{ $file->assoc_filename }}</p>
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $file->profile_photo ? asset('storage/' . $file->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                                class="w-5 h-5 object-cover rounded-full" alt="Profile Photo">
                                            <p class="text-xs text-gray-500">Shared to: {{ $file->shared_to }}</p>
                                        </div>
                                        <p class="text-xs text-gray-400">On: {{ $file->created_at }}</p>
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

                <!-- Files Shared with Me -->
                <div x-show="selectedTab === 'sharedWithMe'" class="bg-white shadow-md rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800">Files Shared to Me</h2>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-square-poll-horizontal fa-xl text-blue-600"></i>
                            <span class="text-gray-800">Total: {{ $shareToMeCount }}</span>
                        </div>
                    </div>
                    <!-- Minimalist Search Bar for Files Shared with Me -->
                    <input type="text" id="searchSharedWithMe" placeholder="Search files by name or sender..."
                        class="mb-4 p-2 border border-gray-300 rounded-full w-full focus:outline-none" />
                    @if ($sharedWithMe->isEmpty())
                        <p class="text-gray-500 text-center">No files have been shared with you yet.</p>
                    @else
                        <ul id="sharedWithMeList" class="divide-y divide-gray-200">
                            @foreach ($sharedWithMe as $file)
                                <li class="py-3 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">{{ $file->assoc_filename }}</p>
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $file->profile_photo ? asset('storage/' . $file->profile_photo) : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png' }}"
                                                class="w-5 h-5 object-cover rounded-full" alt="Profile Photo">
                                            <p class="text-xs text-gray-500">Shared by: {{ $file->shared_by }}</p>
                                        </div>
                                        <p class="text-xs text-gray-400">On: {{ $file->created_at }}</p>
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
    </div>
@endsection

@section('scripts')
    <script>
        // Search functionality that only matches the start of the filename or shared name
        function searchFiles(inputId, listId, nameSelector) {
            document.getElementById(inputId).addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const list = document.getElementById(listId);
                const items = list.getElementsByTagName('li');

                Array.from(items).forEach(item => {
                    const textContent = item.querySelector(nameSelector).textContent.toLowerCase();
                    item.style.display = textContent.startsWith(filter) ? '' : 'none';
                });
            });
        }

        searchFiles('searchSharedByMe', 'sharedByMeList', 'p.text-sm');
        searchFiles('searchSharedWithMe', 'sharedWithMeList', 'p.text-sm');
    </script>
@endsection
