@extends('backend.layout.root', ['title' => 'Upload Images'])
@section('content')

    <style>
        .preview {
            display: flex;
            flex-wrap: wrap;
        }

        .preview > img {
            margin: 5px; /* Adjust the gap between items */
            flex: 0 0 calc(12.5% - 10px); /* Each item occupies 12.5% width with gaps */
            max-width: calc(12.5% - 10px); /* Set maximum width to handle smaller screens */
            box-sizing: border-box; /* Include padding and border in the width calculation */
        }
    </style>
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Upload Image</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('success') }}
        </div>
    @endif


        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('image.upload')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Image Title:</label>
                <input type="text" id="title" name="title"  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="media" class="block text-gray-700 text-sm font-bold mb-2">Choose Image:</label>
                <input type="file" id="media" name="media[]" multiple accept="media/*" required class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
            </div>
            <div id="imagePreview" class="preview">

            </div>
            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Upload</button>
            </div>
        </form>


    <script>
        var uploadedFiles = []; // Array to store uploaded files and their corresponding preview elements

        document.getElementById('media').addEventListener('change', function(event) {
            var files = event.target.files; // Get the selected files

            // Clear previous previews
            document.getElementById('imagePreview').innerHTML = '';
            uploadedFiles = []; // Clear the array when new files are selected

            // Loop through the selected files
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                // Closure to capture the file information
                reader.onload = (function(file) {
                    return function(e) {
                        // Create an image element
                        var img = document.createElement('img');
                        img.className = 'preview-image';
                        img.src = e.target.result; // Set the source of the image to the data URL
                        img.width = 150; // Set width for the preview image
                        document.getElementById('imagePreview').appendChild(img); // Append the image to the preview div

                        // Push the file and its corresponding preview element to the uploadedFiles array
                        uploadedFiles.push({ file: file, preview: img });

                        // Add a click event listener to each preview image for removal
                        img.addEventListener('click', function() {
                            removeImage(img);
                        });
                    };
                })(file);

                // Read in the image file as a data URL
                reader.readAsDataURL(file);
            }
        });

        // Function to remove an image and its corresponding input
        function removeImage(imgElement) {
            // Find the index of the image element in the uploadedFiles array
            var index = uploadedFiles.findIndex(function(item) {
                return item.preview === imgElement;
            });

            if (index !== -1) {
                // Remove the image preview element from the DOM
                imgElement.parentNode.removeChild(imgElement);

                // Remove the corresponding file from the uploadedFiles array
                uploadedFiles.splice(index, 1);

                // Remove the corresponding file from the input element
                var mediaInput = document.getElementById('media');
                mediaInput.value = ''; // Clear the input value
            }
        }

    </script>

@endsection
