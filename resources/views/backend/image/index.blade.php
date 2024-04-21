@extends('backend.layout.root')
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
        <table>
            <thead>
            <tr>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($images as $image)
                <tr>
                    <td>
                        <img src="{{ asset('storage/'. $image->media) }}" alt="Image" class="w-full h-auto">
                    </td>
                    <td>
                        @if(auth()->user()->role == 'admin')
                            <a href="{{ route('image.destroy', ['image' => $image]) }}" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Delete</a>
                        @endif
                        <a href="{{ asset('storage/' . $image->media) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" target="_blank" download="{{$image->title}}">Download</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No images found.</p>
    @endif

@endsection
