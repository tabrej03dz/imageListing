@extends('backend.layout.root', ['title' => 'Customers'])
@section('content')


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
                <div>
                    <a href="{{ route('customer.create') }}" class="btn btn-primary">Add Customer</a>
                    <a href="{{ route('customer.upload') }}" class="btn btn-primary">Customer Upload</a>
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
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->email}}</td>
                            <td>{{$customer->phone}}</td>
                            <td>
                                <a href="{{ route('customer.edit', ['customer' => $customer]) }}" class="btn btn-success mr-2">
                                    Edit
                                </a>
                                <a href="{{ route('customer.destroy', ['customer' => $customer]) }}" class="btn btn-danger mr-2">
                                    Delete
                                </a>
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
