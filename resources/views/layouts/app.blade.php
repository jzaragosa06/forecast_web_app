<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DataForesight') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        .content-section {
            padding-top: 72px;
            /* Adjust as needed based on your header height */
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
                            <a href="#home"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 bg-blue-500 text-white">Home</a>
                        </li>
                        <li>
                            <a href="#about"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700">About</a>
                        </li>
                        <li>
                            <a href="#services"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700">Services</a>
                        </li>
                        <li>
                            <a href="#contact"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <!-- Main Content -->
    <main class="">
        @yield('content')
    </main>

    <!-- Partner logos -->
    <footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Company Info -->
            <div>
                <h3 class="text-xl font-semibold">DataForesight</h3>
                <p class="mt-4 text-gray-400">
                    DataForesight is a leading time series forecasting platform that helps businesses gain insights and make data-driven decisions with confidence.
                </p>
                <p class="mt-4 text-gray-400">
                    &copy; 2024 DataForesight. All Rights Reserved.
                </p>
            </div>

            <!-- Partnerships -->
            <div>
                <h3 class="text-xl font-semibold">Partnerships</h3>
                <ul class="mt-4 space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-blue-400">Tech Innovators</a></li>
                    <li><a href="#" class="hover:text-blue-400">Market Masters</a></li>
                    <li><a href="#" class="hover:text-blue-400">FinCorp</a></li>
                    <li><a href="#" class="hover:text-blue-400">Data Solutions Inc.</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-xl font-semibold">Contact Us</h3>
                <ul class="mt-4 space-y-2 text-gray-400">
                    <li>Email: <a href="mailto:info@dataforesight.com" class="hover:text-blue-400">info@dataforesight.com</a></li>
                    <li>Phone: <a href="tel:+1234567890" class="hover:text-blue-400">+1 (234) 567-890</a></li>
                    <li>Address: P.S.U Village, San Vicente East, Urdaneta, Pangasinan</li>
                </ul>
                <div class="mt-6">
                    <a href="#" class="text-blue-400 hover:text-white mr-4">
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>
                    <a href="#" class="text-blue-400 hover:text-white mr-4">
                        <i class="fab fa-twitter fa-2x"></i>
                    </a>
                    <a href="#" class="text-blue-400 hover:text-white">
                        <i class="fab fa-linkedin fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>


    <script>
        window.addEventListener('load', function () {
            window.history.scrollRestoration = 'manual';
            window.scrollTo(0, 0);
        });
        
       document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('nav a[href^="#"]');
            const sections = document.querySelectorAll('section');

            navLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevent default jump

                    const targetId = this.getAttribute('href'); // Get the #id
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) { // Check if the target element exists
                        targetElement.scrollIntoView({ behavior: 'smooth' });

                        // Remove active class from all links
                        navLinks.forEach(link => link.classList.remove('bg-blue-500', 'text-white'));

                        // Add active class to the clicked link
                        this.classList.add('bg-blue-500', 'text-white');
                    }

                });
            });

            window.addEventListener('scroll', () => {
                let current = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;

                    if (pageYOffset >= (sectionTop - sectionHeight / 3)) {
                        current = section.getAttribute('id'); 
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('bg-blue-500', 'text-white');
                    if (link.href.includes(`#${current}`)) {
                        link.classList.add('bg-blue-500', 'text-white');
                    }
                });
            }); 
        });
    </script>

</body>

</html>