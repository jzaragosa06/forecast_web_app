@extends('layouts.auth')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-blue-100">
        <div
            class="flex flex-col md:flex-row bg-white rounded-lg shadow-lg max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl w-full overflow-hidden">
            <!-- Login Form Section -->
            <div class="w-full md:w-1/2 p-6 md:p-8 lg:p-10">
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-4">{{ __('Login') }}</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="relative z-0 w-full mb-5">
                        <input type="email" name="email" id="email" autocomplete="email"
                            class="block py-2.5 px-0 w-full text-sm lg:text-base text-gray-900 bg-transparent border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
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
                        <input type="password" name="password" id="password"
                            class="block py-2.5 px-0 w-full text-sm lg:text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-600 peer"
                            placeholder=" " required />
                        <label for="password"
                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 left-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            {{ __('Password') }}
                        </label>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center mb-4">
                        <input id="remember" type="checkbox"
                            class="w-4 h-4 text-sky-600 bg-gray-100 border-gray-300 rounded focus:ring-sky-500 focus:ring-2"
                            name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-medium text-gray-900">{{ __('Remember Me') }}</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-indigo-500 text-white font-semibold py-2 px-4 rounded-md shadow-lg hover:bg-indigo-600">
                        {{ __('Login') }}
                    </button>


                    <div class="text-center mt-4">

                        <!-- Forgot Password Link -->
                        @if (Route::has('password.request'))
                            <div class="text-center mt-4">
                                <a class="text-sm text-sky-500 hover:underline" href="{{ route('register') }}">
                                    {{ __('Sign-up') }}
                                </a>
                                <a class="text-sm text-sky-500 hover:underline" href="{{ route('password.request') }}">
                                    {{ __('/ Forgot Your Password?') }}
                                </a>

                            </div>
                        @endif


                    </div>


                </form>
            </div>

            <!-- Welcome Section -->
            <div
                class="hidden md:block w-full md:w-1/2 bg-gradient-to-r from-cyan-500 to-blue-500 p-6 lg:p-8 xl:p-10 flex flex-col items-center justify-center text-white">
                <h2 class="text-2xl lg:text-3xl font-bold mb-4">Hey, Welcome Back!</h2>
                <p class="text-base lg:text-lg">We're glad to see you again. Let's log in and continue!</p>
                <div class="mt-4 lg:mt-6 xl:mt-8 flex flex-col items-center">
                    <img src="assets/img/login.png" alt="Illustration" class="w-48 lg:w-60 xl:w-72 h-auto">
                </div>
            </div>
        </div>
    </div>
@endsection
