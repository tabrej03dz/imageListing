<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<!-- Header -->
<header class="bg-white border-b border-gray-200 p-4">
    <div class="flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center">
            <img class="w-10 h-10 rounded-full mr-2" src="https://via.placeholder.com/50" alt="Logo">
            <span class="text-gray-700">Admin Dashboard</span>
        </div>
        <!-- Navigation -->
        <nav>
            <ul class="flex">
                <li class="ml-4"><a href="#" class="text-gray-700 hover:text-gray-900">Home</a></li>
                <li class="ml-4"><a href="#" class="text-gray-700 hover:text-gray-900">About</a></li>
                <!-- Add more navigation links as needed -->
            </ul>
        </nav>
    </div>
</header>

<!-- Sidebar -->
<div class="flex">
    <aside class="bg-gray-800 min-h-screen w-64 text-white">
        <div class="py-4 px-6 text-center">
            Admin Dashboard
        </div>
        <ul>
            <li class="py-2 px-6 hover:bg-gray-700">
                <a href="{{route('dashboard')}}" class="block">Dashboard</a>
            </li>
            @if(auth()->user()->role == 'admin')
                <li class="py-2 px-6 hover:bg-gray-700">
                    <a href="{{route('image.upload')}}" class="block">Upload Image</a>
                </li>
            @endif
            <li class="py-2 px-6 hover:bg-gray-700">
                <a href="{{route('image.index')}}" class="block">Images</a>
            </li>

            <li class="py-2 px-6 hover:bg-gray-700">
                <a href="{{route('clearOldImage')}}" class="block">Clear Old Images</a>
            </li>

            <li class="py-2 px-6 hover:bg-gray-700">
                <a href="{{route('logout')}}" class="block">Logout</a>
            </li>

            <!-- Add more sidebar links as needed -->
        </ul>
    </aside>

    <!-- Main content -->
    <main class="flex-1">

        <!-- Page content -->
        <div class="p-4">
            <!-- Page content goes here -->
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
