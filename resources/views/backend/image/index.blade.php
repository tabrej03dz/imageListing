@extends('backend.layout.root', ['title' => 'Images'])
@section('content')

    <div class="alert alert-success alert-dismissible fade right-0 top-0" id="messageBox" role="alert">
        <strong>Success!</strong> <p>Images sent successfully: <span id="message">0</span></p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    @if($images->count() > 0)
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="m-0 font-weight-bold text-primary">Images</h6>
                    </div>
                    <div class="col-md-6">
                        <p>Show all images: <a href="{{route('image.show_all')}}" class="btn btn-{{$setting->show_all_images == '0' ? 'warning' : 'primary'}}">{{$setting->show_all_images == '0' ? 'Disabled' : 'Enabled'}}</a> </p>
                    </div>
                </div>

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
                            <th>Sent</th>
                            <th>Remains</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($imagesByDate->sortKeys() as $date => $images)
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
                                        <a href="{{ route('images.delete', ['date' => $date]) }}" class="btn btn-danger mr-2" onclick="return confirm('Are you sure to delete all images of this date!')">Delete</a>
                                    @endif
                                    <a id="#" href="javascript:void(0)" onclick="


                                        // var button = this;
                                        {{--var spinner = document.getElementById('spinner{{$date}}');--}}
                                        {{--var btnText = document.getElementById('btnText{{$date}}');--}}

                                        {{--// Hide the button text--}}
                                        {{--btnText.style.display = 'none';--}}

                                        {{--// Show the spinner--}}
                                        {{--spinner.style.display = 'inline-block';--}}

                                        {{--// Disable the button--}}
                                        {{--button.classList.add('disabled');--}}
                                        {{--setInterval(function(){--}}
                                        {{--    var count = 0;--}}
                                        {{--$.ajax({--}}
                                        {{--    url: '{{ route("images.sentCount", ['date' => $date]) }}',--}}
                                        {{--    method: 'GET',--}}
                                        {{--    success: function(response) {--}}
                                        //         count = response.count;
                                                var j = 1;
                                                for (var i = 1; i<=5; i++){
                                                    $.ajax({
                                                        url: '{{ route("images.sendImage", ['date' => $date]) }}',
                                                        method: 'GET',
                                                        success: function(data) {
                                                        // this.next().innerText = data.count;
                                                        document.getElementById('messageBox').classList.add('show');
                                                        document.getElementById('message').innerText = j++;
                                                        },
                                                        error: function(error) {
                                                            console.log('Error:', error);
                                                        }
                                                    });
                                                }
                                                document.getElementById('messageBox').classList.add('show');
                                        //     },
                                        //
                                        //     error: function(error) {
                                        //         console.log('Error:', error);
                                        //     }
                                        // })
                                        // }, 2000)
                                        // ;
                                        //alert(count);



                                    " class="btn btn-primary">
                                        <span id="btnText{{$date}}">Bulk send</span>
                                        <span id="spinner{{$date}}" class="spinner-border spinner-border-lg" role="status" aria-hidden="true" style="display:none;"></span>
                                    </a>
                                </td>
                                <td class="align-middle text-center" onload="
                                    setInterval($.ajax({
                                        url: '{{ route("images.sentCount", ['date' => $date]) }}',
                                        method: 'GET',
                                        success: function(data) {
                                            this.text(data.count);
                                        },
                                        error: function(error) {
                                            console.log('Error:', error);
                                        }
                                    }), 1000);
                                ">{{$images->where('sent', '1')->count()}}</td>
                                <td class="align-middle text-center">{{$images->where('sent', '0')->count()}}</td>
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
    <script>
        // document.getElementById('bulkSendBtn').addEventListener('click', function() {
        //     this.classList.add('disabled'); // Disable the button when clicked
        // });

         function bulkSendSpinner() {
             // alert('hello');
            var button = this;
            var spinner = document.getElementById('spinner');
            var btnText = document.getElementById('btnText');

            // Hide the button text
            btnText.style.display = 'none';

            // Show the spinner
            spinner.style.display = 'inline-block';

            // Disable the button
            button.classList.add('disabled');
        };
    </script>
@endsection
