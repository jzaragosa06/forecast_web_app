<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('DataForesight')</title>
    <link rel="icon" href="assets/favicon.ico">

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
        <div class="w-50 bg-white border-r flex flex-col items-center py-6"> <!-- Increased width here -->
            <!-- Logo -->
            <div class="text-indigo-500 text-3xl font-bold mb-8">
                <!-- TS -->
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-12 w-auto">
            </div>

            <!-- Sidebar Icons -->
            <nav class="flex flex-col space-y-5">
                <div class="p-2">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'text-indigo-500 bg-indigo-100' : 'text-gray-600 hover:text-indigo-500' }} flex items-center p-2 rounded-lg">
                        <!-- Increased padding -->
                        <i class="fas fa-tachometer-alt text-2xl mr-3"></i> <!-- Increased icon size -->
                        <span class="text-sm">Dashboard</span> <!-- Increased text size -->
                    </a>
                </div>
                <div>
                    <a href="{{ route('crud.index') }}"
                        class="{{ request()->routeIs('crud.index') ? 'text-indigo-500 bg-indigo-100' : 'text-gray-600 hover:text-indigo-500' }} flex items-center p-4 rounded-lg">
                        <!-- Increased padding -->
                        <i class="fas fa-tasks text-2xl mr-3"></i> <!-- Increased icon size -->
                        <span class="text-sm">Manage Results</span> <!-- Increased text size -->
                    </a>
                </div>
                <div>
                    <a href="{{ route('share.index') }}"
                        class="{{ request()->routeIs('share.index') ? 'text-indigo-500 bg-indigo-100' : 'text-gray-600 hover:text-indigo-500' }} flex items-center p-4 rounded-lg">
                        <!-- Increased padding -->
                        <i class="fas fa-share-square text-2xl mr-3"></i> <!-- Increased icon size -->
                        <span class="text-sm">Shared Files</span> <!-- Increased text size -->
                    </a>
                </div>
                <div>
                    <a href="{{ route('posts.index') }}"
                        class="{{ request()->routeIs('posts.index') ? 'text-indigo-500 bg-indigo-100' : 'text-gray-600 hover:text-indigo-500' }} flex items-center p-4 rounded-lg">
                        <!-- Increased padding -->
                        <i class="fas fa-comments text-2xl mr-3"></i> <!-- Increased icon size -->
                        <span class="text-sm">Discussion</span> <!-- Increased text size -->
                    </a>
                </div>
            </nav>
        </div>



        <!-- Main Content -->
        <div class="flex-1 flex flex-col m-3">
            <!-- Navbar -->
            <div class="flex justify-between items-center bg-white shadow p-2 rounded-lg">
                <!-- Title -->
                <h1 class="text-lg font-semibold text-gray-700">@yield('page-title')</h1>
                <!-- Search Bar -->
                <div class="relative w-1/3 flex">
                    <!-- Search Input -->
                    <input id="search-input" type="text" placeholder="Search"
                        class="w-full bg-gray-100 border border-gray-300 rounded-l-lg py-2 px-4 focus:outline-none focus:ring focus:ring-indigo-200">

                    <!-- Search Icon -->
                    <button class="bg-blue-600 p-2 rounded-r-lg">
                        <i class="fas fa-search text-white"></i>
                    </button>

                    <!-- Search Results Container -->
                    <div id="search-results"
                        class="absolute left-0 top-full w-full bg-white border border-gray-300 rounded-lg p-4 hidden z-50 max-h-60 overflow-y-auto">
                        <h3 class="text-lg font-bold">Search Results</h3>
                        <div id="results-container"></div>
                    </div>
                </div>

                <script>
                    let searchData = {
                        users: @json($users),
                        posts: @json($posts),
                        files: @json($files),
                        results: @json($results)
                    };
                    document.addEventListener('DOMContentLoaded', function() {
                        const searchInput = document.getElementById('search-input');
                        const resultsContainer = document.getElementById('results-container');
                        const searchResults = document.getElementById('search-results');

                        // Function to handle search
                        searchInput.addEventListener('input', function() {
                            const query = searchInput.value.toLowerCase();
                            resultsContainer.innerHTML = ''; // Clear previous results

                            if (query === '') {
                                searchResults.classList.add('hidden'); // Hide results if input is empty
                                return;
                            }

                            let hasResults = false;

                            // Search Users
                            const filteredUsers = searchData.users.filter(user => user.name.toLowerCase().startsWith(
                                query));
                            if (filteredUsers.length > 0) {
                                hasResults = true;
                                resultsContainer.innerHTML +=
                                    `<div class="mb-4"><h4 class="font-semibold mt-2">Users</h4>`;
                                filteredUsers.forEach(user => {

                                    resultsContainer.innerHTML += `
                        <div class="flex items-center space-x-3 mb-2">
                            <img id="profileImage"
                                 src="${user.profile_photo ? '/storage/' + user.profile_photo : 'https://cdn-icons-png.flaticon.com/512/3003/3003035.png'}"
                                 class="w-8 h-8 object-cover rounded-full" alt="Profile Photo">
                            <div>
                                 <a href="{{ url('profile/public/view') }}/${user.id}"><p class="text-gray-700 font-medium hover:text-blue-600">${user.name}</p></a>
                                <p class="text-gray-600 text-sm">${user.email}</p>
                            </div>
                        </div>`;
                                });
                                resultsContainer.innerHTML += `</div>`; // Close user results container
                            }

                            // Search Posts
                            const filteredPosts = searchData.posts.filter(post => post.title.toLowerCase().includes(
                                query) || post.body.toLowerCase().includes(query));
                            if (filteredPosts.length > 0) {
                                hasResults = true;
                                resultsContainer.innerHTML +=
                                    `<div class="mb-4"><h4 class="font-semibold mt-2">Posts</h4>`;
                                filteredPosts.forEach(post => {
                                    const topicsArray = post.topics.split(','); // Split the topics by commas
                                    let topicsHtml = '<div class="flex flex-wrap mt-2">';
                                    topicsArray.forEach(topic => {
                                        topicsHtml += `
                            <span class="bg-gray-200 text-gray-800 text-xs font-medium mr-2 mb-2 px-2 py-1 rounded">${topic.trim()}</span>
                        `;
                                    });
                                    topicsHtml += '</div>';
                                    resultsContainer.innerHTML += `
                        <div class="post mb-2">
                             <a href="{{ url('/posts/show') }}/${post.id}"><h4 class="mt-2 text-gray-800 font-medium hover:text-blue-600">${post.title}</h4></a>
                            <p class="text-gray-700 text-sm">Posted by: ${post.user.name}</p>
                            ${topicsHtml}
                        </div>
                    `;
                                });
                                resultsContainer.innerHTML += `</div>`; // Close post results container
                            }

                            // Search Files
                            const filteredFiles = searchData.files.filter(file => file.filename.toLowerCase().includes(
                                query));
                            if (filteredFiles.length > 0) {
                                hasResults = true;
                                resultsContainer.innerHTML +=
                                    `<div class="mb-4"><h4 class="font-semibold mt-2">Files</h4>`;
                                filteredFiles.forEach(file => {
                                    resultsContainer.innerHTML += `
                        <div class="mb-2">
                             <a href="{{ url('/files/input/view') }}/${file.file_id}"><p class="text-gray-700 font-medium hover:text-blue-600">${file.filename}</p></a>
                            <p class="text-gray-600 text-sm">${file.description.length > 20 ? file.description.substring(0, 20) + '...' : file.description}</p>
                        </div>
                    `;
                                });
                                resultsContainer.innerHTML += `</div>`; // Close files results container
                            }

                            // Search File Associations (Results)
                            const filteredResults = searchData.results.filter(result => result.assoc_filename
                                .toLowerCase().includes(query));
                            if (filteredResults.length > 0) {
                                hasResults = true;
                                resultsContainer.innerHTML +=
                                    `<div class="mb-4"><h4 class="font-semibold mt-2">Results</h4>`;
                                filteredResults.forEach(result => {
                                    resultsContainer.innerHTML += `
                        <div class="mb-2">
                            <a href="{{ url('/results/view/results') }}/${result.file_assoc_id}"><p class="text-gray-700 font-medium hover:text-blue-600">${result.assoc_filename}</p></a>
                            <p class="text-gray-600 text-sm">Operation: ${result.operation}</p>
                        </div>
                    `;
                                });
                                resultsContainer.innerHTML += `</div>`; // Close results container
                            }

                            if (hasResults) {
                                searchResults.classList.remove('hidden'); // Show the results container
                            } else {
                                resultsContainer.innerHTML = `<p class="text-gray-500">No results found.</p>`;
                                searchResults.classList.remove('hidden'); // Show 'no results' message
                            }
                        });
                    });
                </script>

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

                    <div class="relative">
                        <!-- Profile button -->
                        <button id="profileDropdownButton"
                            class="flex items-center text-gray-600 hover:text-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 rounded-md">
                            <i class="fas fa-user-circle text-xl mr-2"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <!-- Minimalistic Dropdown Styling -->
                            <div class="flex flex-col">
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
            </div>

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
