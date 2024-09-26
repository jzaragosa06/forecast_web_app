<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TagSalamisim') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fade-in {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-blue-50 to-blue-300 min-h-screen">

    <!-- Navbar -->
    <header class="flex justify-between items-center p-6">
        <nav class="bg-white fixed w-full z-20 top-0 start-0 border-gray-200 drop-shadow-md">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a class="flex items-center space-x-3 self-center text-2xl font-semibold whitespace-nowrap text-sky-600"
                    href="{{ url('/') }}">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-10 w-10">
                    <!-- Adjust the size as needed -->
                    <span>{{ config('app.name', 'TagSalamisim') }}</span>
                </a>
                <div class="flex md:order-2 space-x-3">
                    {{-- Show "Get Started" only on the landing page --}}
                    @if (Route::is('welcome') || Route::is('/'))
                        <a href="{{ route('register') }}">
                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                Get Started
                            </button>
                        </a>
                    @endif

                    {{-- Show "Register" button if the user is on the login page --}}
                    @if (Route::is('login'))
                        <a href="{{ route('register') }}">
                            <button type="button"
                                class="text-white bg-cyan-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                Register
                            </button>
                        </a>
                    @elseif (!auth()->check())
                        {{-- Show login button only if the user is not authenticated and not on the login page --}}
                        <a href="{{ route('login') }}">
                            <button type="button"
                                class="text-white bg-cyan-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                Login
                            </button>
                        </a>
                    @endif

                    <button data-collapse-toggle="navbar-sticky" type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        aria-controls="navbar-sticky" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>

                {{-- Menu Items (Home, About, Services, Contact) --}}
                <div class="items-center justify-between hidden w-full md:flex md:w-auto" id="navbar-sticky">
                    <ul
                        class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-white">

                        <li>
                            <a href="{{ url('/') }}"
                                class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700"
                                aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700">About</a>
                        </li>
                        <li>
                            <a href="{{ url('/services') }}"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700">Services</a>
                        </li>
                        <li>
                            <a href="{{ url('/contact') }}"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <!-- Main Content -->
    <main class="mt-5">
        @yield('content')
    </main>

    <!-- Partner logos -->
    <footer class="flex justify-center items-center py-6 space-x-6">
        <img src="https://via.placeholder.com/80x40" alt="Logo" class="h-10">
        <img src="https://via.placeholder.com/80x40" alt="Logo" class="h-10">
        <img src="https://via.placeholder.com/80x40" alt="Logo" class="h-10">
        <img src="https://via.placeholder.com/80x40" alt="Logo" class="h-10">
        <img src="https://via.placeholder.com/80x40" alt="Logo" class="h-10">
    </footer>

</body>

</html>
