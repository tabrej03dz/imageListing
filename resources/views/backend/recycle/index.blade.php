@extends('backend.layout.root', ['title' => 'User Details'])
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="profile-card text-center">
                <div class="card">
                    <div class="card-head">
                        <div class="flex d-flex justify-content-between">
                            <h4 class="text-left m-2">Customers</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$customer->name}}</td>
                                            <td>{{$customer->phone}}</td>
                                            <td>{{$customer->email}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{route('recycle.customerRestore', ['id' => $customer->id])}}" class="btn btn-success">Restore</a>
                                                    <a href="{{route('recycle.customerDestroy', ['id' => $customer->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-danger">Delete</a>
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
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            <a href="{{route('recycle.categoryRestore', ['id' => $category->id])}}" class="btn btn-success">Restore</a>
                                            <a href="{{route('recycle.categoryDelete', ['id' => $category->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-danger">Delete</a>
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
                                @foreach($languages as $language)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$language->name}}</td>
                                        <td>{{$language->code}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{route('recycle.languageRestore', ['id' => $language->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-success">Restore</a>
                                                <a href="{{route('recycle.languageRestore', ['id' => $language->id])}}" class="btn btn-danger">Delete</a>
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
                        <div class="d-flex justify-content-between">
                            <h4 class="text-left m-2">Packages</h4>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($packages as $package)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$package->name}}</td>
                                            <td>{!! $package->description !!}</td>
                                            <td>
                                                <a href="{{route('recycle.packageDelete', ['id' => $package->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-danger">Delete</a>
                                                <a href="{{route('recycle.packageRestore', ['id' => $package->id])}}" class="btn btn-success">Restore</a>
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
                                @foreach($notes as $note)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$note->name}}</td>
                                        <td>{!! $note->description !!}</td>
                                        <td>
                                            <a href="{{route('recycle.noteDelete', ['id' => $note->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-danger">Delete</a>
                                            <a href="{{route('recycle.noteRestore', ['id' => $note->id])}}" class="btn btn-success">Restore</a>
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
