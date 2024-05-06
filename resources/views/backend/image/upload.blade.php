@extends('backend.layout.root', ['title' => 'Upload Images'])
@section('content')
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
        <div class="alert alert-danger position-absolute right-0 top-0 alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('failedMsg') }}
            <ul>
                @foreach(session('failed') as $f)
                    <li>{{ $f }} </li>
                @endforeach
            </ul>
            <!-- Display count of failed uploads -->
            <p>Number of failed uploads: {{ count(session('failed')) }}</p>
        </div>
    @endif

    @if(session('uploadSuccess'))
        <div class="alert alert-success position-absolute left-0 top-0 alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach(session('uploadSuccess') as $s)
                    <li>{{ $s }}</li>
                @endforeach
            </ul>
            <!-- Display count of failed uploads -->
            <p>Number of Success uploads: {{ count(session('uploadSuccess')) }}</p>
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
            <input type="file" id="media" name="media[]" multiple accept="image/*" required class="form-control">
        </div>
        <!-- Image preview container -->
        <div id="imagePreview" class="preview"></div>
        <div class="">
            <button type="submit" id="submit-button" class="btn btn-primary">Upload</button>
        </div>
    </form>

    <div id="response"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#media').change(function() {
                // Image preview code here if needed
            });

            $('#uploadForm').submit(function(e){
                e.preventDefault();
                var formData = new FormData($(this)[0]);

                // Get all files
                var files = $('#media')[0].files;

                // Iterate over each file
                for (var i = 0; i < files.length; i++) {
                    // Create a new form data instance for each file
                    var fileData = new FormData();
                    fileData.append('title', formData.get('title'));
                    fileData.append('date', formData.get('date'));
                    fileData.append('media[]', files[i]);

                    // Send AJAX POST request for each file
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: fileData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            // Handle successful response
                            $('#response').html('<div class="alert alert-success">' + response.message + '</div>');
                        },
                        error: function(xhr, status, error){
                            // Handle errors
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });

    </script>
@endsection
