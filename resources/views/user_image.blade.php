<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Index</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-8">Image Index</h1>

    @if($images->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Image</th>
                    <th class="px-4 py-2 text-left">Title</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($images as $image)
                    <tr>
                        <td class="border px-4 py-2">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <img class="h-12 w-12 rounded-full" src="{{ asset('storage/'. $image->media) }}" alt="Image">
                                </div>
                            </div>
                        </td>
                        <td class="border px-4 py-2">
                            <div class="ml-4">
                                <div class="text-sm leading-5 font-medium text-gray-900">{{ $image->title }}</div>
                            </div>
                        </td>
                        <td class="border px-4 py-2">
                            {{$image->date}}
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ asset('storage/' . $image->media) }}"
                               class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                               target="_blank"
                               download="{{$image->title}}">Download</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600">No images found.</p>
    @endif
</div>
</body>
</html>
