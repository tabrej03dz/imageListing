@extends('backend.layout.root', ['title' => 'Create Customer'])

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

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create Customer</h2>

    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Name" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone 1:</label>
                    <input type="text" id="phone" name="phone" placeholder="Phone 1" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="business_name" class="form-label">Business Name:</label>
                    <input type="text" id="business_name" name="business_name" placeholder="Business Name" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="country" class="form-label">Country:</label>
                    <select id="country" name="country" class="form-select form-control">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}" {{$country->name == 'India' ? 'selected' : ''}}>{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">City:</label>
                    <input type="text" id="city" name="city" placeholder="City" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="pin" class="form-label">Pin Code:</label>
                    <input type="number" id="pin" name="pin" placeholder="Pin Code" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select id="status" name="status" class="form-select form-control">
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Category:</label>
                    <select name="category_id[]" multiple id="" class="form-control">
                        <option value="" disabled>Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="phone1" class="form-label">Phone 2:</label>
                    <input type="text" id="phone1" name="phone1" placeholder="Phone 2 optional" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" id="address" name="address" placeholder="Address" class="form-control">
                </div>


                <div class="mb-3">
                    <label for="state" class="form-label">State:</label>
                    <select id="state" name="state" class="form-select form-control">
                        <option value="">Select State</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="gst_number" class="form-label">GST Number:</label>
                    <input type="text" id="gst_number" name="gst_number" placeholder="GST Number" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Languages:</label>
                    <select name="language_id[]" multiple id="" class="form-control">
                        <option value="" disabled>Select Language</option>
                        @foreach($languages as $language)
                            <option value="{{$language->id}}">{{$language->name}}</option>
                        @endforeach
                    </select>
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
