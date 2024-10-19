<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A7.963 7.963 0 0112 20a7.963 7.963 0 016.879-2.196M12 12a7.963 7.963 0 00-6.879 2.196M12 12a7.963 7.963 0 006.879 2.196M12 12V4m-6.879 7.196a7.963 7.963 0 016.879-2.196m6.879 2.196A7.963 7.963 0 0112 4" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <div class="relative">
                        <input name ="password" id="password" type="password" placeholder="Password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 12v-2m0 2a2 2 0 100-4 2 2 0 000 4zm6 6H6m6 0a6 6 0 016-6m-6 6a6 6 0 01-6-6m12 6H6" />
                            </svg>
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
