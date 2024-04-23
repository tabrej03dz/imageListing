@extends('backend.layout.root', ['title' => 'Images'])
@section('content')
    <h1>Image Index</h1>
    @if(auth()->user()->role == 'admin')
        <form action="{{route('image.search')}}" method="post">
            @csrf
            <div class="mb-4">
            <label for="search" class="block text-gray-700 text-sm font-bold mb-2">Search:</label>
                <input type="text" name="phone" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">

            </div>
            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Search</button>
            </div>
        </form>
    @endif
    @if($images->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($images as $image)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <img class="h-12 w-12 rounded-full" src="{{ asset('storage/'. $image->media) }}" alt="Image">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm leading-5 font-medium text-gray-900">{{ $image->title }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap">{{ $image->date }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap">
                        @if(auth()->user()->role == 'admin')
                            <a href="{{ route('image.destroy', ['image' => $image]) }}" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Delete</a>
                        @endif
                        <a href="{{ asset('storage/' . $image->media) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" target="_blank" download="{{ $image->title }}">Download</a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        {{$images->links()}}

    @else
        <p>No images found.</p>
    @endif

@endsection
