@extends('backend.layout.root', ['title' => 'Create Customer'])

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

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create Customer</h2>

    <form action="{{ route('customer.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="file" class="form-label">Upload an Excel file:</label>
            <input type="file" id="file" name="file" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
