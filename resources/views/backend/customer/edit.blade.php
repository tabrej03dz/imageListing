@extends('backend.layout.root', ['title' => 'Edit Customer'])

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

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Customer</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.update', ['customer' => $customer]) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name" value="{{ $customer->name }}" class="form-control" placeholder="Name">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" value="{{ $customer->email }}" class="form-control" placeholder="Email">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" id="phone" name="phone" value="{{ $customer->phone }}" class="form-control" placeholder="Phone">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select id="status" name="status" class="form-select form-control">
                <option value="">Select Status</option>
                <option value="1" {{$customer->status == '1' ? 'selected' : ''}}>Active</option>
                <option value="0" {{$customer->status == '0' ? 'selected' : ''}}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Package Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $customer->start_date??'' }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="expiry_date" class="form-label">Package Expiry Date:</label>
            <input type="date" id="expiry_date" name="expiry_date" value="{{ $customer->expiry_date ?? '' }}" class="form-control">
        </div>


        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
        </div>

        <div class="mb-3">
            <label for="confirm-password" class="form-label">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm_password" class="form-control" placeholder="Confirm Password">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
