@extends('backend.layout.root', ['title' => 'Packages'])
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-3">
                    <h6 class="m-0 font-weight-bold text-primary">Packages</h6>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('package.create') }}" class="btn btn-primary mr-2">Create Package</a>
                    </div>
                </div>
            </div>

        </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Duration (days)</th>
                            <th>Assign</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($packages->count() > 0)
                        @foreach($packages as $package)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$package->name}}</td>
                                <td>{{$package->description}}</td>
                                <td>{{$package->price}}</td>
                                <td>{{$package->duration}}</td>
                                <td>
                                    <a href="{{route('package.assignToCustomer', ['package' => $package])}}" type="button" class="btn btn-secondary" data-toggle="tooltip" title="Package Assign to user">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Customer Actions">
                                        <a href="{{ route('package.edit', ['package' => $package]) }}" class="btn btn-success">
                                            Edit
                                        </a>
                                        <a href="{{ route('package.destroy', ['package' => $package]) }}" class="btn btn-danger">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <p>No Category found.</p>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            {{--            {{$packages->links()}}--}}
    </div>
@endsection
