<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

    @if(session('success'))
        <div id="successAlert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ session('success') }}</strong>
            <span id="closeButton" onclick="closeAlert()" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
            <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path fill-rule="evenodd" d="M14.293 5.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414L10 8.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
        </span>
        </div>
    @endif



</header>

<!-- Sidebar -->
<div class="flex">
    <aside class="bg-gray-800 min-h-screen w-64 text-white">
        <div class="py-4 px-6 text-center">
            Admin Dashboard
        </div>
        <ul>
            <li class="py-2 px-6 hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-red-700' : '' }}">
                <a href="{{ route('dashboard') }}" class="block">Dashboard</a>
            </li>

            <li class="py-2 px-6 hover:bg-gray-700 {{ request()->routeIs('image.index') ? 'bg-red-700' : '' }}">
                <a href="{{ route('image.index') }}" class="block">Images</a>
            </li>

            @if(auth()->user()->role == 'admin')
                <li class="py-2 px-6 hover:bg-gray-700 {{ request()->routeIs('images.upload') ? 'bg-red-700' : '' }}">
                    <a href="{{ route('images.upload') }}" class="block">Upload Image</a>
                </li>
                <li class="py-2 px-6 hover:bg-gray-700 {{ request()->routeIs('customer.index') ? 'bg-red-700' : '' }}">
                    <a href="{{ route('customer.index') }}" class="block">Customer</a>
                </li>
{{--                <li class="py-2 px-6 hover:bg-gray-700 {{ request()->routeIs('clearOldImage') ? 'bg-red-700' : '' }}">--}}
{{--                    <a href="{{ route('clearOldImage') }}" class="block">Clear Old Images</a>--}}
{{--                </li>--}}
            @endif

            <li class="py-2 px-6 hover:bg-gray-700 {{ request()->routeIs('logout') ? 'bg-red-700' : '' }}">
                <a href="{{ route('logout') }}" class="block">Logout</a>
            </li>
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

<script>
    function closeAlert() {
        var alert = document.getElementById("successAlert");
        alert.style.display = "none";
    }
</script>

</body>
</html>
