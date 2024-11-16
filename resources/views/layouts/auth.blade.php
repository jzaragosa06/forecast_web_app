<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DataForesight') }}</title>
    <link rel="icon" href="assets/favicon.ico">
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
                <a class="flex items-center space-x-3 self-center text-lg sm:text-xl md:text-2xl font-semibold whitespace-nowrap text-sky-600"
                    href="{{ url('/') }}">
                    <!-- <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-10 w-10"> -->
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-12 w-auto">
                    <span>{{ config('app.name', 'DataForesight') }}</span>
                </a>
                <div class="flex md:order-2 space-x-3">
                    @if (Route::is('login'))
                        <a href="{{ route('register') }}">
                            <button type="button"
                                class="text-white bg-cyan-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs sm:text-sm px-4 py-2">
                                Sign Up
                            </button>
                        </a>
                    @elseif (!auth()->check())
                        <a href="{{ route('login') }}">
                            <button type="button"
                                class="text-white bg-cyan-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs sm:text-sm px-4 py-2">
                                Login
                            </button>
                        </a>
                    @endif
                </div>
            </div>
        </nav>
    </header>


    <!-- Main Content -->
    <main class="">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3">
                <!-- Company Info -->
                <div>
                    <h3 class="text-lg sm:text-xl font-semibold">DataForesight</h3>
                    <p class="mt-4 text-gray-400 text-sm sm:text-base">
                        DataForesight is a leading time series forecasting platform that helps businesses gain insights
                        and make data-driven decisions with confidence.
                    </p>
                    <p class="mt-4 text-gray-400 text-sm sm:text-base">
                        &copy; 2024 DataForesight. All Rights Reserved.
                    </p>
                </div>

                <!-- Partnerships -->
                <div>
                    <h3 class="text-lg sm:text-xl font-semibold">Partnerships</h3>
                    <ul class="mt-4 space-y-2 text-gray-400 text-sm sm:text-base">
                        <li><a href="#" class="hover:text-blue-400">Tech Innovators</a></li>
                        <li><a href="#" class="hover:text-blue-400">Market Masters</a></li>
                        <li><a href="#" class="hover:text-blue-400">FinCorp</a></li>
                        <li><a href="#" class="hover:text-blue-400">Data Solutions Inc.</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg sm:text-xl font-semibold">Contact Us</h3>
                    <ul class="mt-4 space-y-2 text-gray-400 text-sm sm:text-base">
                        <li>Email: <a href="mailto:info@dataforesight.com"
                                class="hover:text-blue-400">info@dataforesight.com</a></li>
                        <li>Phone: <a href="tel:+1234567890" class="hover:text-blue-400">+1 (234) 567-890</a></li>
                        <li>Address: P.S.U Village, San Vicente East, Urdaneta, Pangasinan</li>
                    </ul>
                    <div class="mt-6 flex space-x-4">
                        <a href="#" class="text-blue-400 hover:text-white">
                            <i class="fab fa-facebook fa-lg"></i>
                        </a>
                        <a href="#" class="text-blue-400 hover:text-white">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-blue-400 hover:text-white">
                            <i class="fab fa-linkedin fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
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