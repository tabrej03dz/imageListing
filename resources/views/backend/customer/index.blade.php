@extends('backend.layout.root', ['title' => 'Customers'])
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-3">
                        <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
                    </div>
                    <div class="col-md-5">
                        <form action="{{route('customer.search')}}" method="get"
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-light border-1 small" placeholder="Search for..."
                                       aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                 aria-labelledby="searchDropdown">
                                <form action="{{route('customer.search')}}" method="get" class="form-inline mr-auto w-100 navbar-search">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control bg-light border-0 small"
                                               placeholder="Search for..." aria-label="Search"
                                               aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('customer.create') }}" class="btn btn-primary mr-2">Add Customer</a>
                            <a href="{{ route('customer.upload') }}" class="btn btn-primary mr-2">Customer Upload</a>
                            <a href="{{ route('customer.export') }}" class="btn btn-primary">Customer Export</a>
                        </div>
                    </div>
                </div>

            </div>
            @if($customers->count() > 0)
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Package</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->phone}}</td>
                            <td>
                                <a href="{{route('customer.status', ['customer' => $customer])}}" class="btn btn-{{$customer->status == '1' ? 'success':'danger'}} p-0 px-1">{{$customer->status == '1' ? 'Active':'Inactive'}}</a>
                            </td>
                            <td>
                                    <a href="{{route('customer.assignToPackage', ['customer' => $customer])}}" type="button" class="btn btn-secondary" data-toggle="tooltip" title="Assign Package">
                                        <i class="fas fa-plus"></i>
                                    </a>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Customer Actions">
                                    <a href="{{ route('customer.edit', ['customer' => $customer]) }}" class="btn btn-success">
                                        Edit
                                    </a>
                                    <a href="{{ route('customer.images', ['customer' => $customer]) }}" class="btn btn-primary">
                                        Images
                                    </a>
                                    <a href="{{ route('customer.destroy', ['customer' => $customer]) }}" class="btn btn-danger">
                                        Delete
                                    </a>
                                    <a href="{{route('customer.details', ['customer' => $customer])}}" class="btn btn-warning">Details</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
                {{$customers->links()}}
            @else
                <p>No customers found.</p>
            @endif
        </div>

@endsection
