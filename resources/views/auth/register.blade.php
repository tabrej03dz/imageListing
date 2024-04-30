@extends('frontLayout', ['title' => 'Register'])

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
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Register Now!</h1>
                                </div>
                                <form class="user" action="{{route('register')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                               id="name" name="name" aria-describedby="emailHelp"
                                               placeholder="Enter Name...">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                               id="email" name="email" aria-describedby="emailHelp"
                                               placeholder="Enter Email Address...">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                               id="phone" name="phone" aria-describedby="emailHelp"
                                               placeholder="Enter Phone..." required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                               id="password" name="password" placeholder="Password">
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                               id="password" name="confirm_password" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Register
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

