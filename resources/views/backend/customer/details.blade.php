@extends('backend.layout.root', ['title' => 'User Details'])
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="profile-card text-center">
                <img src="{{asset('assets/profile.png')}}" alt="Profile Picture" class="profile-pic" style="border-radius: 50%;">
                <h2 class="mb-3 text-success">{{$customer->name}}</h2>
                <p class="text-warning">{{$customer->phone}}</p>
                <div class="card">
                    <div class="card-head">
                        <div class="flex d-flex justify-content-between">
                            <h4 class="text-left m-2">Packages</h4>
                            <a href="{{route('customer.assignToPackage', ['customer' => $customer])}}" type="button" class="btn btn-primary p-1 mt-3 mr-3" data-toggle="tooltip" title="Assign Package">
                                create package
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
                                    <th>Duration (days)</th>
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
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$package->package->name}}</td>
                                        <td>{{$package->package->duration}}</td>
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
                                            <a href="{{route('package.ofCustomer.delete', ['customerPackage' => $package])}}" class="btn btn-danger">Delete</a>
                                            <a href="{{route('payment.add', ['customerPackage' => $package])}}" class="btn btn-success">Add Payment</a>
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
                                create note
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
                                            <a href="{{route('note.delete', ['note' => $note])}}" class="btn btn-danger">Delete</a>
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
