@extends('layouts.base')

@section('title', 'Reviews')

@section('page-title', 'Leave a Review')

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
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Left side for submitting a review -->
        <div class="w-full md:w-1/2 p-6 border rounded-lg shadow-md bg-white">
            <h4 class="text-2xl font-bold mb-4 text-gray-600">Reviews</h4>
            <p class="text-gray-600 mb-6">Help us grow by leaving a review on your experience using our services. Help us to
                let other know our services.</p>
            <form action="{{ route('reviews.add') }}" method="post" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        value="{{ $user->name }}" readonly>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="affiliation" class="block text-sm font-medium text-gray-700">Affiliation</label>
                        <input type="text" name="affiliation" id="affiliation"
                            class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g., PSU-UCC">
                    </div>
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                        <input type="text" name="position" id="position"
                            class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g., Student">
                    </div>
                </div>
                <div>
                    <label for="review" class="block text-sm font-medium text-gray-700">Review</label>
                    <textarea name="review" id="review" rows="4" maxlength="300"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Submit</button>
            </form>
        </div>

        <div class="w-full md:w-1/2 p-6 border rounded-lg shadow-md bg-white">
            <!-- Heading at the top-left -->
            <h4 class="text-2xl font-bold mb-4 text-gray-600 text-left">Your Previous Review</h4>

            <!-- Scrollable reviews container -->
            <div class="h-full overflow-y-auto space-y-4">
                @if ($prev_reviews->isNotEmpty())
                    @foreach ($prev_reviews as $review)
                        <!-- Review Card -->
                        <div class="p-4 border rounded-lg shadow-md bg-gray-50">
                            <div class="text-sm text-gray-700 mb-2">
                                <strong>Affiliation:</strong> {{ $review->affiliation }}
                            </div>
                            <div class="text-sm text-gray-700 mb-2">
                                <strong>Position:</strong> {{ $review->position }}
                            </div>
                            <div class="text-sm text-gray-700">
                                <strong>Review:</strong> {{ $review->review }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-center">Nothing to show yet</p>
                @endif
            </div>
        </div>

    </div>

    </div>
@endsection
