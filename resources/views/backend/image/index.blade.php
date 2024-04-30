@extends('backend.layout.root', ['title' => 'Images'])
@section('content')


    @if(session('failedMsg'))
        <div class="alert alert-danger">
            {{ session('failedMsg') }}
            <ul>
                @foreach(session('failed') as $f)
                    <li>{{ $f }}</li>
                @endforeach
            </ul>
            <!-- Display count of failed uploads -->
            <p>Number of failed uploads: {{ count(session('failed')) }}</p>
        </div>
    @endif

    @if(session('successMsg'))
        <div class="alert alert-success">
            {{ session('successMsg') }}
            <!-- Display count of successfully uploaded images -->
            <p>Number of successful uploads: {{ session('uploadedImagesCount') }}</p>
        </div>
    @endif


    @if(auth()->user()->role == 'admin')
        <form action="{{ route('image.search') }}" method="post">
            @csrf
            <div class="form-group d-flex ">
                <input type="number" name="phone" class="form-control" id="search" placeholder="Phone Number">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    @endif
    @if($images->count() > 0)
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Images</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>No of Items</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($imagesByDate as $date => $images)
                                <tr>
                                    <td class="align-middle">
                                        <a href="{{route('images.show', ['date' => $date])}}">
                                            <i class="fas fa-folder"></i> {{$date}}
                                        </a>
                                    </td>
                                    <td class="align-middle">{{$images->first()->title}}</td>
                                    <td class="align-middle">{{$images->count()}}</td>
                                    <td class="align-middle">
                                        @if(auth()->user()->role == 'admin')
                                            <a href="{{ route('images.delete', ['date' => $date]) }}" class="btn btn-danger mr-2">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    @else
        <p>No images found.</p>
    @endif
@endsection
