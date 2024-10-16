<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DataForesight') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .content-section {
            padding-top: 72px;
        }

        /* Remove autofill background and fix styling */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px white inset !important;
            box-shadow: 0 0 0px 1000px white inset !important;
            -webkit-text-fill-color: #000 !important;
            caret-color: #000 !important;
        }

        /* Floating label for focused, filled, or autofilled inputs */
        input:focus~label,
        input:not(:placeholder-shown)~label {
            transform: translateY(-1.5rem) scale(0.75);
            color: #0ea5e9;
        }

        /* General label transition */
        label {
            transition: all 0.2s ease-in-out;
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
                    <!-- <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-10 w-10"> -->
                    <!-- Adjust the size as needed -->
                    <span>{{ config('app.name', 'DataForesight') }}</span>
                </a>
                <div class="flex md:order-2 space-x-3">
                    {{-- Show "Register" button if the user is on the login page --}}
                    @if (Route::is('login'))
                        <a href="{{ route('register') }}">
                            <button type="button"
                                class="text-white bg-cyan-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                Sign Up
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
            </div>
        </nav>
    </header>


    <!-- Main Content -->
    <main class="">
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputs = document.querySelectorAll("input");

            inputs.forEach(input => {
                // Check if field is already filled (e.g., by autofill)
                if (input.value) {
                    input.classList.add('input-filled');
                }

                // Event listener for input and blur events to manage label position
                input.addEventListener('input', function () {
                    if (this.value) {
                        this.classList.add('input-filled');
                    } else {
                        this.classList.remove('input-filled');
                    }
                });

                input.addEventListener('focus', function () {
                    if (this.value) {
                        this.classList.add('input-filled');
                    }
                });

                input.addEventListener('blur', function () {
                    if (!this.value) {
                        this.classList.remove('input-filled');
                    }
                });
            });
        });

    </script>
</body>

</html>