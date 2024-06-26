@extends('backend.layout.root', ['title' => 'Create Package']);
@section('content')
    <div class="card shadow mb-4 p-5">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-around">
        <div class="col-md-8">
            <h2 class="text-2xl font-semi-bold text-gray-800 mb-4">Create Package</h2>
            <form action="{{ route('package.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Name" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="text" id="price" name="price" placeholder="Price" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="duration" class="form-label">Duration:</label>
                    <input type="number" id="duration" name="duration" placeholder="Duration" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea name="description" id="package_description_editor" cols="30" rows="5" class="form-control">

                    </textarea>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    </div>

    <script>
        CKEDITOR.replace('package_description_editor');
    </script>
@endsection
