@extends('frontLayout', ['title' => 'Search Image'])
@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        {{--                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>--}}

                        <div class="col-lg-12">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    <li>{{session('error')}}</li>
                                </div>
                            @endif

                            <div class="p-5">
                                <span class="badge bg-danger text-white">Notes</span>
                                <p style="margin-bottom: 10px;" class="text-center">Please enter your registered mobile number</p>
                                <p style="margin-bottom: 20px;" class="text-center">कृपया अपना रजिस्टर मोबाइल नंबर दर्ज करें</p>
                                <div>

                                <div class="text-center mt-3">
                                    <h1 class="h4 text-gray-900 mb-4">Search Your Images!</h1>
                                </div>
                                <form class="user" action="{{route('imgSearch')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user"
                                               id="search" name="search" aria-describedby="emailHelp"
                                               placeholder="Enter Your Phone No.." style="border: 2px solid #dc3545; border-radius: 5px;">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Search
                                    </button>
                                </form>
                                <hr>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div>
                                        <a href="https://wa.me/915123573747" target="_blank" class="btn btn-success">Get help</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <script>



        </script>

@endsection

