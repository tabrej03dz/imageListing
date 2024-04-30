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
@endsection
