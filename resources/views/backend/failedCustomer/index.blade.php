@extends('backend.layout.root', ['title' => 'Customers'])
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row justify-content-between">
                <div class="col-md-3">
                    <h6 class="m-0 font-weight-bold text-primary">Failed Customers</h6>
                </div>
                <div class="col-md-2">
                    <a href="{{route('customer.failed.removeAll')}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove all failed customers?')">Remove All</a>
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
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$customer->phone}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Customer Actions">
                                        <a href="{{ route('customer.failed.add', ['customer' => $customer]) }}" class="btn btn-success">
                                            Add
                                        </a>

                                        <a href="{{ route('customer.failed.remove', ['customer' => $customer]) }}" class="btn btn-danger">
                                            Remove
                                        </a>
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
