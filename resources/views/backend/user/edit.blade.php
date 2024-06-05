@extends('backend.layout.root', ['title' => 'Edit User'])

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

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create User</h2>

    <form action="{{ route('user.update', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="profile_photo" class="form-label">Profile Photo:</label>
            <input type="file" id="profile_photo" name="profile_photo" placeholder="Profile Photo" class="form-control">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name" placeholder="Name" class="form-control">
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
            <label for="role" class="form-label">Role:</label>
            <select id="role" name="role" class="form-select form-control">
                {{--                <option value="">Select Status</option>--}}
                <option value="designer">Designer</option>
                <option value="calling">Calling</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="form-control">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
