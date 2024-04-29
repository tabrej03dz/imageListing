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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" rel="stylesheet">

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

    @if(session('failedMsg'))
        <div class="alert alert-danger">
            {{ session('failedMsg') }}
                <ul>
                    @foreach(session('failed') as $f)
                        <li>{{ $f }}</li>
                    @endforeach
                </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="media" class="form-label">Choose Media:</label>
            <input type="file" id="media" name="media[]" multiple accept="media/*" required class="form-control">
        </div>
        <div id="imagePreview" class="preview"></div>
        <div class="">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </form>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.myDropzone = {
            chunking: true,
            forceChunking: true,
            chunkSize: 1024 * 1024, // 1 MB chunks
            url: '{{ url("image/store") }}',
            paramName: 'file',
            init: function() {
                this.on('queuecomplete', function() {
                    // Handle complete file upload
                    alert('File uploaded successfully');
                });
            }
        };
    </script>


@endsection
