@extends('backend.layout.root', ['title' => 'Add Payment'])
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

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create Category</h2>

    <form action="{{ route('payment.make', ['customerPackage' => $customerPackage]) }}" method="POST" >
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Amount:</label>
            <input type="number" id="amount" name="amount" placeholder="Amount" class="form-control" min="0" step="0.01">
        </div>

        <div class="mb-3">
            <label for="payment_method" class="form-label">Mode of Payment:</label>
            <input type="text" id="payment_method" name="payment_method" placeholder="Mode of Payment" class="form-control">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
