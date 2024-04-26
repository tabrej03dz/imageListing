@extends('backend.layout.root', ['title' => 'Profile'])
@section('content')

    <style>

        /* Custom styles */
        .profile-image {
            width: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff; /* Add a border around the profile image */
        }
        .profile-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
        }
        /* Optional: Adjust padding for smaller screens */
        @media (max-width: 768px) {
            .profile-details {
                padding: 10px;
            }
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <img src="{{asset('storage/'. auth()->user()->images()->first()?->media)}}" alt="Profile Picture" class="profile-image">
            </div>
            <div class="col-md-8">
                <div class="profile-details">
                    <h2 class="mb-4">{{auth()->user()->name}}</h2>
                    <p><strong>Email:</strong> {{auth()->user()->email}}</p>
                    <p><strong>Phone:</strong> {{auth()->user()->phone}}</p>
{{--                    <p><strong>About Me:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod euismod nisi, eget sollicitudin dui consectetur id. Nullam aliquet tincidunt arcu, eget volutpat quam laoreet a.</p>--}}
                    <button class="btn btn-primary">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>


@endsection
