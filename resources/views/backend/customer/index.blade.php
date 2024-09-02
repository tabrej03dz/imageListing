@extends('backend.layout.root', ['title' => 'Customers'])
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">

                        <h6 class="m-0 font-weight-bold text-primary">Customers</h6>


                        <form action="{{route('customer.search')}}" method="get"
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-light border-1 small" placeholder="Search for..."
                                       aria-label="Search" aria-describedby="basic-addon2">
                                <select name="status" id="">
                                    <option value="">select status</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="active">Active</option>
                                </select>
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
                                        <select name="status" id="">
                                            <option value="0">Inactive</option>
                                            <option value="1">Active</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm mr-2">Add Customer</a>
                            <a href="{{ route('customer.upload') }}" class="btn btn-primary btn-sm mr-2">Customer Upload</a>
                            <a href="{{ route('customer.export') }}" class="btn btn-primary btn-sm mr-2">Customer Export</a>
                            <a href="{{route('packageAssignToAllCustomer')}}" class="btn btn-primary btn-sm">Package Assign to all customer</a>
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
                            <th>Action</th>
                            <th>Frame</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            @php
                                $expiryDate = $customer->userPackages()->orderBy('expiry_date', 'desc')->first()->expiry_date;
                                $expiryDate = Carbon::parse($expiryDate);
                    //            dd($expiryDate->lessThan(Carbon::now()));
                                if ($expiryDate->lessThan(Carbon::now())){
                                    $customer->update(['status' => '0']);
                                }else{
                                    $customer->update(['status' => '1']);
                                }
                            @endphp
                        <tr>
                            <td>{{$loop->iteration}}</td>

                            <td><a href="{{route('customer.details', ['customer' => $customer])}}">
                                {{$customer->name}}
                            </a></td>

                            <td><a href="{{route('customer.details', ['customer' => $customer])}}">
                                    {{$customer->phone}}
                            </a></td>
                            <td>
                                <a href="{{route('customer.status', ['customer' => $customer])}}" class="btn btn-{{$customer->status == '1' ? 'success':'danger'}} p-0 px-1">{{$customer->status == '1' ? 'Active':'Inactive'}}</a>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Customer Actions">
                                    <a href="{{ route('customer.edit', ['customer' => $customer]) }}" class="btn btn-success btn-sm">
                                        Edit
                                    </a>
                                    <a href="{{ route('customer.images', ['customer' => $customer]) }}" class="btn btn-primary btn-sm">
                                        Images
                                    </a>
                                    <a href="{{ route('customer.destroy', ['customer' => $customer]) }}" onclick="return confirm('Are you sure to delete ?')" class="btn btn-danger btn-sm">
                                        Delete
                                    </a>
                                    <a href="{{route('customer.details', ['customer' => $customer])}}" class="btn btn-warning btn-sm">Details</a>
                                </div>
                            </td>
                            <td>
                                @php
                                    $similarFrames = \App\Models\User::where(['city' => $customer->city, 'frame' => $customer->frame])->get();
                                @endphp
                                <form action="{{route('customer.frame.update', ['customer' => $customer->id])}}" method="post" class="d-flex align-items-center">
                                    @csrf
                                    <input type="text" name="frame" class="form-control me-2" value="{{$customer->frame}}" style="width: 100px;">
                                    <input type="submit" value="save" class="btn btn-primary btn-sm me-2">
                                    <a href="#" class="btn btn-danger btn-sm">{{$similarFrames->count()}}</a>
                                </form>



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
