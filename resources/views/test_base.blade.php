{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
</head>

<body>

    <!-- Sidebar -->
    <div class="d-flex">
        <div class="bg-light border-end vh-100" style="width: 80px;">
            <div class="d-flex flex-column align-items-center py-4">
                <!-- Logo -->
                <div class="text-primary fs-1 mb-4">O</div>

                <!-- Nav Icons -->
                <div class="nav flex-column nav-pills">
                    <a href="#" class="nav-link mb-3"><i class="bi bi-house-door-fill"></i></a>
                    <a href="#" class="nav-link mb-3"><i class="bi bi-person-circle"></i></a>
                    <a href="#" class="nav-link mb-3"><i class="bi bi-bar-chart-line-fill"></i></a>
                    <a href="#" class="nav-link mb-3"><i class="bi bi-wallet-fill"></i></a>
                    <a href="#" class="nav-link mb-3"><i class="bi bi-calendar3"></i></a>
                </div>

                <!-- Settings Icon -->
                <div class="mt-auto pb-4">
                    <a href="#" class="nav-link"><i class="bi bi-gear-fill"></i></a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            <nav class="navbar navbar-light bg-white">
                <div class="container-fluid">
                    <!-- Page Title -->
                    <span class="navbar-brand mb-0 h1">Payments</span>

                    <!-- Search Bar -->
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    </form>

                    <!-- Notification and Profile -->
                    <div class="d-flex align-items-center">
                        <a href="#" class="nav-link me-3 position-relative">
                            <i class="bi bi-bell-fill"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </a>
                        <a href="#" class="nav-link">
                            <i class="bi bi-person-circle"></i>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Placeholder for main content -->
            <div class="bg-light border rounded p-5 mt-3" style="height: 500px;">
                <!-- Placeholder for middle box content -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> --}}




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Dashboard - Tailwind</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Icons (Heroicons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-20 bg-white border-r flex flex-col items-center py-6">
            <!-- Logo -->
            <div class="text-indigo-500 text-3xl font-bold mb-8">O</div>

            <!-- Sidebar Icons -->
            <nav class="flex flex-col space-y-8">
                <a href="#" class="text-gray-600 hover:text-indigo-500">
                    <i class="fas fa-house-user text-xl"></i>
                </a>
                <a href="#" class="text-gray-600 hover:text-indigo-500">
                    <i class="fas fa-user-circle text-xl"></i>
                </a>
                <a href="#" class="text-gray-600 hover:text-indigo-500">
                    <i class="fas fa-chart-line text-xl"></i>
                </a>
                <a href="#" class="text-gray-600 hover:text-indigo-500">
                    <i class="fas fa-wallet text-xl"></i>
                </a>
                <a href="#" class="text-gray-600 hover:text-indigo-500">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </a>
            </nav>

            <!-- Settings Icon (at bottom) -->
            <div class="mt-auto">
                <a href="#" class="text-gray-600 hover:text-indigo-500">
                    <i class="fas fa-cog text-xl"></i>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Navbar -->
            <div class="flex justify-between items-center bg-white shadow p-4 rounded-lg">
                <!-- Title -->
                <h1 class="text-lg font-semibold text-gray-700">Payments</h1>

                <!-- Search Bar -->
                <div class="relative w-1/3">
                    <input type="text" placeholder="Search"
                        class="w-full bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring focus:ring-indigo-200">
                </div>

                <!-- Notification and Profile -->
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <a href="#" class="text-gray-600 hover:text-indigo-500">
                            <i class="fas fa-bell"></i>
                        </a>
                        <span class="absolute top-0 right-0 block h-2 w-2 bg-red-500 rounded-full"></span>
                    </div>

                    <!-- Profile Icon -->
                    <a href="#" class="text-gray-600 hover:text-indigo-500">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Placeholder for Content Box -->
            <div class="mt-6 bg-white border border-gray-200 rounded-lg h-96 flex items-center justify-center">
                <!-- Placeholder for future content -->
                <span class="text-gray-400 text-xl">Main Content Area</span>
            </div>
        </div>
    </div>

    <!-- FontAwesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

</body>

</html>
