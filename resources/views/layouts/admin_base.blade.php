<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-200">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <nav class="w-64 bg-white text-gray-700 shadow-md p-4 rounded-lg">
            <div>
                <div class="text-indigo-500 text-3xl font-bold mb-8">DataForesight</div>
                {{-- <img src="your-logo.png" alt="Logo" class="h-8 mr-2"> --}}
            </div>

            <ul>
                <li class="mb-2">
                    <a href="#" class="block py-2 px-3 rounded bg-indigo-700 text-white"
                        onclick="highlightMenu(event)">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="block py-2 px-3 rounded hover:bg-indigo-100 hover:text-gray-600"
                        onclick="highlightMenu(event)">
                        <i class="fas fa-users mr-2"></i> Users
                    </a>
                </li>
                <li>
                    <a href="#" class="block py-2 px-3 rounded hover:bg-indigo-100 hover:text-gray-600"
                        onclick="highlightMenu(event)">
                        <i class="fas fa-database mr-2"></i> Data
                    </a>
                </li>
            </ul>
        </nav>

        <div class="flex-grow p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Dashboard</h2>
                <div class="relative">
                    <button class="bg-gray-600 text-white rounded-full p-2 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-4.42 0-8 2.58-8 6v2h16v-2c0-3.42-3.58-6-8-6z" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Main Content -->
            <div class="bg-white shadow-md rounded-lg p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // JavaScript function to highlight the selected menu item
        function highlightMenu(event) {
            // Remove highlight from all menu items
            const menuItems = document.querySelectorAll('nav a');
            menuItems.forEach(item => {
                item.classList.remove('bg-indigo-700', 'text-white'); // Remove highlight classes
                item.classList.remove('bg-indigo-100', 'text-gray-600'); // Remove hover highlight classes
                item.classList.add('text-gray-700'); // Restore default text color
            });

            // Highlight the currently selected menu item
            const selectedItem = event.currentTarget;
            selectedItem.classList.add('bg-indigo-700', 'text-white'); // Add highlight classes
            selectedItem.classList.remove('text-gray-700'); // Remove default text color
        }

        // Automatically highlight the Dashboard on page load
        window.onload = function() {
            const dashboardLink = document.querySelector('nav a');
            dashboardLink.classList.add('bg-indigo-700', 'text-white');
        };
    </script>
</body>

</html>
