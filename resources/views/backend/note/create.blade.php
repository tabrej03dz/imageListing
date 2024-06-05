@extends('backend.layout.root', ['title' => 'Add Category']);
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

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create Category</h2>

    <form action="{{ route('note.store', ['user' => $user]) }}" method="POST" >
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name" placeholder="Name" class="form-control">
        </div>


        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="note_description_editor" cols="30" rows="5" class="form-control">

            </textarea>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <script>
        CKEDITOR.replace('note_description_editor');
    </script>
@endsection
