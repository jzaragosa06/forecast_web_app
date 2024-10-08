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
                    <div class="relative z-0 w-full mb-5">
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

                    <!-- Contact Number Field -->
                    <div class="relative z-0 w-full mb-5">
                        <input type="number" name="contact_num" id="contact_num" autocomplete="off"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
                            placeholder=" " required />
                        <label for="contact_num"
                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 left-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            {{ __('Contact Number') }}
                        </label>
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
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="off"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
                            placeholder=" " required />
                        <label for="password_confirmation"
                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 left-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            {{ __('Confirm Password') }}
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
            <div class="w-1/2 bg-gradient-to-r from-indigo-400 to-cyan-400 p-8 flex flex-col items-center justify-center text-white">
                <h2 class="text-3xl font-bold mb-4">Join Us!</h2>
                <p class="text-lg">Create an account and enjoy exclusive features!</p>
                <div class="mt-6">
                    <img src="assets/img/register.png" alt="Illustration" class="w-96 h-auto">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
