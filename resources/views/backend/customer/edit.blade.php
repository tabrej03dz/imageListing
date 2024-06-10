@extends('backend.layout.root', ['title' => 'Edit Customer'])

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Customer</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.update', ['customer' => $customer]) }}" method="post">
        @csrf

        <div class="row">

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" value="{{ $customer->name }}" class="form-control" placeholder="Name">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" value="{{ $customer->email }}" class="form-control" placeholder="Email">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone 1:</label>
                    <input type="text" id="phone" name="phone" value="{{ $customer->phone }}" class="form-control" placeholder="Phone 1">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone1" class="form-label">Phone 2:</label>
                    <input type="text" id="phone1" name="phone1" value="{{ $customer->phone1 }}" class="form-control" placeholder="Phone 2">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="business_name" class="form-label">Business Name:</label>
                    <input type="text" id="business_name" name="business_name" value="{{ $customer->business_name }}" class="form-control" placeholder="Business Name">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="country" class="form-label">Country:</label>
                    <select id="country" name="country" class="form-select form-control">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}" {{$country->id == $customer->country ? 'selected' : ''}}>{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="state" class="form-label">State:</label>
                    <select name="state" id="state" class="form-control">
                        <option value="">Select State</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="city" class="form-label">City:</label>
                    <input type="text" id="city" name="city" value="{{ $customer->city }}" class="form-control" placeholder="City">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" id="address" name="address" value="{{ $customer->address }}" class="form-control" placeholder="Address">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="pin" class="form-label">Pin Code:</label>
                    <input type="number" id="pin" name="pin" value="{{ $customer->pin }}" class="form-control" placeholder="Pin Code">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="gst_number" class="form-label">GST Number:</label>
                    <input type="text" id="gst_number" name="gst_number" value="{{ $customer->gst_number }}" class="form-control" placeholder="GST Number">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select id="status" name="status" class="form-select form-control">
                        <option value="">Select Status</option>
                        <option value="1" {{$customer->status == '1' ? 'selected' : ''}}>Active</option>
                        <option value="0" {{$customer->status == '0' ? 'selected' : ''}}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Category:</label>
                    @php
                        $userCatIds = \App\Models\UserCategory::where('user_id', $customer->id)->pluck('category_id');
                        $selectedCategories = \App\Models\Category::whereIn('id', $userCatIds)->get();

                    @endphp
                    @if($selectedCategories->count() > 0)
                        <div class="d-flex flex-wrap mt-3"> <!-- Add mt-3 for top margin and flex-wrap to allow wrapping of alert boxes -->
                            @foreach($selectedCategories as $selectedCat)
                                <div class="alert alert-info alert-dismissible fade show m-1" role="alert"> <!-- Add m-1 for margin and max-width for limiting width -->
                                    {{$selectedCat->name}}
                                    <a href="{{route('customer.category.delete', ['category' => $selectedCat, 'customer' => $customer])}}" type="button" class="close"  aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <select name="category_id[]" multiple id="" class="form-control">
                        <option value="" disabled>Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Languages:</label>

                    @php
                        $userLangIds = \App\Models\UserLanguage::where('user_id', $customer->id)->pluck('language_id');
                        $selectedLanguages = \App\Models\Language::whereIn('id', $userLangIds)->get();

                    @endphp

                    @if($selectedLanguages->count() > 0)
                        <div class="d-flex flex-wrap mt-3"> <!-- Add mt-3 for top margin and flex-wrap to allow wrapping of alert boxes -->
                            @foreach($selectedLanguages as $selectedLang)
                                <div class="alert alert-info alert-dismissible fade show m-1" role="alert"> <!-- Add m-1 for margin and max-width for limiting width -->
                                    {{$selectedLang->name}}
                                    <a href="{{route('customer.language.delete', ['language' => $selectedLang, 'customer' => $customer])}}" type="button" class="close"  aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <select name="language_id[]" multiple id="" class="form-control">
                        <option value="" disabled>Select Language</option>
                        @foreach($languages as $language)
                            <option value="{{$language->id}}">{{$language->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>


    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    <script>
        jQuery(document).ready(function(){
            // Fetch states when the document is ready
            fetchStates();

            // Fetch states when the country dropdown value changes
            jQuery('#country').change(function(){
                fetchStates();
            });

            function fetchStates() {
                let cid = jQuery('#country').val();
                if (cid) {
                    jQuery.ajax({
                        url: '/getState',
                        type: 'post',
                        data: {
                            cid: cid,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (result){
                            jQuery('#state').html(result);
                        }
                    });
                }
            }

            // Uncomment to enable fetching cities when state changes
            // jQuery('#state').change(function(){
            //     let sid = jQuery(this).val();
            //     jQuery.ajax({
            //         url: '/getCity',
            //         type: 'post',
            //         data: {
            //             sid: sid,
            //             _token: '{{csrf_token()}}'
            //         },
            //         success: function (result){
            //             jQuery('#city').html(result);
            //         }
            //     });
            // });
        });

    </script>

@endsection
