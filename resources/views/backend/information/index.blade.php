@extends('backend.layout.root', ['title' => 'Categories'])
@section('content')

    <div class="alert alert-success alert-dismissible fade right-0 top-0" id="messageBox" role="alert">
        <strong>Success!</strong> <p>Information sent successfully to <span id="message">0</span> Customers</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-3">
                    <h6 class="m-0 font-weight-bold text-primary">Information</h6>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('information.create') }}" class="btn btn-primary mr-2">Create Information</a>
                    </div>
                </div>
            </div>

        </div>
{{--        @if($informations->count() > 0)--}}
{{--            <div class="card-body">--}}
{{--                <div class="table-responsive">--}}
{{--                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>S. No.</th>--}}
{{--                            <th>Title</th>--}}
{{--                            <th>Description</th>--}}
{{--                            <th>Image</th>--}}
{{--                            <th>Action</th>--}}
{{--                            <th>Send</th>--}}
{{--                            <th>Sent</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                            @foreach($informations as $information)--}}
{{--                                <tr>--}}
{{--                                    <td>{{$loop->iteration}}</td>--}}
{{--                                    <td>{{$information->title}}</td>--}}
{{--                                    <td>{!! $information->description !!}</td>--}}
{{--                                    <td>--}}
{{--                                        @if($information->image)--}}
{{--                                            <img src="{{asset('storage/' . $information->image)}}" alt="" style="width: 100px; height: auto;">--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <div class="btn-group" role="group" aria-label="Customer Actions">--}}
{{--                                            <a href="{{ route('information.edit', ['information' => $information]) }}" class="btn btn-success">--}}
{{--                                                Edit--}}
{{--                                            </a>--}}
{{--                                            <a href="{{ route('information.delete', ['information' => $information]) }}" onclick="return confirm('Are you sure to delete ?')" class="btn btn-danger">--}}
{{--                                                Delete--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <div class="btn-group" role="group" aria-label="Customer Actions">--}}
{{--                                            <form action="{{route('information.send', ['information' => $information])}}" method="post">--}}
{{--                                                @csrf--}}
{{--                                                <input type="number" name="phone" placeholder="Phone" class="form-control">--}}
{{--                                                <select name="status" id="" class="form-control">--}}
{{--                                                    <option value="">Select User Type</option>--}}
{{--                                                    <option value="1">Active</option>--}}
{{--                                                    <option value="0">Inactive</option>--}}
{{--                                                </select>--}}
{{--                                                <input type="submit" value="Submit" class="btn btn-primary">--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        {{$information->userSents->count()}}--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            {{$categories->links()}}--}}
{{--        @else--}}
{{--            <p>No Category found.</p>--}}
{{--        @endif--}}


        @if($informations->count() > 0)
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                            <th>Send</th>
                            <th>Sent</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($informations as $information)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$information->title}}</td>
                                <td>{!! $information->description !!}</td>
                                <td>
                                    @if($information->image)
                                        <img src="{{asset('storage/' . $information->image)}}" alt="" style="width: 100px; height: auto;">
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Customer Actions">
                                        <a href="{{ route('information.edit', ['information' => $information]) }}" class="btn btn-success">
                                            Edit
                                        </a>
                                        <a href="{{ route('information.delete', ['information' => $information]) }}" onclick="return confirm('Are you sure to delete ?')" class="btn btn-danger">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Customer Actions">
                                        <form id="sendForm{{$information->id}}" class="sendForm" method="post">
                                            @csrf
                                            <input type="number" name="phone" placeholder="Phone" class="form-control">
                                            <select name="status" id="" class="form-control">
                                                <option value="">Select User Type</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <input type="hidden" name="information_id" value="{{$information->id}}">
                                            <input type="submit" value="Submit" class="btn btn-primary submitBtn">
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <span id="sendCount{{$information->id}}">
                                    {{$information->userSents->count()}}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p>No Information found.</p>
        @endif

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Attach a submit handler to each form
            $('.sendForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting the normal way
                var form = $(this);
                var phoneNumber = form.find('input[name="phone"]').val().trim();
                var formData = form.serialize(); // Get the form data

                for (let i = 0; i <= (phoneNumber != '' ? 1 : 100); i++) { // Loop 10 times
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('information.send') }}', // Use a common route for AJAX
                        data: formData,
                        success: function(response) {
                            // Handle success for each request - display a message or update the UI
                            console.log("Information sent successfully - Attempt " + (i + 1));

                            document.getElementById('messageBox').classList.add('show');
                            document.getElementById('message').innerText = i;

                            // Update the 'Sent' column with the new count on the last request
                            if (i === 100) {
                                alert(`Information sent to ${i} customers successfully!`);
                                form.closest('tr').find('td:last').text(response.sentCount);
                            }
                        },
                        error: function(xhr) {
                            // Handle error for each request
                            alert("An error occurred on attempt " + (i + 1) + ". Please try again.");
                        }
                    });
                }
            });
        });
    </script>

@endsection
