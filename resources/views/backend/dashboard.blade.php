@extends('backend.layout.root', ['title' => 'Dashboard'])
@section('content')
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <!-- Your dashboard content goes here -->

    <div class="flex flex-wrap justify-center">
        <!-- Box 1 -->
        <div class="w-64 h-64 bg-blue-500 m-4 p-8 text-center rounded-lg shadow-lg flex flex-col justify-center items-center">
            <i class="fa-solid fa-users text-white text-6xl mb-4"></i>
            <h2 class="text-white text-xl font-semibold">{{$customers->count()}}</h2>
            <p class="text-white mt-2">Total Customer</p>
        </div>



        <!-- Box 2 -->
        <div class="w-64 h-64 bg-green-500 m-4 p-8 text-center rounded-lg shadow-lg flex flex-col justify-center items-center">
            <i class="fa-solid fa-id-card text-white text-6xl mb-4"></i>
            <h2 class="text-white text-xl font-semibold">{{$images->count()}}</h2>
            <p class="text-white mt-2">Total Images</p>
        </div>

        <!-- Box 3 -->
        <div class="relative w-64 h-64 bg-yellow-500 m-4 p-8 text-center rounded-lg shadow-lg flex flex-col justify-center items-center">
            <i class="fa-regular fa-id-card text-white text-6xl mb-4"></i>
            @php
                $count = $images->filter(function ($image) {
                    return $image->created_at->lt(now()->subDays(3));
                })->count()
            @endphp
            <h2 class="text-white text-xl font-semibold">{{$count}}</h2>
            <p class="text-white mt-2">Images older than 3 days.</p>
            @if($count > 0)
                <a href="{{ route('clearOldImage') }}" class="absolute right-0 top-0 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded shadow">
                    Clear
                </a>

            @endif

        </div>
    </div>


@endsection
