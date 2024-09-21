@extends('backend.layout.root', ['title' => 'Create Package']);
@section('content')
    <div class="card shadow mb-4 p-5">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-around">
            <div class="col-md-8">
                <h2 class="text-2xl font-semi-bold text-gray-800 mb-4">Create Package</h2>
                <form action="{{ route('customer.assignToPackage', ['customer' => $customer]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="package_id" class="form-label">Select a package:</label>
                        <select name="package_id" id="" class="form-control">
                            <option disabled value="">Select a package</option>
                            @foreach($packages as $package)
                                <option value="{{$package->id}}">{{$package->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Selling price:</label>
                        <input type="number" id="selling_price" name="selling_price" placeholder="Selling Price" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Package start from:</label>
                        <input type="date" id="start_date" name="start_date" placeholder="Package start from" class="form-control">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
