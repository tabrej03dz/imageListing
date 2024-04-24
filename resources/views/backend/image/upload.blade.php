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
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Upload Image</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Image Title:</label>
            <input type="text" id="title" name="title" class="form-control">
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" id="date" name="date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="media" class="form-label">Choose Image:</label>
            <input type="file" id="media" name="media[]" multiple accept="media/*" required class="form-control">
        </div>
        <div id="imagePreview" class="preview"></div>
        <div class="">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </form>

    <script>
        var uploadedFiles = [];

        document.getElementById('media').addEventListener('change', function(event) {
            var files = event.target.files;
            document.getElementById('imagePreview').innerHTML = '';
            uploadedFiles = [];

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = (function(file) {
                    return function(e) {
                        var img = document.createElement('img');
                        img.className = 'preview-image';
                        img.src = e.target.result;
                        img.width = 150;
                        document.getElementById('imagePreview').appendChild(img);

                        uploadedFiles.push({ file: file, preview: img });

                        img.addEventListener('click', function() {
                            removeImage(img);
                        });
                    };
                })(file);

                reader.readAsDataURL(file);
            }
        });

        function removeImage(imgElement) {
            var index = uploadedFiles.findIndex(function(item) {
                return item.preview === imgElement;
            });

            if (index !== -1) {
                imgElement.parentNode.removeChild(imgElement);
                uploadedFiles.splice(index, 1);
                var mediaInput = document.getElementById('media');
                mediaInput.value = '';
            }
        }

    </script>

@endsection
