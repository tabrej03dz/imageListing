@extends('backend.layout.root', ['title' => 'Categories'])
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
                                            <a href="{{ route('information.delete', ['information' => $information]) }}" class="btn btn-danger">
                                                Delete
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Customer Actions">
                                            <form action="{{route('information.send', ['information' => $information])}}" method="post">
                                                @csrf
                                                <input type="number" name="phone" placeholder="Phone" class="form-control">
                                                <select name="status" id="" class="form-control">
                                                    <option value="">Select User Type</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                <input type="submit" value="Submit" class="btn btn-primary">
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        {{$information->userSents->count()}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
{{--            {{$categories->links()}}--}}
        @else
            <p>No Category found.</p>
        @endif
    </div>
@endsection
