@extends('backend.layout.root', ['title' => 'Images'])
@section('content')

    @if($images->count() > 0)
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <a href="{{route('customer.index')}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                <h6 class="m-0 font-weight-bold text-primary">{{$customer->name."'s"}} Images</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($images as $image)
                            {{--                                @dd($images->first()->title)--}}
                            <tr>
                                <td class="align-middle">{{$image->title}}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Image Actions">
                                        @if(auth()->user()->role == 'admin')
                                            <a href="{{ route('image.destroy', ['image' => $image]) }}" class="btn btn-danger mr-2">Delete</a>
                                        @endif
                                        <a href="{{ asset('storage/' . $image->media) }}" class="btn btn-primary">Download</a>
                                    </div>

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
