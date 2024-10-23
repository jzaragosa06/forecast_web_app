@extends('layouts.auth')


@section('content')
    <div class="flex items-center justify-center h-screen bg-blue-50">
        <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="flex">
                <!-- Register Form -->
                <div class="w-1/2 p-8">
                    <h2 class="text-3xl font-semibold text-gray-700 mb-6">{{ __('Register') }}</h2>

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Name Field -->
                        {{-- <div class="relative z-0 w-full mb-5">
                            <input type="text" name="name" id="name" autocomplete="name"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
                                placeholder=" " value="{{ old('name') }}" required />
                            <label for="name"
                                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 left-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{ __('Name') }}
                            </label>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        <!-- First Name and Last Name Fields in the Same Row -->
                        <div class="flex space-x-4">
                            <!-- First Name Field -->
                            <div class="relative z-0 w-1/2 mb-5">
                                <input type="text" name="first_name" id="first_name" autocomplete="given-name"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
                                    placeholder=" " value="{{ old('first_name') }}" required />
                                <label for="first_name"
                                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 left-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    {{ __('First Name') }}
                                </label>
                                @error('first_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Last Name Field -->
                            <div class="relative z-0 w-1/2 mb-5">
                                <input type="text" name="last_name" id="last_name" autocomplete="family-name"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
                                    placeholder=" " value="{{ old('last_name') }}" required />
                                <label for="last_name"
                                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 left-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    {{ __('Last Name') }}
                                </label>
                                @error('last_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <!-- Email Field -->
                        <div class="relative z-0 w-full mb-5">
                            <input type="email" name="email" id="email" autocomplete="email"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
                                placeholder=" " value="{{ old('email') }}" required />
                            <label for="email"
                                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 left-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{ __('Email Address') }}
                            </label>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="relative z-0 w-full mb-5">
                            <input type="password" name="password" id="password" autocomplete="password"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
                                placeholder=" " required />
                            <label for="password"
                                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 left-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{ __('Password') }}
                            </label>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="relative z-0 w-full mb-5">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                autocomplete="off"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
                                placeholder=" " required />
                            <label for="password_confirmation"
                                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 left-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{ __('Confirm Password') }}
                            </label>
                        </div>

                        <!-- Terms and Condition Field -->
                        <!-- <div class="flex items-center mb-4">
                                    <input id="terms" type="checkbox"
                                        class="w-4 h-4 text-sky-600 bg-gray-100 border-gray-300 rounded focus:ring-sky-500 focus:ring-2"
                                        name="terms" required>
                                    <span for="terms" class="ml-2 text-sm font-medium text-gray-900">
                                        I agree to the
                                        <a href="{{ route('terms') }}" class="text-sky-500 hover:underline" target="_blank">Terms
                                            and Conditions</a>
                                    </span>
                                </div> -->
                        <div class="flex items-center mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="terms" id="terms" required
                                    class="w-4 h-4 text-sky-600 bg-gray-100 border-gray-300 rounded focus:ring-sky-500 focus:ring-2">
                                <span for="terms" class="ml-2 text-sm font-medium text-gray-900">I agree to the <a
                                        href="#" class="text-blue-500 underline" id="openModal">Terms and
                                        Conditions</a></span>
                            </label>
                        </div>


                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-indigo-500 text-white font-semibold py-2 px-4 rounded-md shadow hover:bg-indigo-600">
                            {{ __('Register') }}
                        </button>
                    </form>

                </div>

                <!-- Welcome Section -->
                <div
                    class="w-1/2 bg-gradient-to-r from-indigo-400 to-cyan-400 p-8 flex flex-col items-center justify-center text-white">
                    <h2 class="text-3xl font-bold mb-4">Join Us!</h2>
                    <p class="text-lg">Create an account and enjoy exclusive features!</p>
                    <div class="mt-6">
                        <img src="assets/img/register.png" alt="Illustration" class="w-96 h-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms and Conditions Modal -->
    <div id="termsModal" class="fixed inset-0 hidden items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold">Terms and Conditions</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-800">
                    &times;
                </button>
            </div>
            <div class="mt-4 h-96 overflow-y-auto">
                {!! $termsHtml !!}
            </div>
            <div class="mt-4 flex justify-end">
                <button id="closeModalBottom" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');
        const closeModalButtonBottom = document.getElementById('closeModalBottom');
        const modal = document.getElementById('termsModal');

        // Open the modal
        openModalButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        // Close the modal
        closeModalButton.addEventListener('click', function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        closeModalButtonBottom.addEventListener('click', function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    </script>
@endsection
