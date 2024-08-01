@extends('backend.layout.root', ['title' => 'User Details'])
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="profile-card text-center">

                <div class="row">
                    <div class="col-md-6 p-5">
                        <img src="{{asset('assets/profile.png')}}" alt="Profile Picture" class="profile-pic" style="border-radius: 50%;">
                        <h2 class="mb-2 text-success">{{$customer->name}}</h2>
                        <p class="mb-2 text-warning">{{$customer->phone}}</p>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Email</td>
                                <td>{{$customer->email}}</td>
                            </tr>
                            <tr>
                                <td>Phone 2</td>
                                <td>{{$customer->phone1}}</td>
                            </tr>
                            <tr>
                                <td>Business Name</td>
                                <td>{{$customer->business_name}}</td>
                            </tr>
                            <tr>
                                <td>Country </td>
                                <td>{{$customer->countri?->name}}</td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td>{{$customer->states?->name}}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>{{$customer->city}}</td>
                            </tr>
                            <tr>
                                <td>Pin Code</td>
                                <td>{{$customer->pin}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{$customer->address}}</td>
                            </tr>
                            <tr>
                                <td>GST Number</td>
                                <td>{{$customer->gst_number}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="card">
                    <div class="card-head">
                        <div class="flex d-flex justify-content-between">
                            <h4 class="text-left m-2">Packages</h4>
                            <a href="{{route('customer.assignToPackage', ['customer' => $customer])}}" type="button" class="btn btn-primary p-1 mt-3 mr-3" data-toggle="tooltip" title="Assign Package">
                                assign package
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Name</th>
{{--                                    <th>Duration (days)</th>--}}
                                    <th>Price</th>
                                    <th>Start Date</th>
                                    <th>Expiry Date</th>
                                    <th>Expire In</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customer->userPackages as $package)
                                    <tr>
                                        <td>{{$package->package->name}}</td>
{{--                                        <td>{{$package->package->duration}}</td>--}}
                                        <td>{{$package->package->price}}</td>
                                        <td>{{$package->start_date}}</td>
                                        <td>{{$package->expiry_date}}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $package->expiry_date)->diffInDays(\Carbon\Carbon::today()) }}</td>
                                        @php
                                            $paid = $package->payments->sum('amount');
                                        @endphp
                                        <td class="bg-{{$package->package->price == $paid ? 'success' : 'warning'}}">{{$paid}}</td>
                                        <td class="bg-{{$package->package->price == $paid ? 'warning' : 'danger'}}">{{$package->package->price - $paid}}</td>
                                        <td>
                                            <div class="btn-group">
{{--                                                @dd($package->status)--}}
                                                <a href="{{route('package.ofCustomer.status', ['customerPackage' => $package])}}" class="btn btn-{{$package->status == '1' ? 'info' : 'dark'}}">{{$package->status == '1' ? 'Active' : 'Inactive'}}</a>
                                                <a href="{{route('package.ofCustomer.edit', ['customerPackage' => $package])}}" class="btn btn-primary">Edit</a>
                                                <a href="{{route('package.ofCustomer.delete', ['customerPackage' => $package])}}" class="btn btn-danger">Delete</a>
                                                <a href="{{route('payment.add', ['customerPackage' => $package])}}" class="btn btn-success">Add Payment</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-head">
                        <h4 class="text-left m-2">Frame: {{$customer->frame}}</h4>
                        <p class="text-left">Similar Frames</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Frame</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $similarFrames = \App\Models\User::where(['city' => $customer->city, 'frame' => $customer->frame])->get();
                                @endphp
                                @foreach($similarFrames as $frame)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$frame->name}}</td>
                                        <td>{{$frame->phone}}</td>
                                        <td>{{$frame->frame}}</td>
                                        <td>
                                            <a href="{{route('customer.edit', ['customer' => $frame->id])}}" class="btn btn-danger">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-head">
                        <h4 class="text-left m-2">Categories</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->userCategories as $category)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$category->category->name}}</td>
                                            <td>
                                                <a href="{{route('customer.category.delete', ['category' => $category, 'customer' => $customer])}}" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-head">
                        <h4 class="text-left m-2">Languages</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->userLanguages as $language)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$language->language->name}}</td>
                                            <td>{{$language->language->code}}</td>
                                            <td>
                                                <a href="{{route('customer.language.delete', ['language' => $language, 'customer' => $customer])}}" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="card mt-4">
                    <div class="card-head">
                        <div class="d-flex justify-content-between">
                            <h4 class="text-left m-2">Notes</h4>
                            <a href="{{route('note.create', ['user' => $customer])}}" type="button" class="btn btn-primary p-1 mt-3 mr-3" data-toggle="tooltip" title="Assign Package">
                                Add Notes
                            </a>
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
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customer->notes as $note)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$note->name}}</td>
                                        <td>{!! $note->description !!}</td>
                                        <td>
                                            <a href="{{route('note.delete', ['note' => $note])}}" onclick="return confirm('Are you sure to delete ?')" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
