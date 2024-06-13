@extends('backend.layout.root', ['title' => 'Categories'])
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-3">
                    <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('category.create') }}" class="btn btn-primary mr-2">Add Category</a>
                    </div>
                </div>
            </div>

        </div>
        @if($categories->count() > 0)
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->parent?->name}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Customer Actions">
                                        <a href="{{ route('category.edit', ['category' => $category]) }}" class="btn btn-success">
                                            Edit
                                        </a>
                                        <a href="{{ route('category.destroy', ['category' => $category]) }}" onclick="return confirm('Are you sure to delete ?')" class="btn btn-danger">
                                            Delete
                                        </a>
                                    </div>
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
