@extends('layouts.base')

@section('title', 'Multivariate Trend Result')

@section('page-title', 'Multivariate Trend Result')


@section('content')

    <div class="container mx-auto p-4">
        <div class="flex flex-col lg:flex-row lg:space-x-8">
            <!-- Files I Shared with Others -->
            <div class="lg:w-1/2 w-full bg-white shadow-md rounded-lg p-4 mb-6 lg:mb-0">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Files I Shared with Others</h2>

                @if ($filesSharedByMe->isEmpty())
                    <p class="text-gray-500">You haven't shared any files yet.</p>
                @else
                    <ul class="divide-y divide-gray-200">
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

                @if ($sharedWithMe->isEmpty())
                    <p class="text-gray-500">No files have been shared with you yet.</p>
                @else
                    <ul class="divide-y divide-gray-200">
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

@endsection
