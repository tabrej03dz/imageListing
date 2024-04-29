@extends('backend.layout.root', ['title' => 'Images'])
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>



    @if(auth()->user()->role == 'admin')
        <form action="{{ route('image.search') }}" method="post">
            @csrf
            <div class="form-group d-flex ">
                <input type="text" name="phone" class="form-control" id="search" placeholder="Enter your search term">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    @endif
    @if($images->count() > 0)
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <a href="{{route('image.index')}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                <h6 class="m-0 font-weight-bold text-primary">{{$images->first()->title.' '.$date.' '}} Images</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($images as $image)
                            {{--                                @dd($images->first()->title)--}}
                            <tr>
                                <td class="align-middle">{{$image->user->name}}</td>
                                <td class="align-middle">{{$image->user->phone}}</td>
                                <td class="align-middle">
                                    @if(auth()->user()->role == 'admin')
                                        <a href="{{ route('image.destroy', ['image' => $image]) }}" class="btn btn-danger mr-2">Delete</a>
                                    @endif
                                                                            <a href="{{ asset('storage/' . $image->media) }}" class="btn btn-primary" target="_blank" download="{{ $image->title }}">Download</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                                            {!! $images->links() !!}
                </div>
            </div>
        </div>
    @else
        <p>No images found.</p>
    @endif

@endsection
