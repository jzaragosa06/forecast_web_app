<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('DataForesight')</title>

    <!-- Include Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

    <!-- Include Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>


    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({
            startOnLoad: true,
            theme: "default", // You can change the theme
            themeVariables: {
                primaryColor: '#ffcc00',
                edgeLabelBackground: '#ffffff'
            },
            flowchart: {
                useMaxWidth: false, // Allow scaling
            },
        });
    </script>

    <style>
        .mermaid {
            transform: scale(0.8);
            /* Adjust scale here */
            transform-origin: top left;
            /* Make scaling behave properly */
            max-width: 100%;
            max-height: 100%;
        }

        .carousel {
            transition: transform 0.5s ease;
        }

        /* Add this to your CSS */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
    <!-- Quill CSS and JS CDN -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tailwind Icons (Heroicons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Date-FNS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/date-fns@latest"></script>

    <!-- CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHELiMiSckEBBGpn5KaM9TZVlYGevcKTg&libraries=places">
    </script>
    <!-- Apexchart CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Include Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">


    <!-- JQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Include Flatpickr CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-20 bg-white border-r flex flex-col items-center py-6">
            <!-- Logo -->
            <div class="text-indigo-500 text-3xl font-bold mb-8">TS</div>

            <!-- Sidebar Icons -->
            <nav class="flex flex-col space-y-8">
                <div class="relative group">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'text-indigo-500 bg-indigo-100' : 'text-gray-600 hover:text-indigo-500' }} p-2 rounded-lg">
                        <i class="fas fa-tachometer-alt text-xl"></i>
                    </a>
                    <span
                        class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full bg-gray-700 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        Dashboard
                    </span>
                </div>
                <div class="relative group">
                    <a href="{{ route('crud.index') }}"
                        class="{{ request()->routeIs('crud.index') ? 'text-indigo-500 bg-indigo-100' : 'text-gray-600 hover:text-indigo-500' }} p-2 rounded-lg">
                        <i class="fas fa-tasks text-xl"></i>
                    </a>
                    <span
                        class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full bg-gray-700 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        Manage Results
                    </span>
                </div>

                <div class="relative group">
                    <a href="{{ route('share.index') }}"
                        class="{{ request()->routeIs('share.index') ? 'text-indigo-500 bg-indigo-100' : 'text-gray-600 hover:text-indigo-500' }} p-2 rounded-lg">
                        <i class="fas fa-share-square text-xl"></i>
                    </a>
                    <span
                        class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full bg-gray-700 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        Shared Files
                    </span>
                </div>

                <div class="relative group">
                    <a href="{{ route('posts.index') }}"
                        class="{{ request()->routeIs('posts.index') ? 'text-indigo-500 bg-indigo-100' : 'text-gray-600 hover:text-indigo-500' }} p-2 rounded-lg">
                        <i class="fas fa-comments text-xl"></i>
                    </a>
                    <span
                        class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full bg-gray-700 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        Discussion
                    </span>
                </div>

            </nav>

            <!-- Settings Icon (at bottom) -->
            {{-- <div class="mt-auto">
                <a href="#" class="text-gray-600 hover:text-indigo-500">
                    <i class="fas fa-cog text-xl"></i>
                </a>
            </div> --}}
        </div>

        <!-- Main Content -->

        <div class="flex-1 flex flex-col">

            <!-- Navbar -->
            <div class="flex justify-between items-center bg-white shadow p-4 rounded-lg">
                <!-- Title -->
                <h1 class="text-lg font-semibold text-gray-700">@yield('page-title')</h1>

                <!-- Search Bar -->
                <div class="relative w-1/3">
                    <input type="text" placeholder="Search"
                        class="w-full bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring focus:ring-indigo-200">
                </div>

                <!-- Notification and Profile -->
                <div class="flex items-center space-x-4">

                    <div class="flex items-center space-x-4">
                        <!-- Notification Bell -->
                        <div class="relative">
                            <button id="notificationBell"
                                class="text-gray-600 hover:text-indigo-500 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                            </button>

                            <!-- Notification Count (if any) -->
                            @if ($notifications->count() > 0)
                                <span class="absolute top-0 right-0 block h-2 w-2 bg-red-500 rounded-full"></span>
                            @endif

                            <!-- Notification Dropdown (Initially Hidden) -->
                            <div id="notificationDropdown"
                                class="hidden absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <ul class="py-1">
                                    @if ($notifications->isEmpty())
                                        <li class="px-4 py-3 text-sm text-gray-500">No new notifications</li>
                                    @else
                                        @foreach ($notifications as $notification)
                                            <li
                                                class="px-4 py-3 flex items-center justify-between text-sm text-gray-700 hover:bg-gray-100">
                                                <div class="flex-1">
                                                    <strong
                                                        class="text-gray-900">{{ $notification->shared_by }}</strong>
                                                    shared a file
                                                    <div class="text-xs text-gray-500">
                                                        {{ $notification->notification_time }}</div>
                                                </div>
                                                {{-- <form
                                                    action="{{ route('share.view_file', ['file_assoc_id' => $notification->file_assoc_id, 'user_id' => $notification->user_id]) }}"
                                                    method="post">
                                                    <button type="submit"
                                                        class="ml-2 bg-indigo-500 text-white text-xs px-3 py-1 rounded-full hover:bg-indigo-600 focus:outline-none">
                                                        View
                                                    </button>
                                                </form> --}}
                                                <a
                                                    href="{{ route('share.view_file', ['file_assoc_id' => $notification->file_assoc_id, 'user_id' => $notification->user_id]) }}">
                                                    <button
                                                        class="ml-2 bg-indigo-500 text-white text-xs px-3 py-1 rounded-full hover:bg-indigo-600 focus:outline-none">
                                                        View
                                                    </button>
                                                </a>

                                            </li>
                                        @endforeach

                                        <li
                                            class="px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 flex justify-center items-center">
                                            <a href="{{ route('share.index') }}">View All</a>
                                        </li>

                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Icon with Dropdown -->
                    {{-- <div class="relative">
                        <button id="profileDropdownButton"
                            class="flex items-center text-gray-600 hover:text-indigo-500 focus:outline-none">
                            <i class="fas fa-user-circle text-xl"></i>
                        </button>
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                            <a class="block px-4 py-2 text-gray-800 hover:bg-gray-100" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <div>
                                <a href="{{ route('logs.index') }}">Logs</a>
                            </div>
                        </div>
                    </div> --}}

                    <div class="relative">
                        <!-- Profile button -->
                        <button id="profileDropdownButton"
                            class="flex items-center text-gray-600 hover:text-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 rounded-md">
                            <i class="fas fa-user-circle text-xl mr-2"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <!-- Profile Link -->
                            <a href="{{ route('profile.index') }}"
                                class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors duration-200">
                                <i class="fas fa-user mr-2"></i>
                                <span>Profile</span>
                            </a>

                            <!-- Logs Link -->
                            <a href="{{ route('logs.index') }}"
                                class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors duration-200">
                                <i class="fas fa-list mr-2"></i>
                                <span>Logs</span>
                            </a>

                            <!-- Logout Link -->
                            <a href="{{ route('logout') }}"
                                class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors duration-200"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>Logout</span>
                            </a>

                            <!-- Hidden Logout Form -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            {{-- <div class="mt-6 bg-white border border-gray-200 rounded-lg flex items-center justify-center p-6">
                @yield('content')
            </div> --}}

            <div class="mt-6 bg-white border border-gray-200 rounded-lg flex-1 overflow-y-auto p-6">
                @yield('content')
            </div>


        </div>
    </div>



    <!-- FontAwesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bellIcon = document.getElementById('notificationBell');
            const dropdown = document.getElementById('notificationDropdown');
            let isDropdownOpen = false;

            // Toggle dropdown visibility on click
            bellIcon.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent click from propagating to document
                isDropdownOpen = !isDropdownOpen;
                dropdown.classList.toggle('hidden', !isDropdownOpen);
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function() {
                if (isDropdownOpen) {
                    dropdown.classList.add('hidden');
                    isDropdownOpen = false;
                }
            });

            // Prevent closing when clicking inside the dropdown
            dropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });

        // JavaScript to toggle the dropdown
        document.getElementById('profileDropdownButton').addEventListener('click', function() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profileDropdown');
            if (!document.getElementById('profileDropdownButton').contains(e.target) && !dropdown.contains(e
                    .target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
