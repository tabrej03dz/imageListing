@extends('backend.layout.root', ['title' => 'User Details'])
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="profile-card text-center">
                <div class="card">
                    <div class="card-head">
                        <div class="row justify-content-between mt-2">
                            <div class="col-md-2">
                                <h4 class="text-left m-2">Customers</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="btn-group">
                                    <a href="{{route('recycle.restore.allCustomer')}}" class="btn btn-success">Restore All Customer</a>
                                    <a href="{{route('recycle.destroy.allCustomer')}}" onclick="return confirm('danger! This Action is irreversible')" class="btn btn-danger">Clear All Customer</a>
                                </div>
                            </div>
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
                                                    <a href="{{route('recycle.restore.customer', ['id' => $customer->id])}}" class="btn btn-success">Restore</a>
                                                    <a href="{{route('recycle.destroy.customer', ['id' => $customer->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-danger">Delete</a>
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
                        <div class="row justify-content-between mt-2">
                            <div class="col-md-2">
                                <h4 class="text-left m-2">Categories</h4>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <a href="{{route('recycle.restore.allCategories')}}" class="btn btn-success">Restore Categories</a>
                                    <a href="{{route('recycle.destroy.allCategories')}}" onclick="return confirm('Danger?: This action is irreversible')" class="btn btn-danger">Clear All Categories</a>
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
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>
                                                <a href="{{route('recycle.restore.category', ['id' => $category->id])}}" class="btn btn-success">Restore</a>
                                                <a href="{{route('recycle.destroy.category', ['id' => $category->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-danger">Delete</a>
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
                        <div class="row justify-content-between">
                            <div class="col-md-2">
                                <h4 class="text-left m-2">Languages</h4>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <a href="{{route('recycle.restore.allLanguages')}}" class="btn btn-success">Restore Languages</a>
                                    <a href="{{route('recycle.destroy.allLanguages')}}" onclick="return confirm('Danger! This action is irreversible')" class="btn btn-danger">Delete all Languages</a>
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
                                                <a href="{{route('recycle.restore.language', ['id' => $language->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-success">Restore</a>
                                                <a href="{{route('recycle.destroy.language', ['id' => $language->id])}}" class="btn btn-danger">Delete</a>
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
                        <div class="row justify-content-between">
                            <div class="col-md-2">
                                <h4 class="text-left m-2">Packages</h4>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <a href="{{route('recycle.restore.allPackages')}}" class="btn btn-success">Restore Packages</a>
                                    <a href="{{route('recycle.destroy.allPackages')}}" onclick="return confirm('Danger! This action is irreversible')" class="btn btn-damger">Delete Packages</a>
                                </div>
                            </div>

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
                                                <a href="{{route('recycle.destroy.package', ['id' => $package->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-danger">Delete</a>
                                                <a href="{{route('recycle.restore.package', ['id' => $package->id])}}" class="btn btn-success">Restore</a>
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

                <div class="card mt-4">
                    <div class="card-head">
                        <div class="row justify-content-between">
                            <div class="col-md-2">
                                <h4 class="text-left m-2">Images</h4>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <a href="{{route('recycle.restore.allImages')}}" class="btn btn-success">Restore Images</a>
                                    <a href="{{route('recycle.destroy.allImages')}}" onclick="return confirm('Danger! This action is irreversible')" class="btn btn-danger">Delete Images</a>
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
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($images as $image)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$image->title}}</td>
                                        <td>{{$image->date}}</td>
                                        <td>{{$image->user?->name}}</td>
                                        <td>
                                            <a href="{{route('recycle.destroy.image', ['id' => $image->id])}}" onclick="return confirm('Do you really want to delete it permanently')" class="btn btn-danger">Delete</a>
                                            <a href="{{route('recycle.restore.image', ['id' => $image->id])}}" class="btn btn-success">Restore</a>
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
