<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/favicon.ico">
    <title>@yield('title')</title>
    <!-- Jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

</head>

<body class="bg-gray-200">

    <div class="flex">
        <!-- Sidebar -->
        <nav class="w-64 bg-white text-gray-700 shadow-md p-4 fixed h-full">
            <div class="mb-3 relative group flex flex-col items-center">
                <!-- Logo -->
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-12 w-auto mb-2">
                <div class="text-blue-500 text-2xl font-bold">DataForesight</div>
            </div>


            <ul>
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'text-white bg-blue-700' : 'text-gray-600 hover:text-blue-500' }} flex items-center p-3 rounded-lg transition duration-200">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.users') }}"
                        class="{{ request()->routeIs('admin.users') ? 'text-white bg-blue-700' : 'text-gray-600 hover:text-blue-500' }} flex items-center p-3 rounded-lg transition duration-200">
                        <i class="fas fa-users mr-3"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.data-source') }}"
                        class="{{ request()->routeIs('admin.data-source') ? 'text-white bg-blue-700' : 'text-gray-600 hover:text-blue-500' }} flex items-center p-3 rounded-lg transition duration-200">
                        <i class="fas fa-database mr-3"></i>
                        <span>Data Source</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.queries') }}"
                        class="{{ request()->routeIs('admin.queries') ? 'text-white bg-indigo-700' : 'text-gray-600 hover:text-indigo-500' }} flex items-center p-3 rounded-lg transition duration-200">
                        <i class="fas fa-question-circle mr-3"></i> <!-- Changed icon here -->
                        <span>Queries</span>
                    </a>
                </li>

            </ul>
        </nav>


        <div class="flex-grow p-6 ml-64">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">@yield('page-title')</h2>

                <!-- Profile Button and Logout Dropdown -->
                <div class="relative">
                    <button id="profileButton"
                        class="bg-gray-600 text-white rounded-full p-3 focus:outline-none hover:bg-gray-700 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-4.42 0-8 2.58-8 6v2h16v-2c0-3.42-3.58-6-8-6z" />
                        </svg>
                    </button>

                    <!-- Dropdown Panel -->
                    <div id="logoutDropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                        <a href="{{ route('admin.logout') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600">
                            Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white shadow-md rounded-lg p-6 flex-grow mb-6">
                @yield('content')
            </div>
        </div>

        <!-- JavaScript for toggling the dropdown -->
        <script>
            document.getElementById('profileButton').addEventListener('click', function() {
                var dropdown = document.getElementById('logoutDropdown');
                dropdown.classList.toggle('hidden');
            });
        </script>

    </div>

    <script></script>
    @yield('scripts')
</body>

</html>
