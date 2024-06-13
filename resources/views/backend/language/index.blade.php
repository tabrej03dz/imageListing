@extends('backend.layout.root', ['title' => 'Languages'])
@section('content')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-10">
                        <h6 class="m-0 font-weight-bold text-primary">Languages</h6>
                    </div>
                    <div class="col-md-2">
                        <a href="{{route('language.create')}}" class="btn btn-primary">Add</a>
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
                            <th>Code</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($languages->count() > 0)
                        @foreach($languages as $language)
                            <tr>
                                <td class="align-middle">{{$loop->iteration}}</td>
                                <td class="align-middle">{{$language->name}}</td>
                                <td class="align-middle">{{$language->code}}</td>
                                <td class="align-middle">
                                    <a id="bulkSendBtn" href="{{route('language.destroy', ['language' => $language])}}" onclick="return confirm('Are you sure to delete ?')" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <p>No languages found.</p>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <script>
        document.getElementById('bulkSendBtn').addEventListener('click', function() {
            this.classList.add('disabled'); // Disable the button when clicked
        });
    </script>
@endsection
