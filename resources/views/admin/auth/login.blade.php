<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'DataForesight') }}</title>
    <link rel="icon" href="assets/favicon.ico">

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-sm">
        <div class="bg-white shadow-lg rounded-lg px-8 py-10">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-blue-500 mb-2">ADMIN LOGIN</h2>
                <p class="text-gray-500 mb-6">Hello there, Sign in and start managing your website</p>

            </div>

            <!-- Display the error message here -->
            @if ($errors->has('credentials'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ $errors->first('credentials') }}</span>
                </div>
            @endif
            <form action="{{ route('admin.login_submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                    <div class="relative">
                        <input id="username" name ="username" type="text" placeholder="Username"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                            <!-- Username Icon (dummy icon for illustration) -->
                            <i class="fa-solid fa-user"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <div class="relative">
                        <input name ="password" id="password" type="password" placeholder="Password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                            <i class="fa-solid fa-key"></i>
                        </span>
                    </div>
                </div>
        </div>
        <div>
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                LOGIN
            </button>
        </div>
        </form>
    </div>
    </div>
</body>

</html>
