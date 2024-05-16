@extends('backend.layout.root', ['title' => 'Add Language']);
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

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Add Language</h2>

    <form action="{{ route('language.store') }}" method="POST" >
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Language Name:</label>
            <input type="text" id="title" name="name" placeholder="Name" class="form-control">
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Language Code:</label>
            <input type="text" id="code" name="code" placeholder="Language Code" class="form-control">
        </div>



        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
