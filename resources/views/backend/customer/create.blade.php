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

    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Name:</label>
            <input type="text" id="title" name="name" placeholder="Name" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" class="form-control">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" id="phone" name="phone" placeholder="Phone" class="form-control">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select id="status" name="status" class="form-select form-control">
                <option value="">Select Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Package Start Date:</label>
            <input type="date" id="start_date" name="start_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="expiry_date" class="form-label">Package Expiry Date:</label>
            <input type="date" id="expiry_date" name="expiry_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Category:</label>
            <select name="category_id[]" multiple id="" class="form-control">
                <option value="" disabled>Category</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Languages:</label>
            <select name="language_id[]" multiple id="" class="form-control">
                <option value="" disabled>Select Language</option>
                @foreach($languages as $language)
                    <option value="{{$language->id}}">{{$language->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
